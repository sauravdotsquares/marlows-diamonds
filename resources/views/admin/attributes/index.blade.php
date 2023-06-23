@extends('layouts.admin.app')
@section('content')

    <section class="content search-container  {{ request()->search_open == 'open' ? '' : 'd-none' }}">
        <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h3 class="card-title">Search here</h3>
                    </div>
                    <form method="GET">
                        <input name="search_open" type="hidden" class="form-control" id="search_open" value="open">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <input name="name" type="text" class="form-control" id="name" value="{{ request()->name }}" placeholder="Search by name">
                                </div>
                                <div class="form-group col-md-6">
                                    <input name="slug" type="text" class="form-control" id="slug" value="{{ request()->slug }}" placeholder="Search by slug">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">Search</button>
                            <a href="{{ url('admin/attributes') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    @if (session()->has('alert-success'))
                        <div class="alert alert-success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            {{ session()->get('alert-success') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header text-right">
                            <a href="{{ url('admin/attributes/create') }}" class="btn btn-primary">Add New Attribute</a>
                            <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                         </div>
                        <div class="card-body">
                            <table id="" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Values</th>
                                        <!-- <th>Status</th> -->
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($attributes))
                                        @foreach ($attributes as $attribute)
                                            <tr class="{{ $attribute->is_deleted ? 'bg-danger' : '' }}"
                                                title="{{ $attribute->is_deleted ? 'This record is deleted' : '' }}">
                                                <td>{{ $attribute->name }}</td>
                                                <td>{{ $attribute->slug }}</td>
                                                <td>{{ $attribute->values }}</td>
                                                <!-- <td>{{ $attribute->status }}</td> -->
                                                <td>{{ $attribute->created_at }}</td>
                                                <td>
                                                    @if ($attribute->status == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/attributes/status/' . base64_encode($attribute->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/attributes/status/' . base64_encode($attribute->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif

                                                    <a title="Edit"
                                                        href="{{ url('admin/attributes/update/' . base64_encode($attribute->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>

                                                    @if ($attribute->is_deleted)
                                                        <a class="confirm-and-reload" title="Restore deleted record ?"
                                                            href="{{ url('admin/delete-attribute/' . base64_encode($attribute->id)) }}?revert=true"><i
                                                                class="fa fa-trash-restore" aria-hidden="true"></i></a>
                                                    @else
                                                        <a class="confirm-and-reload" title="Delete Record ?"
                                                            href="{{ url('admin/delete-attribute/' . base64_encode($attribute->id)) }}"><i
                                                                class="fa fa-trash" aria-hidden="true"></i></a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Values</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="pagination-container float-right">
                              
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

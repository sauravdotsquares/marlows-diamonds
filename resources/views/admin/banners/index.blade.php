@extends('layouts.admin.app')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('admin/banners/create') }}"><button type="button"
                                    class="btn btn-primary add-button">Add New Banner</button></a>
                        </div>

                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>

                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($banners))
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td>{{ $banner->title }}</td>

                                                <td>{{ $banner->created_at }}</td>
                                                <td>
                                                    @if ($banner->status == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/banners/status/' . base64_encode($banner->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/banners/status/' . base64_encode($banner->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif
                                                    <a title="Edit"
                                                        href="{{ url('admin/banners/update/' . base64_encode($banner->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>
                                                    <a
                                                        href="{{ url('admin/delete-banner/' . base64_encode($banner->id)) }}"
                                                        class="confirm-and-reload" title="Permanent Delete this record?"><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>

                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

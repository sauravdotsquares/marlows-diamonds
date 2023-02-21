@extends('layouts.admin.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('admin/popups/create') }}"><button type="button"
                                    class="btn btn-primary add-button">Add New Popup</button></a>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($popups))
                                        @php($i = 1)
                                        @foreach ($popups as $popup)
                                            <tr>
                                                <td>{{ $popup->title }}</td>
                                                <td><?php echo html_entity_decode($popup->description); ?></td>
                                                <td>{{ $popup->created_at }}</td>
                                                <td>
                                                    @if ($popup->status == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/popups/status/' . base64_encode($popup->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/popups/status/' . base64_encode($popup->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif
                                                    <a title="Edit"
                                                        href="{{ url('admin/popups/update/' . base64_encode($popup->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>
                                                    <a class="confirm-and-reload" title="Permanent Delete this record?"
                                                        href="{{ url('admin/delete-popup/' . base64_encode($popup->id)) }}"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Content</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
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

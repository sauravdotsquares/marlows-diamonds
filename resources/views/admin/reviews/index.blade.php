@extends('layouts.admin.app')
@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('admin/reviews/create') }}">
                                <button type="button" class="btn btn-primary add-button">Add New Review</button>
                            </a>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Rating</th>
                                        <th>Reviews</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($reviews))
                                        @php($i = 1)
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td>{{ $review->title }}</td>
                                                <td>{{ $review->rating }}</td>
                                                <td><?php echo html_entity_decode($review->description); ?></td>
                                                <td>{{ $review->created_at }}</td>
                                                <td>
                                                    @if ($review->status == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/reviews/status/' . base64_encode($review->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/reviews/status/' . base64_encode($review->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif
                                                    <a title="Edit"
                                                        href="{{ url('admin/reviews/update/' . base64_encode($review->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>
                                                    <a class="confirm-and-reload" title="Permanent Delete this Record?"
                                                        href="{{ url('admin/delete-review/' . base64_encode($review->id)) }}"><i
                                                            class="fa fa-trash" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Rating</th>
                                        <th>Reviews</th>
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

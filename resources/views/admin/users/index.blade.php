@extends('layouts.admin.app')
@section('content')

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="{{ url('admin/users/create') }}"><button type="button" class="btn btn-primary add-button">Add New User</button></a>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Nice Name</th>
                                        <th>Role</th>
                                        <th>Description</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($getData))
                                        @foreach ($getData as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->nicename }}</td>
                                                <td>Customer</td>
                                                <td><?php echo html_entity_decode($user->description); ?></td>
                                                <td>{{ $user->created_at }}</td>
                                                <td>
                                                    @if ($user->is_active == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/users/status/' . base64_encode($user->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/users/status/' . base64_encode($user->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif
                                                    <a title="Edit"
                                                        href="{{ url('admin/users/update/' . base64_encode($user->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>
                                                    <a title="Delete This record ?"
                                                    class="confirm-and-reload"
                                                        href="{{ url('admin/delete-user/' . base64_encode($user->id)) }}"
                                                        ><i class="fa fa-trash"
                                                            aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Nice Name</th>
                                        <th>Role</th>
                                        <th>Description</th>
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

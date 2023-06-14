@extends('layouts.admin.app')

@section('content')
    @if (Session::has('success'))
        <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                Session::forget('success');
            @endphp
        </div>
    @endif

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
                                        <input name="name" type="text" class="form-control" id="name" value="{{ request()->name }}" placeholder="Search by Name">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input name="slug" type="text" class="form-control" id="slug" value="{{ request()->slug }}" placeholder="Search by Slug">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <input name="meta_title" type="text" class="form-control" id="meta_title" value="{{ request()->meta_title }}" placeholder="Search by Meta title">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Search</button>
                                <a href="{{ url('admin/products/categories') }}" class="btn btn-primary">Reset</a>
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
                    <div class="card">
                        <div class="row">
                            <div class="col-12">
                                <div class="card-header text-right">
                                    <a href="{{ url('admin/products/categories/create') }}" class="btn btn-primary">Add New Category</a>
                                    <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Sr No</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Parent</th>
                                        <th>Meta Title</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($getData as $key => $value)
                                        <tr>
                                            <td>{{ $getData->firstItem()+ $key }}</td>
                                            <td>{{ $value->name }}</td>

                                            <td>{{ $value->slug }}</td>
                                            <td>{{ $value->parent_details }}</td>
                                            <td>{!! $value->meta_title !!}</td>
                                            <td>{{ $value->created_at }}</td>
                                            <td>
                                                @if ($value->status == 1)
                                                    <a title="Change Status" href="javascript:void(0);" class="statusSwitch"
                                                        data-record="{{ $value->id }}" data-value="0"><i
                                                            class="fa fa-check" aria-hidden="true"></i></a>
                                                @else
                                                    <a title="Change Status" href="javascript:void(0);" class="statusSwitch"
                                                        data-record="{{ $value->id }}" data-value="1"><i
                                                            class="fa fa-times" aria-hidden="true"></i></a>
                                                @endif
                                                <a title="Edit"
                                                    href="{{ asset('admin/products/categories/create/' . $value->slug) }}"
                                                    class="btn btn-warning btn-sm"><i class="fa fa-edit "
                                                        aria-hidden="true"></i></a>
                                                <a title="Permanent Delete this record?"
                                                    href="{{ asset('admin/delete-categories') }}?id={{ $value->id }}"
                                                    class="confirm-and-reload btn btn-danger btn-sm"><i class="fa fa-trash"
                                                        aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pagination-container float-right">
                                {{ $getData->appends($_GET)->links('layouts.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <div id="myModal" class="modal fade" role="dialod">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                    </h4>
                    <button class="close" type="button" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="deleteContent">
                        Are you sure want to delete <span class="title"></span>?
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn actionBtn" data-dismiss="modal">
                        <span id="footer_action_button"></span>
                    </button>
                    <button type="button" class="btn btn-warning" data-bs-dismiss="modal">
                        <span class="glyphicon glyphicon"></span> Close
                    </button>
                    <input type="hidden" name="themeId" value="" />
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {

            $('.statusSwitch').on('click', function() {
                $.ajax({
                    type: 'POST',
                    url: '{{ asset('admin/change-categories') }}',
                    data: {
                        '_token': "{{ csrf_token() }}",
                        'id': $(this).data('record'),
                        'status': $(this).data('value')
                    },
                    success: function(responseText) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Changed",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    }
                })
            });

            $(document).on('click', '.delete-modal', function() {
                roe = $(this).parent('id').parent('tr');
                $('#footer_action_button').text('Delete');
                $('#footer_action_button').removeClass('glyphicon-check');
                $('#footer_action_button').addClass('glyphicon-trash');
                $('.actionBtn').removeClass('btn-success');
                $('.actionBtn').removeClass('btn-danger');
                $('.actionBtn').addClass('delete');
                $('.modal-title').text('Delete ?');
                $('.modal-footer').find('input[name=themeId]').val($(this).data('value').id);
                $('.deleteContent').show();
                $('.form-horizontal').hide();
                $('.title').html($(this).data('value').title);
                $('#myModal').modal('show');
            });


            $('.modal-footer').on('click', '.delete', function() {
                let themeId = $('input[name=themeId]').val();
                $.ajax({
                    type: "POST",
                    url: '{{ asset('admin/delete-categories') }}',
                    data: {
                        "_token": "{{ csrf_token() }}",
                        'id': themeId,
                    },
                    success: function(res) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "Deleted",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.reload();
                    }
                });
            });

        })
    </script>
@endsection

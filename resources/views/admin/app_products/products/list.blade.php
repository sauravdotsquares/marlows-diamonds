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
                                    <div class="form-group col-6">
                                        <input autocomplete="off" name="title" type="text" class="form-control" id="title" value="{{ request()->title }}" placeholder="{{__('Search by title')}}">
                                    </div>
                                    <div class="form-group col-6">
                                        <input autocomplete="off" name="slug" type="text" class="form-control" id="slug" value="{{ request()->slug }}" placeholder="{{__('Search by slug')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Search</button>
                                <a href="{{ route('admin.app_products.list') }}" class="btn btn-primary">Reset</a>
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
                        

                        <div class="card-header">
                            <a href="{{ route('admin.app_products.basic_information') }}" class="btn btn-primary add-button">Add New product</a>
                            <a href="javascript:;" style="float: right;" class="btn btn-primary search-button"><i class="fa fa-search"></i></a>
                        </div>
                        
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Slug</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($data->count()){ ?>
                                        <?php foreach ($data as $data_key => $data_value) { ?>
                                            <tr>
                                                <td>{{ show_dots($data_value->title) }}</td>
                                                <td>{{ show_dots($data_value->slug) }}</td>
                                                <td>{{ $data_value->created_at }}</td>
                                                <td>
                                                    <?php if($data_value->is_active){ ?>
                                                        <a title="{{ __('Inactivate Product') }}" href="{{ route('admin.app_products.change_status', $data_value->slug) }}" class="btn btn-info btn-sm confirm_first">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </a>
                                                    <?php }else{ ?>
                                                        <a title="{{ __('Activate product') }}" href="{{ route('admin.app_products.change_status', $data_value->slug) }}" class="btn btn-success btn-sm confirm_first">
                                                            <i class="fa fa-check" aria-hidden="true"></i>
                                                        </a>
                                                    <?php } ?>
                                                    <a title="{{ __('Edit') }}" href="{{ route('admin.app_products.edit_basic_information', $data_value->slug) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-edit " aria-hidden="true"></i>
                                                    </a>
                                                    <a title="{{ __('Delete Product') }}" href="{{ route('admin.app_products.delete', $data_value->slug) }}" class="btn btn-danger btn-sm confirm_first">
                                                        <i class="fa fa-trash " aria-hidden="true"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                        <td colspan="4" style="text-align: center;">No records found</td>
                                    <?php } ?>
                                </tbody>
                            </table>
                            <div class="pagination-items">
                                {{ $data->appends($_GET)->links('layouts.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


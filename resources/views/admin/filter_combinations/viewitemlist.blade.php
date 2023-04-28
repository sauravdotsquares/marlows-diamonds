@extends('layouts.admin.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Filter name</th>
                                    <th>Filter Item Name</th>
                                    <th>Filter Item slug</th>
                                    <th>Value</th>
                                    <th>Type</th>
                                    <th>Top Text</th>
                                    <th>Bottom Text</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                

                                <?php if($getSlugItemData->count()){ ?>
                                    @foreach($getSlugItemData as $key => $data)
                                   
                                        <tr>
                                            <td>{{++$key}}</td>
                                            <td>{{$data->parent_filter_name}}</td>
                                            <td>{{$data->item_name}}</td>
                                            <td>{{$data->item_slug}}</td>
                                            <td>{{$data->item_value}}</td>
                                            <td>{{$data->item_type}}</td>
                                            <td>{{$data->top_text}}</td>
                                            <td>{{$data->bottom_text}}</td>
                                            <td><span class="date-format" date="{{$data->created_at}}"></span></td>
                                            <td>
                                                <?php if($data->is_active){ ?>
                                                    <small class="badge badge-success">Active</small>
                                                <?php }else{ ?>
                                                    <small class="badge badge-danger">Inactive</small>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                @if($data->is_active)
                                                    <a title="Change status" class="btn btn-outline-danger btn-sm confirm_first" href="{{ route($route_path. '.itemstatus', ['slug'=> $data->id ] ) }}">Inactive</a>
                                                @else
                                                    <a title="Change status" class="btn btn-outline-success btn-sm confirm_first" href="{{ route($route_path. '.itemstatus', ['slug'=> $data->id ] ) }}">Activate</a>
                                                @endif
                                                <a title="Edit record" class="btn btn-outline-info btn-sm" href="{{ route($route_path. '.itemedit', ['slug'=> $data->id ] ) }}">Edit</a>
                                                <a title="Change status" class="btn btn-outline-success btn-sm confirm_first" href="{{ route($route_path. '.itemdelete', ['slug'=> $data->id ] ) }}">Delete</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No records found</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination-container float-right">
                          
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
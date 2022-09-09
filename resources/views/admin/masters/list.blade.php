@extends('layouts.admin.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{  route('admin.masters.add',['type'=> $masterType]) }}" class="btn btn-primary add-button float-right">
                            Add Record 
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>S.N.</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Slug</th>
                                    <th>Created</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($dataToPass->count()){ ?>
                                    @foreach($dataToPass as $key => $data)
                                        <tr>
                                            <td>{{$dataToPass->firstItem() + $key}}</td>
                                            <td>{{$data->name}}</td>
                                            <td>{{$data->value}}</td>
                                            <td>{{$data->slug}}</td>
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
                                                    <a title="Change status" class="btn btn-outline-danger btn-sm confirm_first" href="{{ route('admin.masters.status', ['type'=> $masterType, 'slug'=> $data->slug ] ) }}">Inactive</a>
                                                @else
                                                    <a title="Change status" class="btn btn-outline-success btn-sm confirm_first" href="{{ route('admin.masters.status', ['type'=> $masterType, 'slug'=> $data->slug ] ) }}">Activate</a>
                                                @endif
                                                <a title="Edit record" class="btn btn-outline-info btn-sm" href="{{ route('admin.masters.edit', ['type'=> $masterType, 'slug'=> $data->slug ] ) }}">Edit</a>
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
                            {{ $dataToPass->appends($_GET)->links('layouts.pagination') }}
                        </div>
                    </div>
                </div>            
            </div>        
        </div>
    </div>
</section>
@endsection
@extends('layouts.admin.app')
@section('css')

@endsection
@section('content')
<div class="content">
    <section class="content">
      <!-- <div class="container-fluid">
         <form id="cmsForm" action="{{ url('admin/posts/add') }}" enctype="multipart/form-data" method="post" >
            @csrf
            <div class="row">
               <div class="col-md-8 offset-md-2">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Add Users</h3>
                     </div>
                     <div class="card-body">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Title</label>
                              <input type="text" id="title" name="title" class="form-control" placeholder="Title" >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Sub title</label>
                              <input type="text" id="subtitle" name="subtitle" class="form-control" placeholder="Subtitle" >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Slug</label>
                              <input type="text" id="slug" name="slug" class="form-control" placeholder="Slug" >
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Short Description</label>
                              <textarea id="short_description" name="short_description" class="form-control"></textarea>                    
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Description</label>
                              <textarea id="description" name="description" class="form-control ckeditor"></textarea>                    
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="card card-header">
                     <div class="form-group">
                        <label for="exampleInputFile">Banner Image</label>
                        <div class="input-group">
                           <div class="custom-file">
                              <input type="file" id="image" name="image" class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1">Enable</option>
                              <option value="0">Disable</option>
                           </select>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <label for="product_name">Meta Title</label>
                           <input type="text" id="meta_title" name="meta_title" class="form-control" placeholder="Meta Title" >
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="form-label-group">
                           <textarea id="meta_description" name="meta_description" class="form-control ckeditor" placeholder="Meta Description" ></textarea>                    
                        </div>
                     </div>
                     <div class="form-group">
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>
                  </div>
               </div>
            </div>
         </form>
      </div> -->
      
    </section>
</div>
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-6">
                        <div class="card-header">
                            <h3 class="card-title">Add New Post</h3>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card-header1">
                            <button><a href="javascript:void()" id="addForm">Add</a></button>
                        </div>
                    </div>
                </div>
               
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Nice Name</th>
                           <th>Role</th>
                           <th>Description</th>
                           <th>Status</th>
                           <th>Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody> 
                        @foreach($getData as $value)
                            <tr>
                                <td>{{$value->name}}</td>
                                <td>{{$value->email}}</td>
                                <td>{{$value->nicename}}</td>
                                <td>{{$value->user_role}}</td>
                                <td>{{$value->description}}</td>
                                <td>{{$value->is_active}}</td>
                                <td>{{$value->created_at}}</td>
                                <td>
                                    @if($value->status == 1) 
                                        <a title="Change Status" href="{{ url('admin/posts/status/'.base64_encode($value->id).'/0')}}"><i class="fa fa-check " aria-hidden="true"></i></a>
                                    @else
                                        <a title="Change Status" href="{{ url('admin/posts/status/'.base64_encode($value->id).'/1')}}"><i class="fa fa-times " aria-hidden="true"></i></a>  
                                    @endif  
                                    <a title="Edit" href="{{ url('admin/posts/update/'.base64_encode($value->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                                    <a title="Delete" href="{{ url('admin/delete-post/'.base64_encode($value->id))}}" onclick="return myFunction()"><i class="fa fa-trash" aria-hidden="true"></i></a>
                                </td>
                            </tr> 
                        @endforeach
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Nice Name</th>
                            <th>Role</th>
                            <th>Description</th>
                            <th>Status</th>
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

@section('js')
<script>
    // $(document).ready()
</script>
@endsection

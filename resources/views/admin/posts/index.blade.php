@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <a href="{{ url('admin/posts/create')}}"><button type="button" class="btn btn-primary add-button">Add New Blog</button></a>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Title</th>
                           <th>Slug</th>
                           <th>Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($posts))  
                        @php ($i = 1)  
                        @foreach($posts as $post)
                        <tr>
                           <td>{{$post->title}}</td>
                           <td>{{$post->slug}}</td>
                           <td>{{$post->created_at}}</td>
                           <td>
                              @if($post->status == 1) 
                              <a title="Change Status" href="{{ url('admin/posts/status/'.base64_encode($post->id).'/0')}}"><i class="fa fa-check " aria-hidden="true"></i></a>
                              @else
                              <a title="Change Status" href="{{ url('admin/posts/status/'.base64_encode($post->id).'/1')}}"><i class="fa fa-times " aria-hidden="true"></i></a>  
                              @endif  
                              <a title="Edit" href="{{ url('admin/posts/update/'.base64_encode($post->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                              <a title="Delete" href="{{ url('admin/delete-post/'.base64_encode($post->id))}}" onclick="return myFunction()"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                        @php ($i++)  
                        @endforeach
                        @endif
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Title</th>
                           <th>Slug</th>
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

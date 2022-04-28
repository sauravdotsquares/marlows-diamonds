@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
		 @if(session()->has('alert-success'))
            <div class="alert alert-success">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-success') }}
            </div>
          @endif
            <div class="card">
               <div class="card-header">
                  <a href="{{ url('admin/pages/create')}}"><button type="button" class="btn btn-primary add-button">Add New Page</button></a>
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
                        @if(!empty($pages))  
                        
                        @foreach($pages as $page)
                        <tr>
                           <td>{{$page->title}}</td>
                           <td>{{$page->slug}}</td>
                           <td>{{$page->created_at}}</td>
                           <td>
                              @if($page->status == 1) 
                              <a title="Change Status" href="{{ url('admin/pages/status/'.base64_encode($page->id).'/0')}}"><i class="fa fa-check " aria-hidden="true"></i></a>
                              @else
                              <a title="Change Status" href="{{ url('admin/pages/status/'.base64_encode($page->id).'/1')}}"><i class="fa fa-times " aria-hidden="true"></i></a>  
                              @endif  
                              <a title="Edit" href="{{ url('admin/pages/update/'.base64_encode($page->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                              <a title="Delete" href="{{ url('admin/delete-page/'.base64_encode($page->id))}}" onclick="return myFunction()"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                       
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

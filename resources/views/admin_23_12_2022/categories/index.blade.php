@extends('layouts.admin.app')

@section('content')
      @if(Session::has('success'))
         <div class="alert alert-success">
            {{ Session::get('success') }}
            @php
                  Session::forget('success');
            @endphp
         </div>
      @endif
      
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="row">
                  
                  <div class="col-12">
                     <div class="card-header">
                        <!-- <button><a href="javascript:void()" id="addForm">Add</a></button> -->
                        <a href="{{asset('admin/products/categories/create')}}">
                           <button type="button" class="btn btn-primary">
                              Add New Category
                           </button>
                        </a>
                     </div>
                  </div>
               </div>

               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
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
                        @foreach($getData as $key => $value)
                           <tr>
                              <td>{{++$key}}</td>
                              <td>{{$value->name}}</td>
                              
                              <td>{{$value->slug}}</td>
                              <td>{{$value->parent_details}}</td>
                              <td>{!!$value->meta_title!!}</td>
                              <td>{{$value->created_at}}</td>
                              <td>
                                 @if($value->status == 1)
                                    <a title="Change Status"
                                    href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="0"><i
                                       class="fa fa-check" aria-hidden="true"></i></a>
                                 @else
                                    <a title="Change Status"
                                    href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="1"><i
                                       class="fa fa-times" aria-hidden="true"></i></a>
                                 @endif
                                 <a title="Edit" href="{{asset('admin/products/categories/create/'.$value->slug)}}" class="btn btn-warning btn-sm"><i class="fa fa-edit " aria-hidden="true"></i></a>
                                 <a title="Delete" href="javascript:void(0);" class="delete-modal btn btn-danger btn-sm" data-value="{{$value}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Meta Title</th>
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

<!-- Button trigger modal -->

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
    $(document).ready(function(){
       
         $('.statusSwitch').on('click',function(){
               $.ajax({
                  type:'POST',
                  url:'{{asset("admin/change-categories")}}',
                  data:{
                  '_token':"{{csrf_token()}}",
                  'id':$(this).data('record'),
                  'status':$(this).data('value')
                  },
                  success:function(responseText){
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

         $(document).on('click','.delete-modal',function(){
               roe=$(this).parent('id').parent('tr');
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


         $('.modal-footer').on('click','.delete',function(){
            let themeId = $('input[name=themeId]').val();
            $.ajax({
               type:"POST",
               url:'{{asset("admin/delete-categories")}}',
               data:{
                  "_token": "{{ csrf_token() }}",
                  'id':themeId,
               },
               success:function(res){
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
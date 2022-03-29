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
                  <div class="col-6">
                     <div class="card-header">
                        <h3 class="card-title">Category</h3>
                     </div>
                  </div>
                  <div class="col-6">
                     <div class="card-header1">
                        <!-- <button><a href="javascript:void()" id="addForm">Add</a></button> -->
                        <a href="{{asset('admin/products/categories/create')}}">
                           <button type="button" class="btn btn-primary">
                              Add
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
                           <th>Image</th>
                           <th>Slug</th>
                           <th>Parent</th>
                           <th>Description</th>
                           <th>Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($getData as $key => $value)
                           <tr>
                              <td>{{++$key}}</td>
                              <td>{{$value->name}}</td>
                              <td>{{$value->image_url}}</td>
                              <td>{{$value->slug}}</td>
                              <td>Parent</td>
                              <td>{{$value->description}}</td>
                              <td>{{$value->created_at}}</td>
                              <td>
                                 @if($value->is_active == 1)
                                    <a title="Change Status"
                                    href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="0"><i
                                       class="fa fa-check" aria-hidden="true"></i></a>
                                 @else
                                    <a title="Change Status"
                                    href="javascript:void(0);" class="statusSwitch" data-record="{{$value->id}}" data-value="1"><i
                                       class="fa fa-times" aria-hidden="true"></i></a>
                                 @endif
                                 <a title="Edit" href="javascript:void(0);" class="btn btn-warning btn-sm data_edit" data-value="{{$value}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                                 <a title="Delete" href="javascript:void(0);" class="delete-modal btn btn-danger btn-sm" data-value="{{$value}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                              </td>
                           </tr>
                        @endforeach
                     </tbody>
                     <tfoot>
                        <tr>
                            <th>Sr No</th>
                            <th>Name</th>
                            <th>Image</th>
                            <th>Slug</th>
                            <th>Parent</th>
                            <th>Description</th>
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
        // $('#description').summernote();

        $('#addformdata').on('click',function(){
            getBlankForm();
            $('#addEditFormModal').modal('show');
        });
      
        //validation and form submission function here
        $('form#addEditForm').validate({
            rules:{
                name:{
                required:true,
                },
                password:{
                required: function () {
                    if($('input[name="table_id"]').val() == ''){
                        return true;
                    }else{
                        return false;
                    }
                },
                },
                confirm_password:{
                required: function () {
                    if($('input[name="table_id"]').val() == ''){
                        return true;
                    }else{
                        return false;
                    }
                },
                },
                email:{
                required:true,
                email:true,
                },
                username:{
                required:false,
                },
                description:{
                required:false,
                },
            },
            messages:{
                name:{
                required:"Name is required",
                },
                password:{
                required:"Password is required",
                },
                confirm_password:{
                required:"Confirm Password is required",
                equalTo : '#password',
                },
                email:{
                required:"Email is required",
                email:"Enter email is valid format",
                },
                username:{
                required:"Username is required",
                },
                description:{
                required:"Description is required",
                }
            },
            submitHandler:function(form){
                var form_data = new FormData(form);
                $.ajax({
                type:"POST",
                url:'{{asset("admin/users")}}',
                cache:false,
                contentType:false,
                processData:false,
                data:form_data,
                success:function(res){
                    if($.isEmptyObject(res.error)){
                        // alert(res.success);
                        $('#addEditModal').modal('hide');
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: res.success,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }else{
                        printErrorMsg(res.error);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: res.success,
                            showConfirmButton: false,
                            timer: 1500
                        });   
                    }
                    location.reload();
                }
                });
            }
        });

        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

        function getBlankForm(){
            $('#table_id').data('');
            $('#name').data('');
            $('#email').data('');
            $('#username').data('');
            $('#nicename').data('');
            $('#description').data('');
        }

        $('.data_edit').on('click',function(){
            getBlankForm();
            // console.log(value);
            $('#table_id').val($(this).data('value').id);
            $('#name').val($(this).data('value').name);
            $('#email').val($(this).data('value').email);
            $('#username').val($(this).data('value').username);
            $('#nicename').val($(this).data('value').nicename);
            $('#description').val($(this).data('value').description);
            $('#addEditFormModal').modal('show');
        });

      
        $('.statusSwitch').on('click',function(){
            $.ajax({
                type:'POST',
                url:'{{asset("admin/change-record")}}',
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
            url:'{{asset("admin/delete-record")}}',
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
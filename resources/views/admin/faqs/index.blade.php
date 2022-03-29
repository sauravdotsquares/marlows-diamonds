@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Add New Faq</h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Question</th>
                           <th>Answer</th>
                           <th>Created</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($faqs))  
                        @php ($i = 1)  
                        @foreach($faqs as $faq)
                        <tr>
                           <td>{{$faq->title}}</td>
                           <td><?php echo html_entity_decode($faq->description);?></td>
                           <td>{{$faq->created_at}}</td>
                           <td>
                              @if($faq->status == 1) 
                              <a title="Change Status" href="{{ url('admin/faqs/status/'.base64_encode($faq->id).'/0')}}"><i class="fa fa-check " aria-hidden="true"></i></a>
                              @else
                              <a title="Change Status" href="{{ url('admin/faqs/status/'.base64_encode($faq->id).'/1')}}"><i class="fa fa-times " aria-hidden="true"></i></a>  
                              @endif  
                              <a title="Edit" href="{{ url('admin/faqs/update/'.base64_encode($faq->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                              <a title="Delete" href="{{ url('admin/delete-faq/'.base64_encode($faq->id))}}" onclick="return myFunction()"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                        @php ($i++)  
                        @endforeach
                        @endif
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Question</th>
                           <th>Answer</th>
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

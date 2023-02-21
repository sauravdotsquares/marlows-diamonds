@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <h3 class="card-title">Enquiries</h3>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Message</th>
                           <th>Date</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($enquiries))  
                        @php ($i = 1)  
                        @foreach($enquiries as $enquiry)
                        <tr>
                           <td>{{$enquiry->title}}</td>
						   <td>{{$enquiry->email}}</td>
                           <td><?php echo html_entity_decode($enquiry->description);?></td>
                           <td>{{$enquiry->created_at}}</td>
                           <td>
                              <a title="Edit" href="{{ url('admin/enquiries/update/'.base64_encode($enquiry->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                              <a class="confirm-and-reload" title="Permanent Delete this record?" href="{{ url('admin/delete-enquiry/'.base64_encode($enquiry->id))}}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                        @php ($i++)  
                        @endforeach
                        @endif
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Name</th>
                           <th>Email</th>
                           <th>Message</th>
                           <th>Date</th>
                           <th>Actions</th>
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

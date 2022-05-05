@extends('layouts.admin.app')
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <div class="col-12">
            <div class="card">
               <div class="card-header">
                  <a href="{{ url('admin/faqs/categories/create')}}"><button type="button" class="btn btn-primary add-button">Add New Faq category</button></a>
               </div>
               <!-- /.card-header -->
               <div class="card-body">
                  <table id="example2" class="table table-bordered table-hover">
                     <thead>
                        <tr>
                           <th>Faq Category</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @if(!empty($faqcategories))  
                        @php ($i = 1)  
                        @foreach($faqcategories as $faq)
                        <tr>
                           <td>{{$faq->title}}</td>
                           <td>
                              <a title="Edit" href="{{ url('admin/faqcategories/update/'.base64_encode($faq->id))}}"><i class="fa fa-edit " aria-hidden="true"></i></a>
                              <a title="Delete" href="{{ url('admin/delete-faqcategories/'.base64_encode($faq->id))}}" onclick="return myFunction()"><i class="fa fa-trash" aria-hidden="true"></i></a>
                           </td>
                        </tr>
                        @php ($i++)  
                        @endforeach
                        @endif
                     </tbody>
                     <tfoot>
                        <tr>
                           <th>Faq Category</th>
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

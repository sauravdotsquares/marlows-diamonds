@extends('layouts.admin.app')

@section('content')
 <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Add New Page</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
					<th>ID</th>
                    <th>Page Name</th>
                    <th>Page Description</th>
					<th>Action</th>
                  </tr>
                  </thead>
                  
                  <tbody>
                   @if(!empty($pages))  
                   @php ($i = 1)  
				           @foreach($pages as $page)
                    <tr>
                      <td>{{$i}}</td>
                      <td>{{$page->title}}</td>
                      <td><?php echo html_entity_decode($page->description);?></td>
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
					          @php ($i++)  
                    @endforeach
                    @endif
                  </tbody>
                
                  <tfoot>
                  <tr>
                    <th>ID</th>
					<th>Page Name</th>
					<th>Page Description</th>
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
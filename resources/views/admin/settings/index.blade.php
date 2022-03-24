@extends('layouts.admin.app')

@section('content')
 
<div id="content-wrapper">
  <div class="container-fluid">
      <!-- Breadcrumbs-->
      @if(session()->has('alert-danger'))
        <div class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-danger') }}
        </div>
      @endif
      @if(session()->has('alert-success'))
        <div class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-success') }}
        </div>
      @endif
     

      

      <!-- DataTables Example -->
      <div class="card mb-3">
        <div class="card-header">
          <i class="fas fa-table"></i> Settings
        </div>
        <div class="card-body">
          <form action="{{ url('admin/settings-update') }}" enctype="multipart/form-data" method="post">
           @csrf 
            <div class="col-lg-12">
              <table class="table table-bordered" id="" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Option Name</th>
                      <th>Option Value</th>
                    </tr>
                  </thead>
                  
                  <tbody>
				          @foreach($settings as $option)
                    <tr>
                      <td>{{$option->option_name}}</td>
					            <td>
								
                      <input type="{{$option->option_type}}" name="option_value[{{$option->id}}][]" class="form-control" placeholder="Option Value" value="{{$option->option_value}}">
                        @if($option->option_type=='file' && $option->option_value!='')
                           <img src="{{url('/')}}/images/{{$option->option_value}}" width="120">
                        @endif
                      </td>
                    </tr>
					        @endforeach
                  </tbody>
              </table>
              <div class="form-group">
                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Save">
                </div>
              </div>          
            </div>
          </form>
        </div>
      </div>
  </div>
</div>
<!-- Sticky Footer -->
@endsection
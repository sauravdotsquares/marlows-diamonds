@extends('layouts.admin.app')

@section('content')


   <section class="content search-container  {{ request()->search_open == 'open' ? '' : 'd-none' }}">
      <div class="container-fluid">
         <div class="row">
            <div class="col-md-12">
               <div class="card card-success">
                     <div class="card-header">
                        <h3 class="card-title">Search here</h3>
                     </div>
                     <form method="GET">
                        <input name="search_open" type="hidden" class="form-control" id="search_open" value="open">
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-6">
                                    <input name="clarity" type="text" class="form-control" id="clarity" value="{{ request()->clarity }}" autocomplete="off" placeholder="Search by clarity">
                                </div>
                                <div class="form-group col-6">
                                    <input name="color" type="text" class="form-control" id="color" value="{{ request()->color }}" autocomplete="off" placeholder="Search by color">
                                </div>
                                <div class="form-group col-6">
                                    <input name="carat" type="text" class="form-control" id="carat" value="{{ request()->carat }}" autocomplete="off" placeholder="Search by carat">
                                </div>
                                <div class="form-group col-6">
                                    <input name="price" type="text" class="form-control" id="price" value="{{ request()->price }}" autocomplete="off" placeholder="Search by price">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">Search</button>
                            <a href="{{ route('admin.lab_price_variations.list') }}" class="btn btn-primary">Reset</a>
                        </div>
                    </form>
               </div>
            </div>
         </div>
      </div>
   </section>

      
   <section class="content">
      <div class="container-fluid">
         <div class="row">
            <div class="col-12">
               <div class="card">
                  <div class="card-header text-right">
                     <a href="{{route('admin.lab_price_variations.add')}}"><button type="button" class="btn btn-primary">Add Record</button></a>
                     <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                  </div>

                  <div class="card-body">
                     <table id="" class="table table-bordered table-hover">
                        <thead>
                           <tr>
                              <th>Sr No</th>
                              <th>Clarity</th>
                              <th>Color</th>
                              <th>Carat</th>
                              <th>Price</th>
                              <th>Created</th>
                              <th>Status</th>
                              <th>Action</th>
                           </tr>
                        </thead>
                        <tbody>
                           @if(isset($data) && !$data->isEmpty())
                              @foreach($data as $key => $value)
                                 <tr>
                                    <td>{{$data->firstItem() + $key}}</td>
                                    <td>{{$value->clarity }}</td>
                                    <td>{{$value->color }}</td>
                                    <td>{{$value->carat }}</td>
                                    <td>{{$value->price }}</td>
                                    <td>{{date('d M Y H:i:s', strtotime($value->created_at))}}</td>
                                    <td>
                                        @if ($value->is_active == 1)
                                            <small class="badge badge-success">Active</small>
                                        @else
                                            <small class="badge badge-danger">In-Active</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($value->is_active == 1)
                                            <a title="Update status ?" href="{{ route('admin.lab_price_variations.change_status', $value->id) }}" type="button" class="btn btn-danger btn-sm confirm_first">In-Activate</a>
                                        @else
                                            <a title="Update status ?" href="{{ route('admin.lab_price_variations.change_status', $value->id) }}" type="button" class="btn btn-primary btn-sm confirm_first">Activate</a>
                                        @endif
                                        <a type="button" href="{{ route('admin.lab_price_variations.edit', $value->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <a type="button" title="Delete record ?" href="{{ route('admin.lab_price_variations.delete', $value->id) }}" class="btn btn-danger btn-sm confirm_first">Delete</a>
                                    </td>
                                    
                                 </tr>
                              @endforeach
                           @else
                              No record found
                           @endif
                        </tbody>
                     </table>
                     <div class="pagination-container float-right">
                        {{ $data->appends($_GET)->links('layouts.pagination') }}
                  </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>

@endsection
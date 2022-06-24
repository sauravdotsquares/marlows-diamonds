@extends('layouts.admin.app')

@section('content')

@if (\Session::has('success'))
    <div class="alert alert-success">
        <ul>
            <li>{!! \Session::get('success') !!}</li>
        </ul>
    </div>
@endif
@if (\Session::has('error'))
    <div class="alert alert-error">
        <ul>
            <li>{!! \Session::get('error') !!}</li>
        </ul>
    </div>
@endif
@if ($errors->any())
   <div class="alert alert-danger">
      @foreach ($errors->all() as $error)
         {{$error}}
      @endforeach
   </div>
@endif
<div class="content">
   <!-- DataTables Example -->
   <section class="content">
        <div class="container-fluid">
            <form id="addForm" action="{{ asset('admin/creatediscount') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <input type="hidden" name="table_id" id="table_id" value="{{isset($getDiscountData->id)?$getDiscountData->id:''}}">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Discount</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="name">Choose Category</label>
                                        <select name="category_id" class="form-control" id="category_id">
                                            <option value="">Choose Any</option>
                                            @foreach($getParentCategory as $key => $cate)
                                                <option value="{{$cate->id}}" @if(isset($getDiscountData) && $getDiscountData->category_id == $cate->id) selected @endif>{{$cate->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="title">Discount(%)</label>
                                        <input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" value="{{isset($getDiscountData->discount)?$getDiscountData->discount:''}}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="title">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" placeholder="End Date" value="{{isset($getDiscountData->end_date)?$getDiscountData->end_date:''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-header">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <select id="status" name="status" class="form-control">
                                        <option value="">Select Status</option>
                                        @if(isset($getData->status) && $getData->status == 1)
                                            <option value="1" selected>Enable</option>
                                            <option value="0">Disable</option>
                                        @elseif(isset($getData->status) && $getData->status == 0)
                                            <option value="1">Enable</option>
                                            <option value="0" selected>Disable</option>
                                        @else
                                            <option value="1" selected>Enable</option>
                                            <option value="0">Disable</option>
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
   </section>
</div>
<!-- Sticky Footer -->

@endsection

@section('js')
    <script>

    </script>
@endsection

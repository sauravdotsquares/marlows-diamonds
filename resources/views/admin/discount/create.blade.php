@extends('layouts.admin.app')

@section('content')

<?php
    // echo "<pre>";
    // print_r($getDiscountData->discount_range_details[0]['discount']);
    // die;

?>

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
                                        <label for="category_id">Choose Category</label>
                                        <select name="category_id" class="form-control" id="category_id">
                                            <option value="">Choose Any</option>
                                            @foreach($getParentCategory as $key => $cate)
                                                <option value="{{$cate->id}}" @if(isset($getDiscountData) && $getDiscountData->category_id == $cate->id) selected @endif>{{$cate->name}}</option>
                                            @endforeach
                                            <option value="18" @if(isset($getDiscountData) && $getDiscountData->category_id == 18) selected @endif>Multi-Stone</option>
                                        </select>
                                    </div>
                                </div>
                                

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="diamond_type">Diamond type</label>
                                        <select class="form-control" name="diamond_type" id="diamond_type">
                                            <option value="" selected>Select diamond type</option>
                                            <option value="mined"  {{ !empty($getDiscountData) && $getDiscountData->diamond_type=="mined" ? 'selected' : '' }}  >Mined</option>
                                            <option value="lab_grown" {{ !empty($getDiscountData) && $getDiscountData->diamond_type=="lab_grown" ? 'selected' : '' }}>Lab grown</option>
                                        </select>
                                        {{-- <input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" value="{{isset($getDiscountData->discount)?$getDiscountData->discount:''}}"> --}}
                                    </div>
                                </div>

                                

                                {{-- <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="diamond_type">Diamond type</label>
                                        <select class="form-control" name="diamond_type" id="diamond_type">
                                            <option value="" selected>Select diamond type</option>
                                            <option value="mined_diamond" {{ !empty($getDiscountData) && $getDiscountData->diamond_type=="mined_diamond" ? 'selected' : '' }}  >Mined</option>
                                            <option value="lab_grown" {{ !empty($getDiscountData) && $getDiscountData->diamond_type=="lab_grown" ? 'selected' : '' }}>Lab grown</option>
                                        </select>
                                    </div>
                                </div> --}}

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="discount">Discount(%)</label>
                                        <input type="text" id="discount" name="discount" class="form-control" placeholder="Discount" value="{{isset($getDiscountData->discount)?$getDiscountData->discount:''}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="inc_percentage">Increase(%)</label>
                                        <input type="text" id="inc_percentage" name="inc_percentage" class="form-control" placeholder="Increase" value="{{isset($getDiscountData->inc_percentage)?$getDiscountData->inc_percentage:''}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="title">End Date</label>
                                        <input type="date" id="end_date" name="end_date" class="form-control" placeholder="End Date" value="{{isset($getDiscountData->end_date)?$getDiscountData->end_date:''}}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="custom-control custom-checkbox">
                                        <input name="is_login_users" class="custom-control-input custom-control-input-success custom-control-input-outline" type="checkbox" id="is_login_users" {{  empty($getDiscountData->is_login_users)  ? '' : 'checked' }}>
                                        <label for="is_login_users" class="custom-control-label">Is this discount is applicable for login users only</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card card-primary">
                            <div>
                                <div class="card-header">
                                    <h3 class="card-title">Add Discount Price Ranges</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        {{-- <label for="from">From</label>
                                        <label for="from">To</label>
                                        <label for="from">Discount</label> --}}
                                        {{-- <input type="text" id="range1_from" name="range1_from" readonly value="0">
                                        <input type="text" id="range1_to" name="range1_to" readonly value="1000">

                                        <input type="text" id="discount_range1" name="discount_range1" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[0]['discount'])?$getDiscountData->discount_range_details[0]['discount']:''}}"> --}}
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range1_from" name="range1_from" readonly value="0">
                                        <input type="text" id="range1_to" name="range1_to" readonly value="1000">

                                        <input type="text" id="discount_range1" name="discount_range1" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[0]['discount'])?$getDiscountData->discount_range_details[0]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range2_from" name="range2_from" readonly value="1001">
                                        <input type="text" id="range2_to" name="range2_to" readonly value="2000">

                                        <input type="text" id="discount_range2" name="discount_range2" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[1]['discount'])?$getDiscountData->discount_range_details[1]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range3_from" name="range3_from" readonly value="2001">
                                        <input type="text" id="range3_to" name="range3_to" readonly value="3000">

                                        <input type="text" id="discount_range3" name="discount_range3" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[2]['discount'])?$getDiscountData->discount_range_details[2]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range4_from" name="range4_from" readonly value="3001">
                                        <input type="text" id="range4_to" name="range4_to" readonly value="5000">

                                        <input type="text" id="discount_range4" name="discount_range4" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[3]['discount'])?$getDiscountData->discount_range_details[3]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range5_from" name="range5_from" readonly value="5001">
                                        <input type="text" id="range5_to" name="range5_to" readonly value="10000">

                                        <input type="text" id="discount_range5" name="discount_range5" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[4]['discount'])?$getDiscountData->discount_range_details[4]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range6_from" name="range6_from" readonly value="10001">
                                        <input type="text" id="range6_to" name="range6_to" readonly value="15000">

                                        <input type="text" id="discount_range6" name="discount_range6" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[5]['discount'])?$getDiscountData->discount_range_details[5]['discount']:''}}">
                                    </div>
                                    <div class="form-group">
                                        <input type="text" id="range7_from" name="range7_from" readonly value="15001">
                                        <input type="text" id="range7_to" name="range7_to" readonly value="1500000">

                                        <input type="text" id="discount_range7" name="discount_range7" placeholder="Discount" value="{{isset($getDiscountData->discount_range_details[6]['discount'])?$getDiscountData->discount_range_details[6]['discount']:''}}">
                                    </div>
                                    {{-- <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="discount">Discount(%)</label>

                                        </div>
                                    </div> --}}
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
@endsection

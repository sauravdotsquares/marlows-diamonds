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
            <form id="addForm" action="{{ asset('admin/createmargin') }}" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Add Margin</h3>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <div class="form-label-group">
                                        <label for="api_type">Choose API Type</label>
                                        <select name="api_type" class="form-control" id="api_type">
                                            <option value="">Choose Any</option>
                                            <option value="harikrishna" @if(isset($apiType) && $apiType == 'harikrishna') selected @endif>Hari Krishna</option>
                                            <option value="rapnet" @if(isset($apiType) && $apiType == 'rapnet') selected @endif>Rapnet</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="card card-primary">
                            <div>
                                <div class="card-header">
                                    <h3 class="card-title">Add API Margin Price Ranges</h3>
                                </div>
                                <div class="card-body">
                                    @if(isset($getApiMarginData) && count($getApiMarginData))
                                        @php 
                                            $i = 1;
                                        @endphp
                                        @foreach($getApiMarginData as $key => $value)
                                        <div class="form-group">
                                            <input type="text" id="from_price{{$i}}" name="from_price{{$i}}" value="{{$value->from_price}}">
                                            <input type="text" id="to_price{{$i}}" name="to_price{{$i}}" value="{{$value->to_price}}">
                                            <input type="text" id="percentage{{$i}}" name="percentage{{$i}}" placeholder="Margin Percentage" value="{{$value->percentage}}">
                                        </div>
                                        @php 
                                            $i = $i+1;
                                        @endphp
                                        @endforeach
                                    @else
                                        <div class="form-group">
                                            <input type="text" id="from_price1" name="from_price1" value="0">
                                            <input type="text" id="to_price1" name="to_price1" value="1000">
                                            <input type="text" id="percentage1" name="percentage1" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price2" name="from_price2" value="1001">
                                            <input type="text" id="to_price2" name="to_price2" value="2000">
                                            <input type="text" id="percentage2" name="percentage2" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price3" name="from_price3" value="2001">
                                            <input type="text" id="to_price3" name="to_price3" value="3000">
                                            <input type="text" id="percentage3" name="percentage3" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price4" name="from_price4" value="3001">
                                            <input type="text" id="to_price4" name="to_price4" value="5000">
                                            <input type="text" id="percentage4" name="percentage4" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price5" name="from_price5" value="5001">
                                            <input type="text" id="to_price5" name="to_price5" value="10000">
                                            <input type="text" id="percentage5" name="percentage5" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price6" name="from_price6" value="10001">
                                            <input type="text" id="to_price6" name="to_price6" value="15000">
                                            <input type="text" id="percentage6" name="percentage6" placeholder="Margin Percentage" value="">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="from_price7" name="from_price7" value="15001">
                                            <input type="text" id="to_price7" name="to_price7" value="1500000">
                                            <input type="text" id="percentage7" name="percentage7" placeholder="Margin Percentage" value="">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-header">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

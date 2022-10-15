@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <form id="cmsForm" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __("Variations")}}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($attributes as $attributes_key => $attributes_value) { ?>
                                    <div class="form-group col-sm-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="attributes[]" value="{{ $attributes_value['id'] }}">
                                            <label class="form-check-label">{{ $attributes_value['name'] }}</label>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-label-group col-sm-12 col-md-4" style="float: right;">
                                <button type="submit" class="btn btn-success btn-block">Next</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
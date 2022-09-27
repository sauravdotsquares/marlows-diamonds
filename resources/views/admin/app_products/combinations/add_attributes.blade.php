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
                            <h3 class="card-title">{{ __("Add new combination")}}</h3>
                        </div>

                        <?php $old = session()->getOldInput(); ?>

                        <div class="card-body">
                            <div class="form-group">
                                <div class="form-label-group">
                                    <label for="product_name">{{ __("Combination Name")}}</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ request()->old('name') }}" placeholder="{{ __("Combination Name")}}">
                                    @error('name') <span class="custom-error">{{ $message }}</span>  @enderror
                                </div>
                            </div>

                            <h4> {{ __("Choose attributes")}} </h4>
                            <div class="form-group">
                                <?php foreach ($attributes as $attributes_key => $attributes_value) { ?>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $attributes_value->id }}" name="attributes[]"
                                        <?php echo $old && $old['attributes'] ? (in_array($attributes_value->id, $old['attributes']) ? 'checked' : '') : '' ?>
                                        >
                                        <label class="form-check-label">{{ $attributes_value->name }}</label>
                                    </div>
                                <?php } ?>
                                @error('attributes') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                            <br>
                            <div class="form-group">
                                <div class="form-label-group">
                                    <input type="submit" name="submit" class="btn btn-success" placeholder="{{ __("Combination Name")}}">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection
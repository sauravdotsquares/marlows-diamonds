@extends('layouts.admin.app')
@section('content')
    <div class="content">
        <section class="content">
            <div class="container-fluid">
                <form method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Add Seo Script</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="product_name">Page (Enter complete page url)</label>
                                            <input type="text" id="page" name="page" class="form-control" value="{{ old('page') }}"
                                                placeholder="{{url('/product/aaliyah-four-claw-split-shoulder-solitaire-diamond-ring')}}">
                                        </div>
                                        @error('page') <span class="custom-error">{{ $message }}</span>  @enderror
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="product_name">Header script</label>
                                            <textarea rows="6" id="header_script" placeholder="Header script" name="header_script" class="form-control">{{ old('header_script') }}</textarea>
                                            @error('header_script') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="product_name">Footer script</label>
                                            <textarea rows="6"  id="footer_script" placeholder="Footer script" name="footer_script" class="form-control">{{ old('footer_script') }}</textarea>
                                            @error('footer_script') <span class="custom-error">{{ $message }}</span>  @enderror
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

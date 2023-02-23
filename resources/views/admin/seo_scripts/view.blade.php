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
                                    <h3 class="card-title">View Seo Script</h3>
                                </div>
                                <div class="card-body">
                                    
                                    <div class="callout callout-info">
                                        <h5>Page</h5>
                                        <p><a href="{{ $record->page }}" target="_blank">{{ $record->page }}</a></p>
                                    </div>
                                    <div class="callout callout-info">
                                        <h5>Header Script</h5>
                                        <p>{{ $record->header_script }}</p>
                                    </div>
                                    <div class="callout callout-info">
                                        <h5>Footer Script</h5>
                                        <p>{{ $record->footer_script }}</p>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{ request()->input('back') ? request()->input('back') : route('admin.seo_scripts.list')  }}" type="submit" class="btn btn-primary">Back</a>
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

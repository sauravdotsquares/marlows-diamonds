@extends('layouts.admin.app')
@section('content')
    <div class="content">
        <section class="content">
            <div class="container-fluid">
                <form>
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
                                            <label for="product_name">Page</label>
                                            <input type="text" id="page" name="page" class="form-control"
                                                placeholder="Page">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="product_name">Header script</label>
                                            <textarea rows="6" id="description" placeholder="Header script" name="description" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-label-group">
                                            <label for="product_name">Footer script</label>
                                            <textarea rows="6"  id="description" placeholder="Footer script" name="description" class="form-control"></textarea>
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

@extends('layouts.admin.app')
@section('content')


<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title"> Add new record </h3>
                    </div>

                    <form method="POST">
                        <div class="card-body">

                            <input type="hidden" name="_token" value="{{csrf_token()}}" >

                            <div class="form-group">
                                <label for="name">Select parent id </label>
                                <select id="" name="parent_id" class="form-control">
                                    <option value="">Select parent id</option>
                                    <?php foreach ($parentData as $parent_key => $parent_value) { ?>
                                        <option {{ $parent_value->id == $data->parent_id ? 'selected' : '' }}  value="{{ $parent_value->id }}">{{ $parent_value->name }}</option>
                                    <?php } ?>
                                </select>
                                @error('parent_id') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                            <div class="form-group">
                                <label for="name">Name </label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ request()->old('name', $data->name) }}">
                                @error('name') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                            <div class="form-group">
                                <label for="value">Value </label>
                                <input type="text" class="form-control" id="value" name="value" placeholder="Enter value" value="{{ request()->old('value', $data->value) }}">
                                @error('value') <span class="custom-error">{{ $message }}</span>  @enderror
                            </div>

                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-info">Add</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
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
                                <div class="form-group">
                                    <input name="page" type="text" class="form-control" id="page" value="{{ request()->page }}" placeholder="Search by page">
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button type="submit" class="btn btn-success">Search</button>
                                <a href="{{ route('admin.seo_scripts.list') }}" class="btn btn-primary">Reset</a>
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
                            <a class="btn btn-primary add-button" href="{{ route('admin.seo_scripts.add') }}">Add New Script</a>
                            <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                        </div>
                        <div class="card-body">
                            @php $currentUrl = urlencode(request()->fullUrl()) @endphp
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Page</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($data))
                                        @php($i = 1)
                                        @foreach($data as $key => $record)
                                            <tr >
                                                <td>{{$data->firstItem() + $key}}</td>
                                                <td>  <a target="_blank" href="{{ $record->page }}">  {{ $record->page }} </a> </td>
                                                <td>{{ $record->created_at }}</td>
                                                <td>{!! $record->is_active ? '<small class="badge badge-success">Activated</small>' : '<small class="badge badge-danger">Deactivated</small>' !!}</td>
                                                <td>
                                                    <a title="View Record"
                                                        class="btn btn-sm btn-primary"
                                                        href="{{ route('admin.seo_scripts.view', $record->id) }}?back={{ $currentUrl }}">View</a>

                                                    @if ($record->is_active)
                                                        <a title="Deactivate Record ?"
                                                            href="{{ route('admin.seo_scripts.change_status', $record->id) }}"
                                                            class="confirm-and-reload btn btn-sm btn-warning"
                                                            >Deactivate</a>
                                                    @else
                                                        <a title="Activate Record ?"
                                                            href="{{ route('admin.seo_scripts.change_status', $record->id) }}"
                                                            class="confirm-and-reload btn btn-sm btn-danger"
                                                            >Activate</a>
                                                    @endif

                                                    <a title="Edit Record"
                                                        class="btn btn-sm btn-info"
                                                        href="{{ route('admin.seo_scripts.edit', $record->id) }}">Edit</a>

                                                    <a title="Delete Record ?"
                                                        class="confirm-and-reload btn btn-sm btn-danger"
                                                        href="{{ route('admin.seo_scripts.delete', $record->id) }}">Delete</a>
                                                </td>
                                            </tr>
                                        @endforeach
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

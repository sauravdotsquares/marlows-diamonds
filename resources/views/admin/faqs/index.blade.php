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
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <input name="title" type="text" class="form-control" id="title" value="{{ request()->title }}" placeholder="Search by Question">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-success">Search</button>
                            <a href="{{ url('admin/faqs') }}" class="btn btn-primary">Reset</a>
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
                        
                            {{-- <a href="{{ url('admin/faqs/create') }}"><button type="button"
                                    class="btn btn-primary add-button">Add New Faq</button></a> --}}
                        <div class="card-header text-right">
                            <a href="{{ url('admin/faqs/create') }}" class="btn btn-primary">Add New Faq</a>
                            <a href="javascript:;"><button type="button" class="btn btn-primary search-button"><i class="fa fa-search"></i></button></a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($faqs))
                                        @php($i = 1)
                                        @foreach ($faqs as $faq)
                                            <tr  class="{{$faq->is_deleted ? 'bg-danger' : '' }}">
                                                <td>{{ $faq->title }}</td>
                                                <td><?php echo html_entity_decode($faq->description); ?></td>
                                                <td>{{ $faq->created_at }}</td>
                                                <td>
                                                    @if ($faq->status == 1)
                                                        <a title="Change Status"
                                                            href="{{ url('admin/faqs/status/' . base64_encode($faq->id) . '/0') }}"><i
                                                                class="fa fa-check " aria-hidden="true"></i></a>
                                                    @else
                                                        <a title="Change Status"
                                                            href="{{ url('admin/faqs/status/' . base64_encode($faq->id) . '/1') }}"><i
                                                                class="fa fa-times " aria-hidden="true"></i></a>
                                                    @endif
                                                    <a title="Edit"
                                                        href="{{ url('admin/faqs/update/' . base64_encode($faq->id)) }}"><i
                                                            class="fa fa-edit " aria-hidden="true"></i></a>


                                                    {{-- {{ url('admin/delete-faq/' . base64_encode($faq->id)) }} --}}
                                                    <a class="confirm-and-reload" title="Permanent Delete this record?" href="{{ url('admin/delete-faq/' . base64_encode($faq->id)) }}">
                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                    </a>

                                                </td>
                                            </tr>
                                            @php($i++)
                                        @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Question</th>
                                        <th>Answer</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="pagination-container float-right">
                                {{ $faqs->appends($_GET)->links('layouts.pagination') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

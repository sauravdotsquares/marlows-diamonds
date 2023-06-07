 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">{{ !empty($page_title) ? $page_title :  $breadcrumbs[0]["name"] }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            @foreach($breadcrumbs as $breadcrumb)
                @if($loop->last)
                    <li class="breadcrumb-item active"><a href="{{ $breadcrumb["url"] }}">@if(isset($breadcrumb["icon"]))<i class="{{$breadcrumb["icon"]}}"></i> @endif {{$breadcrumb["name"]}}</a></li>
                @else
                    <li class="breadcrumb-item">@if(isset($breadcrumb["icon"]))<i
                                    class="{{$breadcrumb["icon"]}}"></i> @endif {{$breadcrumb["name"]}}</li>
                @endif
            @endforeach
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


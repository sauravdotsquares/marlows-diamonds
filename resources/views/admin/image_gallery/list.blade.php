@extends('layouts.admin.app')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route($routePath . 'add') }}?back={{ urlencode(url()->full()) }}" class="btn btn-primary add-button float-right">
                            Add media
                        </a>
                    </div>
                    <div class="card-body">
                        <table id="" class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Image Id</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Extension</th>
                                    <th>Uploaded at</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($images->count()){ ?>
                                    @foreach($images as $key => $image)
                                        <tr>
                                            <td>{{ $image->id }}</td>
                                            <td>
                                                <?php $fileType = extensionChecker($image->extension); ?>
                                                @if ($fileType == 'image')
                                                    <img style="height: 50px; width:50px;" src="{{ asset('uploads/' . $image->image ) }}">
                                                @elseif($fileType == 'video')
                                                    <video autoplay muted style="height: 50px; width:50px;">
                                                        <source src="{{ asset('uploads/' . $image->image ) }}" />
                                                    </video>
                                                @endif
                                            </td>
                                            <td>{{ $image->original_name }}</td>
                                            <td>{{ humanFileSize($image->size) }}</td>
                                            <td>{{ $image->extension }}</td>
                                            <td>{{ $image->created_at }}</td>
                                            <td>
                                                <a href="javascript:;" onclick="copyToClipboard('{{$image->id}}')" class="btn btn-sm btn-success" >Copy Id</a>
                                                <a href="{{ route('admin.image_gallery.deleteFile', $image->id) }}" title="Delete file permanently ?" class="btn btn-sm btn-danger confirm_first" >Delete</a>
                                                <a href="javascript:;" class="btn btn-sm btn-warning image-picker">Open image picker</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                <?php }else{ ?>
                                    <tr>
                                        <td colspan="7" style="text-align: center;">No records found</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="pagination-container float-right">
                            {{ $images->appends($_GET)->links('layouts.pagination') }}
                        </div>
                    </div>
                </div>            
            </div>        
        </div>
    </div>
</section>


<div class="modal fade" id="modal-media-picker">
	<div class="modal-dialog modal-xl">
	    <div class="modal-content">
            <div class="modal-body">
	            <h4 class="modal-title">Pick media</h4>

                <div class="imagesList"></div>

	        </div>
	        {{-- <div class="modal-header">
	            <h4 class="modal-title">Extra Large Modal</h4>
	            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span>
	            </button>
	        </div>
	        <div class="modal-body">
	            <p>One fine body&hellip;</p>
	        </div>
	        <div class="modal-footer justify-content-between">
	            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            <button type="button" class="btn btn-primary">Save changes</button>
	        </div> --}}
	    </div>
	</div>
</div>

@endsection


@section('js')
<script>
    function copyToClipboard(text) {
        if (window.clipboardData && window.clipboardData.setData) {
            showToaster('success', 'Image Id copied to clipboard');
            return window.clipboardData.setData("Text", text);
        }else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
            var textarea = document.createElement("textarea");
            textarea.textContent = text;
            textarea.style.position = "fixed";
            document.body.appendChild(textarea);
            textarea.select();
            try {
                showToaster('success', 'Image Id copied to clipboard');
                return document.execCommand("copy");
            }
            catch (ex) {
                console.warn("Copy to clipboard failed.", ex);
                return prompt("Copy to clipboard: Ctrl+C, Enter", text);
            }
            finally {
                document.body.removeChild(textarea);
            }
        }
    }


    const filesListUrl = "{{ route('admin.image_gallery.getFilesList') }}";
    const csrfToken  = "{{ csrf_token() }}";
    const fileBasePath  = "{{ asset('uploads') }}/";

    function loadData(url=null) {
        url = url ? url : filesListUrl;

        $(".next-page-btn").remove();
        var request = $.ajax({
            url: url,
            type: "POST",
            data: {
                '_token' : csrfToken 
            },
        });  
        request.done(function(response) {
            if(response.status == "success" && response.data.data.length){
                var imagesToShowHtml = "";
                response.data.data.forEach((file) => {
                    imagesToShowHtml += `<img src="${fileBasePath + file.image}" style="height:150px; width:150px; margin:20px; " class="img-thumbnail">`;
                });
                $(".imagesList").append(imagesToShowHtml);
                if(response.data.next_page_url){
                    var loadMoreBtn = `<a href="javascript:;" class="next-page-btn" data-url="${response.data.next_page_url}" onclick="nextPage(event)">Load More</a> `;
                    $(".imagesList").append(loadMoreBtn);
                }
            }
        });
        request.fail(function(jqXHR, textStatus) {
            showToaster('errror','Something went wrong please retry');
        });
    }

    $(".image-picker").on('click', function() {
        loadData(filesListUrl);
        $("#modal-media-picker").modal('show');
    });

    function nextPage(event) {
        const url = $(event.target).data('url');
        loadData(url);
    }



</script>
@endsection
@extends('layouts.admin.app')
@section('content')
<div class="content">
   <!-- Breadcrumbs-->
   @if(session()->has('alert-danger'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a> {{ session()->get('alert-danger') }}
   </div>
   @endif
   @if ($errors->has('title'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('title') }}
   </div>
   @endif
   @if ($errors->has('description[]'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('description[]') }}
   </div>
   @endif
   @if ($errors->has('status'))
   <div class="alert alert-danger">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>{{ $errors->first('status') }}
   </div>
   @endif

	<?php
		// echo "In the blade file<pre>";
		// print_r($banners->getBannerDetails[0]);
		// die;

	?>

   <!-- DataTables Example -->
   <section class="content">
      <div class="container-fluid">
         <form id="cmsForm" action="{{ url('admin/banners/edit/'.base64_encode($banners->id)) }}" enctype="multipart/form-data" method="post" id="cmsForm" >
            @csrf
            <div class="row">
               <div class="col-md-12">
                  <div class="card card-primary">
                     <div class="card-header">
                        <h3 class="card-title">Add Banner</h3>
                     </div>
                     <div class="card-body">
					 <div class="row">
					 <div class="col-md-5">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Title*</label>
                              <input type="text" id="title" name="title" class="form-control" value="{{ $banners->title }}" placeholder="Title" >
                           </div>
                        </div>
					 </div>
					 <div class="col-md-5">
						<div class="form-group">
							<div class="form-label-group">
							<label for="product_name">Select Page</label>
							  <select id="page_id" name="page_id" class="form-control"  autofocus="autofocus">
								<option value="">Select Page</option>
								@foreach($pages as $page)
								<option value = {{ $page->id }} {{ $page->id==$banners->page_id ? 'selected' : '' }} >{{ $page->title }}</option>
							@endforeach
							</select>
							</div>
						</div>
					 </div>
					 <div class="col-md-2">
					 <div class="form-group">
                        <div class="form-label-group">
						<label for="product_name">Status*</label>
                           <select id="status" name="status" class="form-control">
                              <option value="">Select Status</option>
                              <option value="1" {{ $banners->status=='1' ? 'selected' : '' }} >Enable</option>
                              <option value="0" {{ $banners->status=='0' ? 'selected' : '' }} >Disable</option>
                           </select>
                        </div>
						</div>
					 </div>
					 </div>
					 <div class="row">

					 <div class="col-md-5">
                        <div class="form-group">
                           <div class="form-label-group">
                              <label for="product_name">Description</label>
                               <textarea id="description" name="description[]" class="form-control ckeditor description" placeholder="Banner Description" >{!! $banners->getBannerDetails[0]->description !!}</textarea>
                           </div>
                        </div>
                     </div>
                       <div class="col-md-5">
						 <div class="form-group">
							<label for="exampleInputFile">Banner Image</label>
							<input type="hidden" name="ids[]" value="{{$banners->getBannerDetails[0]->id}}">
							<div class="input-group">
							    @if($banners->getBannerDetails[0]->image!='')
								    <img alt="{{$banners->getBannerDetails[0]->image}}" src="{{asset('storage').'/banners/'.$banners->getBannerDetails[0]->image}}" width="50px;">
                                @endif
							   <div class="custom-file">
                              <input type="file" id="image" name="image[]" value="{{ $banners->getBannerDetails[0]->image }}" class="custom-file-input" accept="image/*">
                              <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                           </div>
							</div>
						 </div>
					   </div>
					   <div class="col-md-2">
					    <div class="form-group"><label for="exampleInputFile"> &nbsp;</label>
					   <div class="input-group"><button type="button" name="add" id="add" class="btn btn-success">Add More</button>
					   </div>
					   </div>
					   </div>
					</div>
                      <div class="" id="dynamic_field" >
					  <?php $i = 1; ?>
					  @if($banners->getBannerDetails)
						@foreach($banners->getBannerDetails as $key => $bannerDetails)
                            <?php
                                // echo "<pre>";
                                // print_r($banners->getBannerDetails);
                                // die;

                            ?>
							@if($key>0)

								<div class="row" id="row{{$i}}" class="dynamic-added">
								<input type="hidden" name="ids[]" value="{{$bannerDetails->id}}">
									<div class="col-md-5">
										<div class="form-group">
											<div class="form-label-group">
												<label for="product_name">Description</label>
													<textarea id="description{{$i}}" name="description[]" class="form-control description">{{$bannerDetails->description}}</textarea>
											</div>
										</div>
									</div>
									<div class="col-md-5">
										<div class="form-group">
											<label for="exampleInputFile">Banner Image</label>
											<div class="input-group">
												<img alt="{{ $bannerDetails->image }}" width="50px;" src="{{asset('storage').'/banners/'.$bannerDetails->image}}" >
												<div class="custom-file">
													<input type="file" id="image{{$i}}" name="image[]" class="custom-file-input" accept="image/*">
														<label class="custom-file-label" for="exampleInputFile">Choose file</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-2">
										<button type="button" name="remove" id="{{$i}}" data-remove_id="{{$bannerDetails->id}}" class="btn btn-danger btn_remove">X</button>
									</div>
								</div>
							@endif
							<?php $i= $i+1; ?>
						@endforeach
					  @endif
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
<!-- Sticky Footer -->
@section('js')
<script>

$(document).on('change', '.custom-file-input', function (event) {
    $(this).next('.custom-file-label').html(event.target.files[0].name);
})

   $(function () {
     // Summernote
     $('.description').summernote({
		 height:250
	 })

   })
</script>
<input type="hidden" name="csrf-token" content="{{ csrf_token() }}">
<script>

    $(document).ready(function(){

      var postURL = "<?php echo url('addmore'); ?>";

      var i=1;


      $('#add').click(function(){

           i++;

           $('#dynamic_field').append('<div class="row" id="row'+i+'" class="dynamic-added"><div class="col-md-5"><div class="form-group"><div class="form-label-group"><label for="product_name">Description</label><textarea id="description'+i+'" name="description[]" class="form-control description"></textarea></div></div></div><div class="col-md-5"><div class="form-group"><label for="exampleInputFile">Banner Image</label><div class="input-group"><div class="custom-file"><input type="file" id="image'+i+'" name="image[]" class="custom-file-input" accept="image/*"><label class="custom-file-label" for="exampleInputFile">Choose file</label></div></div></div></div><div class="col-md-2"><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></div></div>');
			$('.description').summernote({
			height:250
			})

      });

		$(".btn_remove").click(function(){
			var id = $(this).data("remove_id");
			var token = $("input[name='csrf-token']").attr("content");
		    var button_id = $(this).attr("id");
			$.ajax(
			{
				//url: "delete-banner-image/"+id,

				 url: "{{ url('/admin/delete-banner-image/') }}/"+id,
				type: 'DELETE',
				data: {
					"id": id,
					"_token": token,
				},
				success: function (){

					//alert(button_id);
					   $('#row'+button_id).remove();
				}
			});

		});


      /* $(document).on('click', '.btn_remove', function(){

           var button_id = $(this).attr("id");

			console.log(button_id);


           $('#row'+button_id+'').remove();

      });   */


      $.ajaxSetup({

          headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

          }

      });


      $('#submit').click(function(){

           $.ajax({

                url:postURL,

                method:"POST",

                data:$('#add_name').serialize(),

                type:'json',

                success:function(data)

                {

                    if(data.error){

                        printErrorMsg(data.error);

                    }else{

                        i=1;

                        $('.dynamic-added').remove();

                        $('#add_name')[0].reset();

                        $(".print-success-msg").find("ul").html('');

                        $(".print-success-msg").css('display','block');

                        $(".print-error-msg").css('display','none');

                        $(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');

                    }

                }

           });

      });


      function printErrorMsg (msg) {

         $(".print-error-msg").find("ul").html('');

         $(".print-error-msg").css('display','block');

         $(".print-success-msg").css('display','none');

         $.each( msg, function( key, value ) {

            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');

         });

      }

    });

</script>


@endsection


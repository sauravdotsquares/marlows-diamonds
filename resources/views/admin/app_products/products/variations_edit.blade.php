@extends('layouts.admin.app')
@section('content')

<section class="content">
    <div class="container-fluid">
        <form id="variations_form" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{ __("Variations")}}</h3>
                        </div>
                        <div class="card-body" id="append-data">
                            {!! $form !!}
                        </div>
                        <div class="card-body">
                            <div class="form-label-group col-sm-12 col-md-4" style="float: right;">
                                <button type="submit" class="btn btn-success btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

@endsection

@section('js')
<script>
    $(document).on('click','.file-selector', function() {
        $(this).siblings('.file-field').trigger('click');
    });
    
    $(document).on('click','.add-btn', function(event) {
        const uniqueId = new Date().getTime() +''+ Math.floor(Math.random() * 100000);
        const dataInformation = $(this).parents('.data-information').clone().attr('id', uniqueId);
        $("#append-data").append(dataInformation);

        /** Change names of every element of box */
        const newBox = $("#"+uniqueId);
        newBox.find(".remove-btn").removeClass('d-none');
        newBox.find('img').addClass('d-none');
        newBox.find("input,select").each(function(index, element) {

            const isValueCarry = $(element).hasClass('value_carry');

            const name = $(element).attr('name').split('[');
            name[1] =  uniqueId +']';
            $(element).attr('name', name.join('['));

            if(!isValueCarry){
                $(element).val('');
            }
        });
    });

    $(document).on('click','.remove-btn', function(event) {
        $(this).parents('.data-information').remove();
    });


    $(document).on('change','.variation_image', function(event) {

        const $item = $(this);

        var reader = new FileReader();
        reader.readAsDataURL(event.target.files[0]);
        reader.onload = function(){

            /** extension check */
            const validFormats = ['jpg','jpeg','png','mp4','webp'];
            var extension = $item[0].files[0].name.split('.').pop().toLowerCase()
            if(!validFormats.includes(extension)){
                alert('Invalid file extension please choose ' + validFormats.join(', ') )
                return;
            }

            $item.siblings('video').addClass('d-none');
            $item.siblings('img').addClass('d-none');

            if(extension == 'mp4'){
                var video = $item.siblings('video');
                video.removeClass('d-none');
                video[0].src = reader.result;
                video[0].load();
                video[0].play();
            }else{
                $item.siblings('img').attr('src',reader.result).removeClass('d-none');
            }

            /** Set form data */
            var formData = new FormData();
            formData.append("file", $item[0].files[0]);

            /** Upload file */
            $.ajax({
                type: "POST",
                url: "{{ route('admin.app_products.upload_images') }}",
                headers: {
                    'IMAGE-TYPE' : 'variation',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'IMAGE-FROM': 'md_app_product_attribute_variations',
                },
                success: function (data) {
                    console.log('data', data)
                    if(data){
                        $item.siblings('#variation_image_id').val(data);
                    }
                    $item.val('');
                },
                error: function (error) {
                    alert('Something went wrong');
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        }

    });

    $(document).on('submit','#variations_form_remoe', function(event) {

        const form = $(this);

        let clientInfo= form.serialize();
        const searchParams = new URLSearchParams(clientInfo);
        clientInfo = Object.fromEntries(searchParams);
        const form_data = new FormData();
        form_data.append('data', JSON.stringify(clientInfo) )

        // console.log('form', form.serialize());
        event.preventDefault();

        $.ajax({
            type: "POST",
            url: "{{ route('admin.app_products.variations',  $product->slug ) }}",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            data: form_data,
            dataType: 'json',
            success: function (data) {
                console.log('data', data);
            },
            error: function (error) {
                console.log('error', error)
                // alert('Something went wrong');
            },
            async: true,
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });

    });
</script>
@endsection
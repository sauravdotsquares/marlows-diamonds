function imagePreview($item, event, img, inputName='file', limit=1, dataId='') {
    const imageLength = $(`input[name*='${inputName}']`).length;
    if(limit >= imageLength){
        var extension = event.target.files[0].name.split('.').pop().toLowerCase();
        let imageToPrint = `<div class="file_uploader-container">`;
        imageToPrint +=    `<i class="image-remover nav-icon fas fa fa-times"></i>`;
        if(extension == 'mp4'){
            imageToPrint += `<video autoplay muted class="file_uploader-video img-thumbnail"> <source src="${img}" /> </video>`;
        }else{
            imageToPrint += `<img class="file_uploader-img img-thumbnail" src="${img}" />`;
        }
        imageToPrint += `<input type="hidden" class="file_id" name="${inputName}[]" value="${dataId}" />`; //set image id 
        imageToPrint += `</div>`;

        $item.after(imageToPrint);
    }else{
        alert(`You can only upload ${limit} files`);
    }
}


function imageUploader($element, options) {

    const addImageUrl = options.addImageUrl ? options.addImageUrl : 0; if(!addImageUrl){  console.log('error'); return false;}
    const removeImageUrl = options.removeImageUrl ? options.removeImageUrl : 0; if(!removeImageUrl){  console.log('error'); return false;}
    const csrf = options.csrf ? options.csrf : 0; if(!csrf){  console.log('error'); return false;}
    const limit = options.limit ? options.limit : 10; if(!limit){  console.log('error'); return false;}
    const inputName = options.inputName ? options.inputName : 0; if(!inputName){  console.log('error'); return false;}
    const imgBasePath = options.imgBasePath ? options.imgBasePath + '/' : 0; if(!imgBasePath){  console.log('imgBasePath'); return false;}
    const selectedImages = options.selectedImages ? options.selectedImages : []; if(!selectedImages){  console.log('selectedImages'); return false;}
    const allowedExtensions = options.allowedExtensions ? options.allowedExtensions : []; if(!allowedExtensions){  console.log('allowedExtensions'); return false;}

    
    selectedImages.forEach( (element) => {
        var extension = element.image.split('.')[element.image.split('.').length-1];
        let imageToPrint = `<div class="file_uploader-container">`;
        imageToPrint +=    `<i class="image-remover nav-icon fas fa fa-times"></i>`;
        if(extension == 'mp4'){
            imageToPrint += `<video autoplay muted loop class="file_uploader-video img-thumbnail"> <source src="${imgBasePath+element.image}" /> </video>`;
        }else{
            imageToPrint += `<img class="file_uploader-img img-thumbnail" src="${imgBasePath+element.image}" />`;
        }
        imageToPrint += `<input type="hidden" class="file_id" name="${inputName}[]" value="${element.id}" />`; //set image id 
        imageToPrint += `</div>`;
        $($element).after(imageToPrint);
    });

    
    $(document).on('change', $element,  function(event) {

        $($element).attr('disabled',true);

        const globalExtensions = allowedExtensions.length ? allowedExtensions :  ['jpeg','png','jpg','png','webp','mp4','pdf'];
        const $item = $(this);
        const extension = event.target.files[0].name.split('.').pop().toLowerCase();

        if(!globalExtensions.includes(extension)){ 
            alert('Please select valid extension ' + globalExtensions.join(', ')); 
            $($element).removeAttr('disabled');
            return false; 
        };
    
        var reader = new FileReader();
        reader.onload = function(){
    
            /** Set form data */
            var formData = new FormData();
            formData.append("file", $item[0].files[0]);
    
            /** Upload file */
            $.ajax({
                type: "POST",
                url: addImageUrl,
                headers: {
                    'IMAGE-TYPE' : inputName,
                    'X-CSRF-TOKEN': csrf,
                    'IMAGE-FROM': inputName,
                },
                success: function (data) {
                    if(data){
                        imagePreview($item, event, reader.result,inputName, limit , data);
                    }
                    $item.val('');
                    $($element).removeAttr('disabled');
                },
                error: function (error) {
                    alert('Something went wrong');
                    $($element).removeAttr('disabled');
                },
                async: true,
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
    
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    $(document).on('click', '.image-remover',  function(event) {
        const $item = $(this);
        const id = $item.parents('.file_uploader-container').find('.file_id').val();
        

        if(id){
            /** Set form data */
            var formData = new FormData();
            formData.append("id",id);
            $.ajax({
                type: "POST",
                url: removeImageUrl,
                headers: {
                    'X-CSRF-TOKEN': csrf,
                },
                data: formData,
                dataType: 'json',
                success: function (data) {
                    $item.parents('.file_uploader-container').remove();
                },
                error: function (error) {
                    $item.parents('.file_uploader-container').remove();
                },
                async: true,
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        }else{
            $item.parents('.file_uploader-container').remove(); 
        }
    });
}




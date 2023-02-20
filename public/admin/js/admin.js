
$(document).on('click','.confirm_first', function(e) {
    e.preventDefault();
    
    const text = `Are you sure you want to ${$(this).attr('title')}`;
    Swal.fire({
        title: "Are you sure?",
        text: text,
        showCancelButton: true,
        confirmButtonText: 'Ok',
        icon: "warning",
    }).then((result) => {

        if (result.isConfirmed) {
            const url =  $(this).attr('href');
            var request = $.ajax({
                url: url,
                type: "POST",
                data: {
                    '_token' : csrf_token 
                },
            });  
            request.done(function(response) {
                showToaster(response.status, response.message);
                if(response.status == 'success'){
                    location.reload();
                }
            });
            request.fail(function(jqXHR, textStatus) {
                showToaster('errror','Something went wrong please retry');
            });
        }
    })
});



$(document).on('click','.confirm-and-reload', function(e) {
    e.preventDefault();
    
    const text = `Are you sure you want to ${$(this).attr('title')}`;
    Swal.fire({
        title: "Are you sure?",
        text: text,
        showCancelButton: true,
        confirmButtonText: 'Ok',
        icon: "warning",
    }).then((result) => {
        if (result.isConfirmed) {
            const url =  $(this).attr('href');
            window.location = url;
        }
    })
});


$(document).ready(function() {
    $('.date-format').each(function(event){
        const date = $(this).attr('date');
        
        if ( moment(date).isValid() ){
            const newDate = moment(date).format('MMMM d, YYYY')
            $(this).text(newDate);
        }else{
            $(this).text('N/A');
        }
    })
});

$(document).on('click','.search-button', function(e) {
    $(".search-container").toggleClass('d-none');
});


function imagePicker(element, options) {
    element.filepond({
        allowReorder: false,
        allowDrop: false,
        allowPaste: false,
        allowReplace: false,
        maxFileSize: '3MB',
        acceptedFileTypes: [
            'image/png', 
            'image/jpeg',
            'image/jpg',
        ],
        fileValidateTypeLabelExpectedTypesMap: {
            "image/png" : "PNG",
            "image/jpeg" : "JPEG",
            "image/jpg" : "JPG",
        },
        labelIdle: typeof options.placeholder!='undefined' && options.placeholder ? options.placeholder :  "Upload featured image",
        onprocessfile: function(error, file) {

            console.log('file', file);

            if(error){
                return;
            }

            if( typeof options.isMultipleUploading!='undefined' 
                && options.isMultipleUploading && 
                typeof options.inputName!='undefined' &&
                options.inputName
                ){
                    
                    $(`[name='${options.inputName}']`).attr('name',`${options.inputName}[]`);
            }
        },
        ...options,
    });
}

function videoPicker(element, options) {
    element.filepond({
        allowReorder: false,
        allowDrop: false,
        allowPaste: false,
        allowReplace: false,
        maxFileSize: '50MB',
        acceptedFileTypes: [
            'video/mp4', 
            'image/jpeg',
            'image/jpg',
        ],
        fileValidateTypeLabelExpectedTypesMap: {
            "video/mp4" : "Mp4",
        },
        labelIdle: typeof options.placeholder!='undefined' && options.placeholder ? options.placeholder :  "Upload featured image",
        onprocessfile: function(error, file) {
            if(error){
                return;
            }

            if( typeof options.isMultipleUploading!='undefined' 
                && options.isMultipleUploading && 
                typeof options.inputName!='undefined' &&
                options.inputName
                ){
                    
                    $(`[name='${options.inputName}']`).attr('name',`${options.inputName}[]`);
            }
        },
        ...options,
    });
}


/**
 * isInViewport
 * @returns 
 * check if element in viewport
 */
 $.fn.isInViewport = function() {
    var elementTop = $(this).offset().top;
    var elementBottom = elementTop + $(this).outerHeight();

    var viewportTop = $(window).scrollTop();
    var viewportBottom = viewportTop + $(window).height();

    return elementBottom > viewportTop && elementTop < viewportBottom;
};//endof isInViewport
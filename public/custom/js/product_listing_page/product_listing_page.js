$(document).ready(function () {

    //start
    $.validator.addMethod("phoneno", function (phone_number, element) {
        phone_number = phone_number.replace(/\s+/g, "");
        return phone_number.length > 9;
    }, "Please specify a valid phone number");

    jQuery.validator.addMethod("lettersonly", function (value, element) {
        return this.optional(element) || /^[a-z," "]+$/i.test(value);
    }, "Letters and spaces only please");

    // $(document).ready(function() {
    // $('[data-fancybox="gallery1"]').fancybox({
    //     afterLoad: function (instance, current) {
    //         current.$image.attr('alt', dataPhpVariable.title);
    //     }
    // });


    toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };
    // });

    jQuery.validator.addMethod(
        "noSpacesOnly",
        function (value, element) {
            return $.trim(value).length > 3;
        },
        "This field cannot be empty or contain only spaces."
    );

    $('form#contactForm').validate({
        rules: {
            title: {
                required: true,
                lettersonly: true,
                noSpacesOnly: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                digits: true,
                phoneno: true
            },
            description: {
                required: true,
                noSpacesOnly: true
            }
        },
        messages: {
            title: {
                required: 'Name is required',
                noSpacesOnly: "Name cannot be empty and must not contain spaces."

            },
            email: {
                required: 'Email is required',
                email: 'Valid email is required',
            },
            phone: {
                required: 'Phone is required',
                digits: 'Please enter a valid phone number with only digits',
            },
            description: {
                required: 'Description is required',
                noSpacesOnly: "Description cannot be empty and must not contain spaces."

            }
        },
        submitHandler: function (form) {
            // if (grecaptcha.getResponse()) {
            var form_data = new FormData(form);
            $(form).find("button[type='submit']").prop('disabled', true);
            $("button[type='submit']").text("Please Wait...");
            $.ajax({
                url: contactRoute,
                method: "POST",
                cache: false,
                contentType: false,
                processData: false,
                data: form_data,
                success: function (response) {
                    $("button[type='submit']").text("Send Message");
                    if (response.status == 200) {
                        toastr.success(response.success);
                    } else {
                        toastr.info(response.error);
                    }
                    blankForm();
                }
            });
            // } else {
            //     alert('Please confirm captcha to proceed')
            // }
        }
    });

    function blankForm() {
        $('input[name="title"]').val('');
        $('input[name="email"]').val('');
        $('input[name="phone"]').val('');
        $('textarea[name="description"]').val('');
        $("button[type='submit']").prop('disabled', false);
        $('#requestAppointment').modal('hide');
        // grecaptcha.reset();
    }
    //ends

    $(document).on('click', '.pagination a', function (event) {
        $('li').removeClass('active');
        $(this).parent('li').addClass('active');
        event.preventDefault();
        var myurl = $(this).attr('href');
        var page = $(this).attr('href').split('page=')[1];
        if ($('#sortingDSelect').val() == '') {
            var sortingData = $('#sortingMSelect').val();
        } else if ($('#sortingMSelect').val() == '') {
            var sortingData = $('#sortingDSelect').val();
        } else {
            var sortingData = '';
        }
        sendDataValues(page, 'append', sortingData);

    });

    $("#slider").slider({
        range: true,
        min: 100,
        max: 150000,
        step: 2,
        values: [100, 150000],
        slide: function (event, ui) {
            var value1 = $("#slider").slider("values", 0);
            var value2 = $("#slider").slider("values", 1);
            $("#sliderRangeSetMin").val(value1);
            $("#sliderRangeSetMax").val(value2);


            for (var i = 0; i < ui.values.length; ++i) {
                $("input.sliderValue[data-index=" + i + "]").val(ui.values[i]);
            }

        },
        change: function () {

            var value1 = $("#slider").slider("values", 0);
            var value2 = $("#slider").slider("values", 1);

            $("#showProductList").html('');
            sendDataValues(1, 'append');
        },
    });

    $("#sliderRangeSetMin").change(function (event) {
        var value1 = parseFloat($("#sliderRangeSetMin").val());
        var highVal = value1 * 2;
        $("#slider").slider("option", {
            "max": highVal,
            "value": value1
        });
    });

    $("#sliderRangeSetMax").change(function (event) {
        var value1 = parseFloat($("#sliderRangeSetMax").val());
        var highVal = value1 * 2;
        $("#slider").slider("option", {
            "max": highVal,
            "value": value1
        });
    });

    var stepsSlider = document.getElementById('range-slider');
    var input0 = document.getElementById('input-carat-min');
    var input1 = document.getElementById('input-carat-max');
    var inputs = [input0, input1];
    $('.resetFilterButton').on('click', function () {
        $('.filter-item-data').prop("checked", false);
        var value = pathPhpVariable;
        var arrVars = value.split("/");

        var value1 = arrVars[0];
        var value2 = arrVars[1];
        if (value1 == 'diamond-engagement-rings') {
            value1 = 'engagement-rings';
        }
        $("input[name=category][value=" + value1 + "]").prop('checked', true);
        $("input[name=style-categories][value=" + value2 + "]").prop('checked', true);
        if (value2 !== undefined) {
            $("input[name=filter-by-shape][value=" + value2 + "]").prop('checked', true);
            $("input[name=jewellery-categories][value=" + value2 + "]").prop('checked', true);
        }
        $("#showProductList").html('');
        sendDataValues(1, 'append');
    });


    var value = pathPhpVariable;
    var arrVars = value.split("/");

    if (arrVars[0] == 'diamonds-rings') {
        $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
        $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
            'none');
        $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
            'display', 'none');
    }

    if (arrVars[0] == 'diamond-engagement-rings') {
        $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
        $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

        // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
        $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
            'none');
        $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
            'display', 'none');

        $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
            'return false;');

        $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
        $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                'slug') + "'; return false;");
        $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

        // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");

    }

    if (arrVars[0] == 'eternity-rings') {
        $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
        $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

        // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
        $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
            'none');

        // $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display', 'none');
        $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
            'display', 'none');
        $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
            'return false;');

        $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");
        $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                'slug') + "'; return false;");
        $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");


        // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
    }


    if (arrVars[0] == 'wedding-rings') {
        $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
        $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='halo']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='multi-stone']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='shoulder-set']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='solitaire']").parent('li').css('display', 'none');

        // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
        $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
            'none');

        $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
            'display', 'none');

        $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");
        $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
        $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

        $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
            'return false;');
        // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
    }

    if (arrVars[0] == 'engagement-rings') {
        $("input[name=category][value='diamond-jewellery']").parent('li').css('display', 'none');
        $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='mens']").parent('li').css('display', 'none');
        $("input[name=style-categories][value='womens']").parent('li').css('display', 'none');

        // $("input[name=category][value='eternity-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='diamond-jewellery']").attr('disabled', 'disabled');
        $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
            'none');
        $("input[name=filter_item_slug][value='jewellery-categories']").parent('.filter-item').css(
            'display', 'none');

        $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                'slug') + "'; return false;");
        $("input[name=category][value='eternity-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='eternity-rings']")
                .data('slug') + "'; return false;");
        $("input[name=category][value='diamond-jewellery']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='diamond-jewellery']")
                .data('slug') + "'; return false;");

        $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
            'return false;');
        // $("input[name=category][value='eternity-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='eternity-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='diamond-jewellery']").parent('li').wrap("<a href='"+$("input[name=category][value='diamond-jewellery']").data('slug')+"'></a>");
    }

    if (arrVars[0] == 'diamond-jewellery') {
        $("input[name=category][value='diamonds-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='engagement-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='eternity-rings']").parent('li').css('display', 'none');
        $("input[name=category][value='wedding-rings']").parent('li').css('display', 'none');

        // $("input[name=category][value='wedding-rings']").attr('disabled', 'disabled');
        // $("input[name=category][value='engagement-rings']").attr('disabled', 'disabled');
        $("input[name=filter_item_slug][value='filter-by-shape']").parent('.filter-item').css('display',
            'none');
        $("input[name=filter_item_slug][value='style-categories']").parent('.filter-item').css('display',
            'none');
        $("input[name=filter_item_slug][value='ring-categories']").parent('.filter-item').css('display',
            'none');

        $("input[name=category][value='wedding-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='wedding-rings']").data(
                'slug') + "'; return false;");
        $("input[name=category][value='engagement-rings']").parent('li').attr('onclick',
            "javascript:window.location.href='" + $("input[name=category][value='engagement-rings']")
                .data('slug') + "'; return false;");

        $("input[name=category][value='diamonds-rings']").prop('checked', true).attr('onclick',
            'return false;');
        // $("input[name=category][value='engagement-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='engagement-rings']").data('slug')+"'></a>");
        // $("input[name=category][value='wedding-rings']").parent('li').wrap("<a href='"+$("input[name=category][value='wedding-rings']").data('slug')+"'></a>");
    }

    if (arrVars[1] == 'halo' || arrVars[1] == 'shoulder-set' || arrVars[1] == 'solitaire' || arrVars[1] ==
        'multi-stone') {
        $("input[name=style-categories]").attr('onclick', 'return false;');
    }
    filterShapechanged();
    filterStylechanged();
    filterRingTypechanged();
    filterJewelleryTypechanged();
});

function filterShapechanged() {
    getFilterStyleChangedWithClass('filter-by-shape');
    // var valuesFilterShapechanged = $("input[name='filter-by-shape']:checked")
    //       .map(function(){return $(this).val();}).get();

    // if(valuesFilterShapechanged.length != 0){
    //     var dynamicFilterShapechanged = {};
    //     $("input[name='filter-by-shape']:not(:checked)").each(function() {
    //         var key = $(this).val();
    //         var value = $(this).data('slug');
    //         dynamicFilterShapechanged[key] = value;
    //     });

    //     $.each(dynamicFilterShapechanged, function( index, value ) {
    //         $("input[name=filter-by-shape][value='"+index+"']").parent('li').wrap("<a href='"+value+"'></a>");
    //     });
    // }else{
    //     console.log("not available");
    // }

    // $('input[name="filter-by-shape"]:checked').each(function() {
    //     if (this.value != '') {
    //         $("input[name=filter-by-shape]").attr('onclick', 'return false;');
    //     }
    // });
}


// $(".color-btn").each(function() {
//     var $this = $(this);
//     var metalType = $this.data("color");
//     var slug = $this.data("slug");

//     // Check if the color variation exists for this product
//     $.ajax({
//         type: 'POST',
//         url: getVariationsImageDataRoute,
//         dataType: 'JSON',
//         data: {
//             '_token': CSRFTOKEN,
//             'slug': slug,
//             'metal_type': metalType,
//             'final_price': parseInt($('#selected_final_price').val()) || 0,
//         },
//         success: function(res) {
//             // Remove the button if the variation doesn't exist
//             if (!res || !res.vari_image) {
//                 $this.remove();
//             }
//         },
//         error: function() {
//             console.error('Error fetching variation data for:', metalType);
//         }
//     });
// });






$(document).on('click', "[id^=fetchdefaultimages]", function () {
    let productId = parseInt($(this).attr("id").replace("fetchdefaultimages", '')); // Extract product ID
    let imageUrl = $(this).attr("data-src"); // Get the image URL from data-src
    if (imageUrl) {
        $('#variationImageShown' + productId + ' img').attr('src', imageUrl);
    } else {
        console.error('No image URL found for this product.');
    }
});



$(document).on('click', "[id^=fetchvariationRoseimages]", function () {
    var tokenIndex = parseInt($(this).attr("id").replace("fetchvariationRoseimages", ''));
    getSelectedVariationsData(tokenIndex, $(this).data('color'), $(this).data('slug'));
});
$(document).on('click', "[id^=fetchvariationYellowimages]", function () {
    var tokenIndex = parseInt($(this).attr("id").replace("fetchvariationYellowimages", ''));
    getSelectedVariationsData(tokenIndex, $(this).data('color'), $(this).data('slug'));
});

function filterStylechanged() {
    getFilterStyleChangedWithClass('style-categories');
}

function getSelectedVariationsData(tokenIndex, metalType, slug) {
    $.ajax({
        type: 'POST',
        url: getVariationsImageDataRoute,
        dataType: 'JSON',
        data: {
            '_token': CSRFTOKEN,
            'slug': slug,
            'metal_type': metalType,
            'final_price': parseInt($('#selected_final_price').val()) || 0,
        },
        success: function (res) {
            $('#variationImageShown' + tokenIndex + ' img').attr('src',
                'https://admin.marlowsdiamonds.com/storage/' + res.vari_image);
        }
    });
}


function getFilterStyleChangedWithClass(inputFieldNameValue) {
    var valuesCheckedValues = $("input[name='" + inputFieldNameValue + "']:checked")
        .map(function () {
            return $(this).val();
        }).get();

    if (valuesCheckedValues.length != 0) {



        var dynamicKeyValuePairs = {};
        $("input[name='" + inputFieldNameValue + "']:not(:checked)").each(function () {

            var key = $(this).val();
            var value = $(this).data('slug');
            dynamicKeyValuePairs[key] = value;
        });

        $.each(dynamicKeyValuePairs, function (index, value) {
            $("input[name=" + inputFieldNameValue + "][value='" + index + "']").parent('li').attr('onclick',
                "javascript:window.location.href='" + value + "'; return false;");

            // $("input[name="+inputFieldNameValue+"][value='"+index+"']").parent('li').wrap("<a href='"+value+"'></a>");
        });
    }

    $('input[name="' + inputFieldNameValue + '"]:checked').each(function () {
        if (this.value != '') {
            $("input[name=" + inputFieldNameValue + "]").attr('onclick', 'return false;');
        }
    });
}

function filterRingTypechanged() {
    getFilterStyleChangedWithClass("ring-categories");
    // $('input[name="ring-categories"]:checked').each(function() {
    //     if (this.value != '') {
    //         $("input[name=ring-categories]").attr('onclick', 'return false;');
    //     }
    // });
}

function filterJewelleryTypechanged() {
    getFilterStyleChangedWithClass("jewellery-categories");
    // $('input[name="jewellery-categories"]:checked').each(function() {
    //     if (this.value != '') {
    //         $("input[name=jewellery-categories]").attr('onclick', 'return false;');
    //     }
    // });
}

$(document).on('mouseenter', '.product-hover-affect', function (event) {
    if ($(this).find('video').length) {
        $(this).find('video')[0].play()
    }
}).on('mouseleave', '.top-level', function () {
    if ($(this).find('video').length) {
        $(this).find('video')[0].pause()
    }
})

$(document).on('touchstart', '.product-hover-affect', function () {
    if ($(this).find('video').length) {
        $(this).find('video')[0].play()
    }
});
$(document).on('change', ".filter-item-data", function () {
    $("#showProductList").html('');
    sendDataValues(1, 'append');
});

$(document).on('change', "#sortingDSelect,#sortingMSelect", function () {

    if ($('#sortingDSelect').val() == '') {
        var sortingData = $('#sortingMSelect').val();
    } else if ($('#sortingMSelect').val() == '') {
        var sortingData = $('#sortingDSelect').val();
    } else {
        var sortingData = '';
    }

    $("#showProductList").html('');
    sendDataValues(1, 'append', sortingData);
});

// Ensure first option is selected on page load
window.addEventListener('load', function () {
    document.getElementById('sortingDSelect').value = '';
});


$(window).on('hashchange', function () {
    if (window.location.hash) {
        var page = window.location.hash.replace('#', '');
        if (page == Number.NaN || page <= 0) {
            return false;
        } else {
            getData(page);
        }
    }
});


$('#searchd, #searchm').on('keyup', function (event) {
    let searchTextData = $(this).val();
    if (searchTextData.trim() != '' && searchTextData.length > 2) {
        $("#showProductList").html('');
        sendDataValues(1, 'html');
    } else if (searchTextData.length == 0) {
        if (event.keyCode == 13) {
            event.preventDefault();
            return false;
        }
        $("#showProductList").html('');
        sendDataValues(1, 'html');
        // var page = $('#pagescroll').val();
        // sendDataValues(page, 'append');
    }
});

function sendDataValues(page, type = 'append', sorting = 'asc') {
    // $("input[name=filter-by-shape]").attr('onclick', 'return false;');
    // filterShapechanged();
    let keyword = '';

    if ($('#searchd').is(':visible') && $('#searchd').val().trim() !== '') {
        keyword = $('#searchd').val().trim();
    } else if ($('#searchm').is(':visible') && $('#searchm').val().trim() !== '') {
        keyword = $('#searchm').val().trim();
    }

    $('.ajax-load').show();
    $.ajax({
        type: 'GET',
        url: getFilteredProductsRoute,
        data: {
            '_token': CSRFTOKEN,
            'ids': $('.filter-item-data').serializeArray(),
            'sorting': sorting,
            'keyword': keyword,
            'path': '',
            'page': page,
            'per_page_product': 30
        },
        beforeSend: function () {
            // $(".ajax-load").show().html("Loading products..."); // Show loader
            $("#showProductList").css("opacity", "0.5"); // Reduce opacity for effect
            document.getElementById("loader-overlay").style.display = "flex";
        },
        success: function (res) {
            // filterShapechanged();
            // resetFilterButton


            $('#pagescroll').val(res.nextPage);
            $('html, body').animate({
                scrollTop: '680px'
            }, 700);
            if (res.status == 404 || res.productItems == "") {
                // $('.category-list-item-searchsort').css('display','none');
                $('.ajax-load').html("0 Product Found");
                $('#productCountData').text("");
                $('#productCountDataMobile').text("");
                return false;
            }
            $('.ajax-load').hide();
            $("#showProductList").css("opacity", "1");
            // $('.category-list-item-searchsort').css('display','inherit');
            if (type == 'append') {
                $("#showProductList").html(res.productItems);
            } else {
                $("#showProductList").html(res.productItems);
            }
            $('#productCountData').text('Showing ' + res.product_count + ' of ' + res
                .totalProductCount);
            $('#productCountDataMobile').text('Showing ' + res.product_count + ' of ' + res
                .totalProductCount);
            $('#sectionHeight').val($('#showProductList').height());
            $('#scrollFlag').val(0);


            // Ensure images are loaded before hiding loader
            $("#showProductList img").on("load", function () {
                $(".ajax-load").hide();
            }).each(function () {
                if (this.complete) $(this).trigger(
                    "load"); // Ensure already loaded images trigger event
            });
            document.getElementById("loader-overlay").style.display = "none";
        }
    });
}


// {{-- filter script start from here --}}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".filter-item-data").forEach(input => {
        input.addEventListener("click", function () {
            const parentAccordion = input.closest(".accordion-item");
            if (parentAccordion) {
                const collapseElement = parentAccordion.querySelector(
                    ".accordion-collapse");
                if (collapseElement && collapseElement.classList.contains("show")) {

                    const collapseInstance = new bootstrap.Collapse(collapseElement, {
                        toggle: false,
                    });
                    collapseInstance.hide();
                }
            }

            updateSelectedFilters();
        });
    });
    const selectedFiltersContainer = document.getElementById("selected-filters-list");


    document.querySelectorAll(".filter-item-data").forEach(input => {
        input.addEventListener("change", function () {
            updateSelectedFilters();
        });
    });

    function updateSelectedFilters() {
        selectedFiltersContainer.innerHTML = "";
        const selectedFilters = document.querySelectorAll(".filter-item-data:checked");
        const filterCounts = {};

        function updateFilterCount(categorySlug) {
            const categoryButton = document.querySelector(`#filter-count-${categorySlug}`);
            if (categoryButton) {
                const count = filterCounts[categorySlug] || 0;
                categoryButton.innerText = `(${count})`; // Update the count in the UI
            }
        }

        selectedFilters.forEach(filter => {
            // console.log('filter', filter)
            const filterName = filter.closest(".filter-item").querySelector("b").innerText;
            const filterValue = filter.value;
            const categorySlug = filter.closest(".accordion-collapse").id.replace('collapse', '');


            if (!filterCounts[categorySlug]) {
                filterCounts[categorySlug] = 0;
            }
            filterCounts[categorySlug]++;


            updateFilterCount(categorySlug);
            const listItem = document.createElement("li");
            let removeButtonHtml = '';

            if ((filter.hasAttribute('checked') && filter.getAttribute('checked') !== 'false') ||
                filter.type === 'radio') {
                listItem.innerHTML = `<b>${filterName}:</b> ${filterValue}`;
            } else {
                removeButtonHtml =
                    `<button class="remove-filter" data-filter-value="${filterValue}" data-filter-name="${filterName}" data-category="${categorySlug}">✖</button>`;
                listItem.innerHTML = `<b>${filterName}:</b> ${filterValue} ${removeButtonHtml}`;
            }
            selectedFiltersContainer.appendChild(listItem);
        });

        // Show a message if no filters are selected
        if (!selectedFilters.length) {
            const currentPath = window.location.pathname;
            const pathSegments = currentPath.split('/').filter(Boolean);

            if (pathSegments.length >= 2) {
                const secondLastSegment = pathSegments[pathSegments.length - 2];
                const lastSegment = pathSegments[pathSegments.length - 1];

                const baseUrl = window.location.origin;
                window.location.href = `${baseUrl}/${secondLastSegment}/${lastSegment}`;
            } else {
                const baseUrl = window.location.origin;
                const lastSegment = pathSegments[pathSegments.length - 1];
                window.location.href = `${baseUrl}/${lastSegment}`;
            }
            return;
        }

        // Add click event listeners for remove buttons
        document.querySelectorAll(".remove-filter").forEach(button => {
            button.addEventListener("click", function () {
                const filterValue = this.getAttribute("data-filter-value");
                const categorySlug = this.getAttribute("data-category");
                const filterCheckbox = Array.from(document.querySelectorAll(
                    ".filter-item-data")).find(
                        checkbox => checkbox.value === filterValue
                    );
                if (filterCheckbox) {
                    filterCheckbox.checked = false;
                }

                if (filterCounts[categorySlug]) {
                    filterCounts[categorySlug]--;
                }
                this.closest("li").remove();
                updateFilterCount(categorySlug);


                updateSelectedFilters();
                sendDataValues(1);
            });
        });


        for (let category in filterCounts) {

            const countElement = document.getElementById("filter-count-" + category.replace(/\s+/g, '-')
                .toLowerCase());
            if (countElement) {
                countElement.innerText = `(${filterCounts[category]})`;
            }
        }
    }


    // Listen for changes on filter checkboxes
    document.querySelectorAll(".filter-item-data").forEach(input => {
        input.addEventListener("change", function () {
            const categorySlug = input.closest(".accordion-collapse").id.replace('collapse',
                '');
            if (!input.checked) {
                // Decrement the count if the checkbox is unchecked
                const categoryButton = document.querySelector(
                    `#filter-count-${categorySlug}`);
                const currentCount = parseInt(categoryButton?.innerText.replace(/[()]/g,
                    '')) || 0;
                const newCount = Math.max(0, currentCount - 1);
                if (categoryButton) {
                    categoryButton.innerText = `(${newCount})`;
                }
            }
            updateSelectedFilters(); // Refresh the UI and counts
        });
    });



    document.querySelectorAll(".filter-item-data").forEach(input => {
        input.addEventListener("change", updateSelectedFilters);
    });

    updateSelectedFilters();

    // Reset filter button functionality
    document.getElementById("resetFilterButton").addEventListener("click", () => {
        document.querySelectorAll(".filter-item-data:checked").forEach(input => input.checked =
            false);
        updateSelectedFilters();
    });
});


// {{-- copy element starts from here --}}
// {{-- <script>
//     document.addEventListener("DOMContentLoaded", function() {
//         var shareModal = document.getElementById('sharesocial');
//         shareModal.addEventListener('show.bs.modal', function(event) {
//             var button = event.relatedTarget;
//             var productUrl = button.getAttribute('data-url');
//             document.getElementById('copy-text').textContent = productUrl;

//             // Update social media share links
//             document.getElementById('facebookShare').href =
//                 `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(productUrl)}`;
//             document.getElementById('twitterShare').href =
//                 `https://twitter.com/intent/tweet?url=${encodeURIComponent(productUrl)}`;
//             document.getElementById('pinterestShare').href =
//                 `https://pinterest.com/pin/create/button/?url=${encodeURIComponent(productUrl)}`;
//             document.getElementById('whatsappShare').href =
//                 `https://api.whatsapp.com/send?text=${encodeURIComponent(productUrl)}`;
//         });
//     });

//     // Copy to clipboard function
//     function copyToClipboard() {
//         var text = document.getElementById('copy-text').textContent;
//         navigator.clipboard.writeText(text).then(function() {
//             alert("Link copied to clipboard!");
//         }).catch(function(error) {
//             console.error("Failed to copy text:", error);
//             alert("Failed to copy text. Please try again.");
//         });
//     }
// </script> --}}
document.addEventListener("DOMContentLoaded", () => {
    const shareModal = document.getElementById('sharesocial');
    const copyTextEl = document.getElementById('copy-text');

    if (!shareModal || !copyTextEl) return;

    const shareLinks = {
        facebookShare: url => `https://www.facebook.com/sharer/sharer.php?u=${url}`,
        twitterShare: url => `https://twitter.com/intent/tweet?url=${url}`,
        pinterestShare: url => `https://pinterest.com/pin/create/button/?url=${url}`,
        whatsappShare: url => `https://api.whatsapp.com/send?text=${url}`
    };

    shareModal.addEventListener('show.bs.modal', e => {
        const button = e.relatedTarget;
        const productUrl = encodeURIComponent(button?.getAttribute('data-url') || window.location
            .href);

        copyTextEl.textContent = decodeURIComponent(productUrl);

        // Update social links
        Object.entries(shareLinks).forEach(([id, buildUrl]) => {
            const el = document.getElementById(id);
            if (el) el.href = buildUrl(productUrl);
        });
    });
});

// Copy to clipboard function
function copyToClipboard() {
    const text = document.getElementById('copy-text')?.textContent;
    if (!text) return;

    navigator.clipboard.writeText(text)
        .then(() => showToast("✅ Link copied!"))
        .catch(() => showToast("❌ Failed to copy link"));
}

// Small toast function instead of blocking alert
function showToast(message) {
    const toast = document.createElement("div");
    toast.textContent = message;
    toast.style.cssText = `
                position: fixed; top: 20px; right: 20px;
                background: #333; color: #fff; padding: 8px 12px;
                border-radius: 6px; font-size: 14px; z-index: 9999;
                opacity: 0; transition: opacity 0.3s ease;
            `;
    document.body.appendChild(toast);
    requestAnimationFrame(() => toast.style.opacity = "1");
    setTimeout(() => {
        toast.style.opacity = "0";
        setTimeout(() => toast.remove(), 300);
    }, 2000);
}
// {{-- copy element ends here --}}

// {{-- filter script ends here --}}
$(document).ready(function () {

    var collapse1value = document.getElementById('collapse1');
    if (screen.width <= 320 || screen.width <= 991) {
        collapse1value.style.display = "none";
    } else {
        // collapse1value.style.display="block11";
    }
    $('.nav-toggle').click(function () {
        //get collapse content selector
        var collapse_content_selector = $(this).attr('href');

        //make the collapse content to be shown or hide
        var toggle_switch = $(this);
        $(collapse_content_selector).toggle(function () {
            if ($(this).css('display') == 'none') {
                //change the button label to be 'Show'
                toggle_switch.html(
                    '<i class="fa fa-angle-down" style="color:#993168"></i>  Filter');
            } else {
                //change the button label to be 'Hide'
                toggle_switch.html(
                    '<i class="fa fa-angle-up" style="color:#993168"></i>  Filter');
            }
        });
    });

    $(document).on('click', "[id^=productWishListRelated]", function () {
        var index = parseInt($(this).attr("id").replace("productWishListRelated", ''));
        var product_slug = $('#productWishListRelated' + index).data('productslug');
        addtobasketFunction(setProductWishlistRoute, product_slug, index);
    });

});

function addtobasketFunction(getUrl, product_slug, index) {
    var trdata = $('#finaldiamondprice .price').text().replace(/[^\0-9.-]+/g, '');
    var rrpPrice = $('#rrpPrice.rrpPriceval').text().replace(/[^\0-9.-]+/g, '');
    var savePriceval = $('#savePrice.save').text().replace(/[^\0-9.-]+/g, '');
    var shopPricedata = $('#shopPrice.shopPriceval').text().replace(/[^\0-9.-]+/g, '');

    let lab_grown_price = $("#finaldiamondprice .price").text().replace("£", "");

    let diamondCaratWeight;
    let diamondColour;
    var diamondShape;
    let diamondGrade;
    let diamondClarity;
    let diamondCertificate;
    if ($('.diamond_type:checked').val() == 'mined_diamond') {
        diamondCaratWeight = $('#carat').val();
        diamondColour = $('#diamond-colour').val();
        diamondShape = $('#selected_diamond_shape').val();
        diamondGrade = $('#diamond-grade').val();
        diamondClarity = $('#diamond-clarity').val();
        diamondCertificate = $('#diamond-certificate').val();
    } else if ($('.diamond_type:checked').val() == 'lab_grown') {
        diamondCaratWeight = $('#lab_grown_carat').val();
        diamondColour = $('#lab_grown_colour').val();
        diamondShape = $('#selected_diamond_shape').val();
        diamondGrade = '';
        diamondClarity = $('#lab_grown_clarity').val();
        diamondCertificate = '';
    }

    var variations = [];
    $('.type-variations-row select').each(function (i, sel) {

        if ($(sel).attr('name') != 'finger-size')
            variations.push($(sel).val());
    });


    $.ajax({
        type: 'POST',
        url: getUrl,
        data: {
            '_token': CSRFTOKEN,
            'carat': $('#carat').val(),
            'variations': variations,
            'total-diamond-weight': $('#total-diamond-weight').val(),
            'color': $('#diamond-colour').val(),
            'clarity': $('#diamond-clarity').val(),
            'width-mm': $('#width-mm').val(),
            'grade': $('#diamond-grade').val(),
            'fingersize': $('#finger-size').val(),
            'metal_type': $('#metal-type').val(),
            'certificate': $('#diamond-certificate').val(),
            'choose_diamond': $('input[name="attribute_choose-your-diamond"]:checked').val(),
            'slug': product_slug,
            'price': parseInt(trdata) || 0,
            'rrpPrice': parseInt(rrpPrice) || 0,
            'savePrice': parseInt(savePriceval) || 0,
            'shopPrice': parseInt(shopPricedata) || 0,
            'diamond_type': $(".diamond_type:checked").val(),
            'discounted_price': parseInt($('#selected_discounted_price').val()) || 0,
            'final_price': parseInt($('#selected_final_price').val()) || 0,
            'setting_price': parseInt(trdata) || 0,
        },
        success: function (res) {
            if (res.success != '' && typeof res.success !== "undefined") {
                if (res.cartcount) {
                    $(".cartcount").text(res.cartcount);
                }
                if (res.wishcount) {
                    if (index > 0) {
                        $('#productWishListRelated' + index).children('i').addClass('fa-heart');
                        $('#productWishListRelated' + index).children('i').removeClass('fa-heart-o');
                    } else {
                        $('#productWishList' + index).children('i').removeClass('fa-heart-o');
                        $('#productWishList' + index).children('i').addClass('fa-heart');
                    }

                    if (res.wishcount > 0) {
                        $('.my-whishlist-blk a i').removeClass('fa-heart-o');
                        $('.my-whishlist-blk a i').addClass('fa-heart');
                    }
                }
                toastr.success(res.success);
            } else {
                if (res.error) {
                    if (index > 0) {
                        $('#productWishListRelated' + index).children('i').removeClass('fa-heart');
                        $('#productWishListRelated' + index).children('i').addClass('fa-heart-o');
                    } else {
                        $('#productWishList' + index).children('i').removeClass('fa-heart');
                        $('#productWishList' + index).children('i').addClass('fa-heart-o');
                    }
                    if (res.wishcount == 0) {
                        $('.my-whishlist-blk a i').removeClass('fa-heart');
                        $('.my-whishlist-blk a i').addClass('fa-heart-o');
                    }
                }
                toastr.info(res.error);
            }
        }
    });
}

$(function () {
    var owl = $(".owl-carousel");
    owl.owlCarousel({
        items: 7,
        margin: 2,
        loop: true,
        nav: true,
        responsive: {
            320: {
                items: 1
            },
            480: {
                items: 2
            },
            769: {
                items: 3
            },
            991: {
                items: 4
            },
            1100: {
                items: 4
            }
        }
    });
});

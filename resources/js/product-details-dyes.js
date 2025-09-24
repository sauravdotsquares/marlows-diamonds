function changeDiamondType(classToPerform = "") {

    if (classToPerform == 'mined_item') {
        $(".mined-certificate").removeAttr('style');
        $(".store-locator-border-right").css('border-right', '1px solid #B0B0B0');
        $("#selected_diamond_price").val($('.refinedata').first().data('price'));
    } else {
        $(".mined-certificate").css('display', 'none');
        $(".store-locator-border-right").css('border-right', 'none')
    }
    $(".mined_lab_items").css('display', 'none');
    $("." + classToPerform).css('display', 'flex');
    $("." + classToPerform + "_block").css('display', 'block');

    /** show and hide description */
    $(".product-description-common").css('display', 'none');
    $(".product-description-common_" + classToPerform).css('display', 'block');

    // getFinalPrice();
}


$(".lab_price_update_items").on('change', function () {
    changeDiamondType($('.diamond_type:checked').attr("id"));
});


// $(document).on('change', '.diamond_type', function (event) {
//     getCustomFilter();
//     setTimeout(function () {
//         changeDiamondType($(event.target).attr("id"));
//     }, 500);
//     // getCustomPriceFinalFunction();
//     let getDiamondType = $(this).val();
//     getSelectedDataVariation();
//     if (getDiamondType == 'lab_grown') {
//         getProdVideo('onChange', ' 9ct White Gold ');
//     } else if (getDiamondType == 'mined_diamond') {
//         getProdVideo('onChange', 'Platinum');
//     }
// });
let diamondTypeTimer;
$(document).on('change', '.diamond_type', function (event) {
    clearTimeout(diamondTypeTimer);
    diamondTypeTimer = setTimeout(() => {
        getCustomFilter();        // loads filter
        changeDiamondType($(event.target).attr("id"));
        getSelectedDataVariation();
        getProdVideo('onChange', $(this).val() === 'lab_grown' ? ' 9ct White Gold ' : 'Platinum');
    }, 400);
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

$.validator.addMethod("phoneno", function (phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
    return phone_number.length > 9;
}, "Please specify a valid phone number");

$.validator.addMethod("lettersonly", function (value, element) {
    return this.optional(element) || /^[a-z," "]+$/i.test(value);
}, "Letters and spaces only please");

$(document).ready(function () {
    $('[data-fancybox="gallery1"]').fancybox({
        afterLoad: function (instance, current) {
            current.$image.attr('alt', dataPhpVariable.title);
        }
    });
    toastr.options = {
        "preventDuplicates": true,
        "preventOpenDuplicates": true
    };

    // Custom method to check for spaces or empty values
    jQuery.validator.addMethod(
        "noSpacesOnly",
        function (value, element) {
            return $.trim(value).length > 0; // Ensures value isn't just spaces
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

    window.requestIdleCallback =
        window.requestIdleCallback ||
        function (cb) {
            return setTimeout(() => {
                cb();
            }, 1);
        };

    window.cancelIdleCallback =
        window.cancelIdleCallback ||
        function (id) {
            clearTimeout(id);
        };

    // Now safe to use
    requestIdleCallback(() => {
        getRelatedProduct();
        getCustomFilter();
    });

    // getRelatedProduct();
    // getCustomFilter(); //getProdVideo();


    $(".viewdiamond-btn").click(function () {
        $(".diamond-table").toggle();
    });

    // TODO: getSelectedAttributePrice();

    $(document).on('change',
        "#metal-type,#finger-size,#lab_grown_carat,#lab_grown_colour,#lab_grown_clarity,#carat,#diamond-colour,#diamond-clarity,#diamond-certificate,#diamond-grade",
        function () {
            getSelectedAttributePrice();
            getProdVideo();
            getCustomPriceFinalFunction();
            getSelectedDataVariation();
            // if($('.diamond_type:checked').val() == 'lab_grown'){
            // 	getDescribeSelectedOptions();
            // }else if($('.diamond_type:checked').val() == 'mined_diamond'){
            // 	getDescribeSelectedOptionsMined();
            // }
        });

    $('#addtobasket').on('click', function () {
        addtobasketFunction(addToCartRoute, dataPhpVariable.slug, '');
    });

    $('#addtobasketfooter').on('click', function () {
        addtobasketFunction(addToCartRoute, dataPhpVariable.slug, '');
    });

    $(document).on('change', "[id^=productWishList]", function () {
        var index = parseInt($(this).attr("id").replace("attributevari", ''),
            dataPhpVariable.slug, '');
    });
    $(document).on('change', "[id^=productWishListImage]", function () {
        var index = parseInt($(this).attr("id").replace("attributevari", ''),
            dataPhpVariable.slug, '');
    });



    $(document).on('click', "[id^=productWishListRelated]", function () {
        var index = parseInt($(this).attr("id").replace("productWishListRelated", ''));
        var product_slug = $('#productWishListRelated' + index).data('productslug');
        addtobasketFunction(setProductWishlistRoute, product_slug, index);
    });

    $("#productWishList").on('click', function () {
        addtobasketFunction(setProductWishlistRoute, dataPhpVariable.slug, '');
    });

    $("#productWishListImage").on('click', function () {
        addtobasketFunction(setProductWishlistRoute, dataPhpVariable.slug, '');
    });
    // $(document).on('change','#metal-type',function(){
    // 	getProdVideo('onChange');
    // });



    $(document).on('click', '.refinedata', function () {
        getCustomPriceFinalFunction(getNumberFromCurrency($(this).data('price')));
        // $("#selected_diamond_price").val($(this).data('price'));
        // $("#certificate_url").val($(this).data('certurl'));
        // $("#productCertificateLink").attr('href',$(this).data('certurl'));
        // getFinalPrice();
    });

    window.addEventListener("load", function () {
        setTimeout(() => {
            getSelectedAttributePrice();
        }, 1000);
    });
});

function getCustomFilter() {

    $.ajax({
        type: 'POST',
        url: customFilterRoute,
        data: {
            '_token': CSRFTOKEN,
            'slug': dataPhpVariable.slug,
            'diamond_type': $('.diamond_type:checked').val(),
            'metal-type': requestDataPhpVariable["metal-type"] || "",
        },
        success: function (res) {
            $('#filterDataDesign .type-variations-row').html(res);
            getCustomPriceFinalFunction();
            getSelectedDataVariation();
            if ($('.diamond_type:checked').val() == 'lab_grown') {
                // getDescribeSelectedOptions();
            } else if ($('.diamond_type:checked').val() == 'mined_diamond') {
                // getDescribeSelectedOptionsMined();
                $("#metal-type option[value=' Silver ']").hide();
            }
        }
    });
}

function getProdVideo(action = null, metalType = null) {
    if (metalType == null) {
        var metal_type = $('#metal-type :selected').val();
    } else {
        var metal_type = metalType;
    }
    $.ajax({
        type: 'POST',
        url: getProductVideoRoute,
        data: {
            '_token': CSRFTOKEN,
            'slug': dataPhpVariable.slug,
            'metal_color': metal_type,
        },
        success: function (res) {
            if (res.getSelectedVariationVideoImages.vari_video) {
                var videoUrl = assetStorageUrl + res.getSelectedVariationVideoImages
                    .vari_video;
                // Update the video element's src attribute
                $('#variationVideo').attr('src', videoUrl);

                // Also update the source element if necessary
                $('#variationVideo source').attr('src', videoUrl);
                $('#variationAnchorVideo').attr('href', videoUrl);

                // $("#variationVideo")[0].play();
                // Load the new video
                $('#variationVideo')[0].load();

                // Call the function to activate the carousel item with the video
                activateCarouselItem();
            }

            if (res.getVariationDescription.description) {
                $('.delieveryDescription').html(res.getVariationDescription.description);
                // if($('.diamond_type:checked').val() == 'lab_grown'){
                // }else if($('.diamond_type:checked').val() == 'mined_diamond'){
                // 	$('.delieveryDescription').html('');
                // }
            }
        }
    });
}

// Function to activate a specific carousel item
function activateCarouselItem() {
    // Remove 'active' class from all carousel items
    $('#carousel .owl-item').removeClass('active');

    // Add 'active' class to the specific item containing the video
    $('#variationVideo').closest('.owl-item').addClass('active');
}

function getNumberFromCurrency(currency) {
    return Number(currency.replace(/[$,]/g, ''))
}

function getCustomPriceFinalFunction(selectedDiamondPrice = null) {
    $('#price-section').html(MYCURRENCYSYMBOLPhpVariable + ' Pending...');
    $('#getLabDiamondPrices').val('');

    var variations = [];
    $('.type-variations-row select').each(function (i, sel) {

        if ($(sel).attr('name') != 'finger-size')
            variations.push($(sel).val());
    });

    let diamondCaratWeight;
    let diamondColour;
    var diamondShape;
    let diamondGrade;
    let diamondClarity;
    let diamondCertificate;
    let diamondAllSpecs = [];
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

    diamondAllSpecs.push(diamondCaratWeight);
    diamondAllSpecs.push(diamondColour);
    diamondAllSpecs.push(diamondClarity);
    diamondAllSpecs = diamondAllSpecs.join(', ');

    document.getElementById("loader-overlay").style.display = "flex";
    $.ajax({
        type: 'POST',
        url: getProductVariationPricesRoute,
        dataType: 'json',
        data: {
            '_token': CSRFTOKEN,
            'metal_type': $('#metal-type').val(),
            'variations': variations,
            'carat': diamondCaratWeight,
            'color': diamondColour,
            'grade': diamondGrade,
            'clarity': diamondClarity,
            'certificate': diamondCertificate,
            'shape': diamondShape,
            'selectedDiamondPrice': selectedDiamondPrice,
            'slug': dataPhpVariable.slug,
            'type': 1,
            'diamond_type': $('.diamond_type:checked').val()
        },
        success: function (res) {
            if (res.status == 200) {
                if ($('.diamond_type:checked').val() == 'lab_grown') {
                    $('.delieveryDescription').html(res.delivery_description);
                } else if ($('.diamond_type:checked').val() == 'mined_diamond') {
                    $('.delieveryDescription').html(res.delivery_description);
                }
                $('#rrpPrice').html(`RRP: ${MYCURRENCYSYMBOLPhpVariable} ` + res.allPrices.rrp_price.toFixed(
                    2));
                $('#rrpPricefooter').html(`RRP: ${MYCURRENCYSYMBOLPhpVariable} ` + res.allPrices.rrp_price
                    .toFixed(2));

                if (res.allPrices.shop_price == res.allPrices.discounted_price) {
                    $('#shopPrice').html('');
                    $('#shopPricefooter').html('');
                } else {
                    $('#shopPrice').html(`${MYCURRENCYSYMBOLPhpVariable} ` + res.allPrices.shop_price
                        .toFixed(2));
                    $('#shopPricefooter').html(`${MYCURRENCYSYMBOLPhpVariable} ` + res.allPrices.shop_price
                        .toFixed(2));
                }
                $('#finaldiamondprice').html(`<span class="price" >${MYCURRENCYSYMBOLPhpVariable} ` + res
                    .allPrices.discounted_price.toFixed(2) + ' </span>');

                $('#finaldiamondpricefooter').html(`<span class="price" >${MYCURRENCYSYMBOLPhpVariable} ` +
                    res.allPrices.discounted_price.toFixed(2) + ' </span>');

                $('#finaldiamondspecfooter').html(diamondAllSpecs);

                $('#savePrice').html(`${MYCURRENCYSYMBOLPhpVariable} ` + (parseFloat(res.allPrices
                    .rrp_price) - parseFloat(res.allPrices.discounted_price)).toFixed(2));

                $('#savePricefooter').html(`${MYCURRENCYSYMBOLPhpVariable} ` + (parseFloat(res.allPrices
                    .rrp_price) - parseFloat(res.allPrices.discounted_price)).toFixed(2));

                $('#getLabDiamondPrices').val(res.getLabDiamondPrices.toFixed(2));

                document.getElementById("loader-overlay").style.display = "none";
            } else if (res.status == 500) {
                $('#price-section').html(`${MYCURRENCYSYMBOLPhpVariable} Pending...`);
                $('#getLabDiamondPrices').val('');
            }
        }
    });

}

function addtobasketFunction(getUrl, product_slug = null, index = null) {
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
            'carat': diamondCaratWeight,
            'variations': variations,
            'color': diamondColour,
            'clarity': diamondClarity,
            'grade': diamondGrade,
            'fingersize': $('#finger-size').val(),
            'metal_type': $('#metal-type').val(),
            'certificate': diamondCertificate,
            'slug': product_slug,
            'setting_price': lab_grown_price, //parseFloat($('#price').val()) || 0;
            'price': lab_grown_price, //parseFloat($('#price').val()) || 0;
            'selectedDiamondPrice': $('#getLabDiamondPrices').val(),
            'certificatelink': $('#certificate_url').val() || '',
            'shape': diamondShape,
            'type': 1,
            'certificate': $('#selected_diamond_certno').val() || '',
            'diamond_type': $(".diamond_type:checked").val(),
            'jsondata': $('input[name="selectrefinedata"]:checked').data('jsonvalue'),


            // /**  Add lab information in cart */
            // 'lab_grown_clarity' : $("#lab_grown_clarity").val(),
            // 'lab_grown_colour' : $("#lab_grown_colour").val(),
            // 'lab_grown_carat' : $("#lab_grown_carat").val(),
            // 'lab_grown_price' : lab_grown_price,

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

                        $('#productWishListImage' + index).children('i').removeClass('fa-heart-o');
                        $('#productWishListImage' + index).children('i').addClass('fa-heart');

                    }
                    if (res.wishcount > 0) {
                        $('.my-whishlist-blk .wishcount').removeClass('fa-heart-o');
                        $('.my-whishlist-blk .wishcount').addClass('fa-heart');
                    } else {
                        $('.my-whishlist-blk .wishcount').removeClass('fa-heart');
                        $('.my-whishlist-blk .wishcount').addClass('fa-heart-o');
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

                        $('#productWishImage' + index).children('i').removeClass('fa-heart');
                        $('#productWishListImage' + index).children('i').addClass('fa-heart-o');

                    }
                    if (res.wishcount > 0) {
                        $('.my-whishlist-blk .wishcount').removeClass('fa-heart-o');
                        $('.my-whishlist-blk .wishcount').addClass('fa-heart');
                    } else {
                        $('.my-whishlist-blk .wishcount').removeClass('fa-heart');
                        $('.my-whishlist-blk .wishcount').addClass('fa-heart-o');
                    }
                }
                toastr.error(res.error);
            }
        }
    });
}


// getSelectedAttributePrice();
var triggerLab = true;

function getSelectedAttributePrice() {

    $('#addtobasket').addClass('disabledAnchor');

    var caratVal = $('#carat').val();
    var diamondColor = $('#diamond-colour').val();
    var diamondClarity = $('#diamond-clarity').val();
    var diamondGrade = $('#diamond-grade').val();
    var diamondCertificate = $('#diamond-certificate').val();
    var diamondShape = $('#selected_diamond_shape').val();
    var variation_price = $('#selected_variation_price').val();

    $.ajax({
        type: 'POST',
        url: customApiFilterDataRoute,
        data: {
            '_token': CSRFTOKEN,
            'carat': caratVal,
            'color': diamondColor,
            'clarity': diamondClarity,
            'grade': diamondGrade,
            'certificate': diamondCertificate,
            'shape': diamondShape,
            'slug': dataPhpVariable.slug
        },
        success: function (res) {

            $('#refineSearchData').html("");
            if (res.html != '') {
                $('#refineSearchData').html(res.html);
                //getCustomPrice();
                $("#selected_diamond_price").val($('.refinedata').first().data('price'));
            } else {
                $('#refineSearchData').html("No Data Found");
            }
        }
    });
}

// Data shows in Table view
function getSelectedDataVariation() {

    let designTable = `<table class="table  table-bordered  table-responsive">
						<tr class="tableheading text-white tablehover">
						<th>Type</th>
						<th>Selected</th>
						</tr>`;


    $('.type-variations-col').each(function () {
        // var caret=document.getElementById('lab_grown_carat').val();
        let forId = $(this).find('label').attr('for');
        let forText = $(this).find('label').text();
        const diamondType = $('.diamond_type:checked').val();
        if ((diamondType === 'lab_grown') && (forId === 'diamond-certificate' || forId ===
            'diamond-colour' || forId === 'diamond-clarity' || forId === 'carat' || forId ===
            'diamond-grade')) { } else if ((diamondType === 'mined_diamond') && (forId ===
                'lab_grown_carat' || forId === 'lab_grown_colour' || forId === 'lab_grown_clarity'
            )) { } else {
            designTable += `
						<tr>
						<td>${forText}</td>
						<td>${$('#' + forId).val()}</td>
						</tr>
					`;
        }
    });
    designTable += `</table>`;
    $('#myDivChanges').html(designTable);
}


// start
let designTable = `<table class="table table-bordered table-responsive">
                        <tr class="tableheading text-white tablehover">
                            <th>Type</th>
                            <th>Selected</th>
                        </tr>`;

// Loop through each type variation column and build the table rows
$('.type-variations-col').each(function () {
    let forId = $(this).find('label').attr('for');
    let forText = $(this).find('label').text();
    const diamondType = $('.diamond_type:checked').val();

    // Exclude certain conditions based on the diamond type
    if ((diamondType === 'lab_grown') && (forId === 'diamond-certificate' || forId === 'diamond-colour' ||
        forId === 'diamond-clarity' || forId === 'carat' || forId === 'diamond-grade')) {

    } else if ((diamondType === 'mined_diamond') && (forId === 'lab_grown_carat' || forId ===
        'lab_grown_colour' || forId === 'lab_grown_clarity')) { } else {
        designTable += `
            <tr>
                <td>${forText}</td>
                <td>${$('#' + forId).val()}</td>
            </tr>
        `;
    }
});

let tempContainer = document.createElement('div');
tempContainer.innerHTML = designTable;


const rows = tempContainer.querySelectorAll('tr:not(.tableheading)');
const selectedValues = [];

rows.forEach(row => {
    const selectedCell = row.querySelector('td:nth-child(2)');
    if (selectedCell) {
        selectedValues.push(selectedCell.textContent.trim());
    }
});


const result = selectedValues.join(', ');

document.querySelector('.diamond-sale h5 span').textContent = result;


//ends




function getRelatedProduct() {
    $.ajax({
        url: getRelatedProductListRoute,
        method: "POST",
        data: {
            _token: CSRFTOKEN,
            catid: dataPhpVariable.categories,
        },
        success: function (response) {
            $('#relatedProductData').html(" ");
            if (response.html) {
                $('#relatedProductData').append(response.html);
            }
            // return false;
            // window.location.reload();
        }
    });
}
$(document).on('click', '.product-gallery__trigger', function (e) {
    e.preventDefault();
    $('#carousel .item.active a').click();

    $('#carousel .owl-item.active a').click();
    $('#carousel1 .product-items-carousel.active a').click();
});


$(document).ready(function () {
    var $owl = $('#carousel');
    $owl.children().each(function (index) {
        $(this).attr('data-position', index); // NB: .attr() instead of .data()
    });
    $owl.owlCarousel({
        autoplay: false,
        rewind: true,
        responsiveClass: true,
        autoplayTimeout: 15000,
        smartSpeed: 300,
        nav: true,
        items: 1,
        onInitialized: function () {
            $owl.find('.owl-item').each((index, element) => {
                const src = $(element).find('.thumbnail-src').attr('src');
                if (!src) return; // skip if src undefined

                const video_extensions = ['mp4'];
                const extension = src.split(/[#?]/)[0].split('.').pop().trim();
                let thumbnailItem =
                    `<li class="list-inline-item ${index ? '' : 'active'}">`;
                thumbnailItem +=
                    `<a href="javascript:;" id="carousel-selector-${index}" class="carousel-thumbnail-item ${index ? '' : 'selected'}" data-slide-to="${index}" data-target="#carousel">`;

                if (video_extensions.includes(extension)) {
                    thumbnailItem +=
                        `<video muted class="img-fluid" style="height:100px; width:100px;">`;
                    thumbnailItem +=
                        `<source src="${src}" type="video/mp4" type="video/mp4" />`;
                    thumbnailItem += `</video>`;
                } else {
                    thumbnailItem +=
                        `<img src="${src}" class="img-fluid" style="height:100px; width:100px;">`;
                }
                thumbnailItem += `</li>`;

                $(".carousel-thumbnails").append(thumbnailItem);

            })
        },
    }).on("changed.owl.carousel", function (el) {
        var index = el.item.index;
        $('.carousel-thumbnail-item').closest('li').removeClass('active');
        $('#carousel-selector-' + index).closest('li').addClass('active');
    });

    // $(document).on('click', '.product-gallery__trigger', function (e) {
    //     e.preventDefault();
    //     $('#carousel .owl-item.active a').click();
    //     $('#carousel1 .product-items-carousel.active a').click();
    // });

    $(document).on('click', '.carousel-thumbnail-item', function () {
        const itemPosition = $(this).data('slide-to');
        $owl
            .trigger('to.owl.carousel', [itemPosition, 0])
            .trigger('stop.owl.autoplay')
            .trigger('play.owl.autoplay', [15000, 300]);
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


// thumbmail image start here
$(document).ready(function () {
    $('#carousel').owlCarousel({
        items: 1,
        loop: true,
        autoplay: false,
        nav: true,
        dots: false,
    });
    $('#thumbnail-carousel').owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        dots: false,
    });
    $('.thumbnail-link').on('click', function () {
        var index = $(this).data('index');
        $('#carousel').trigger('to.owl.carousel', [index + 1, 300]);
    });


    $('.btn-360').on('click', function () {
        var videoUrl = $(this).data('video');
        $('#carousel').trigger('to.owl.carousel', [0, 300]);

        // Update the main carousel to show the 360 video
        var videoHtml = `<a id="variationAnchorVideo" data-fancybox="gallery1" href="${videoUrl}" data-caption="">
			<video id="variationVideo" style="width: 100%;" loop autoplay muted="1" playsinline>
			<source src="${videoUrl}" type="video/mp4" />
			</video></a>`;
        $('#carousel .owl-item.active').html(videoHtml);
    });
});

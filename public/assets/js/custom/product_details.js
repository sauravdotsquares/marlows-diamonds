/** This function is use to get all selected ids */
function getSelectedAttributeIds() {
    var ids = [];
    $('.attr-selection').each((index,element)=>{
        if($(element).attr('type') == 'radio'){
            if($(element).is(':checked')){
                ids.push($(element).val());
            }
        }else{
            ids.push($(element).val());
        }			
    });
    return ids;
}//endof getSelectedAttributeIds


/** This function is use to add and remove item from wishlist */
$(document).on('click', '.wishlist-button', function() {
    const thisItem = $(this);
    thisItem.find('#wishlist_icon').removeAttr('class').attr('class','fa fa-spinner fa-spin');
    thisItem.attr('disabled', 'disabled');

    /** selected attribute ids */
    const selected_attr_id = getSelectedAttributeIds();

    $.ajax({
        url: addToWishlistUrl,
        type: "post",
        data: {
            '_token': csrf,
            'productSlug':productSlug,
            'attribute_ids': selected_attr_id.join(',')
        },
        success: function(data) {
            if(data.status){
                if(data.wishlist_status){
                    thisItem.find('#wishlist_icon').removeAttr('class').attr('class','fa fa-heart-o');
                    thisItem.removeAttr('disabled');
                }else{
                    thisItem.find('#wishlist_icon').removeAttr('class').attr('class','fa fa-heart');
                    thisItem.removeAttr('disabled');
                }
            }else{
                toastr.error(response.message);
                thisItem.removeAttr('disabled');
            }
        },
        error: function(error) {
            thisItem.removeAttr('disabled');
        }
    });
})
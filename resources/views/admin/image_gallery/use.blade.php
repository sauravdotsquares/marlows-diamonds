@extends('layouts.admin.app')
@section('content')

<div class="rm-file-picker"></div>
<div class="rm-file-picker"></div>




@endsection


@section('js')
<script>


const createButton = (pickerId='', btnClasses='') => {
    return $('<button/>', {
        text: 'Choose file',
        id: 'file-picker-btn_' + pickerId,
        class: btnClasses ? btnClasses : 'btn btn-success'
    });
}

const createInputField = (pickerId='', inputName='',value='') => {
    return $('<input/>', {
        type: 'text',
        name: inputName ? inputName : 'media-id',
        id: 'file-picker-input_' + pickerId,
        value: value
    });
}

const createUniqueId = () => {
    return (new Date()).getTime();
}

const showModal = (modalId="") => {
    $("#" + modalId).modal('show');
}

const hideModal = (modalId="") => {
    $("#" + modalId).modal('hide');
}

const createModalHtml = (pickerId="", modalHeading="") => {
    const modalFullId = `file-picker-modal_${pickerId}`;

    modalHeading = modalHeading ? modalHeading : 'Media picker';

    return `<div>
        <div class="modal fade" id="${modalFullId}">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">${modalHeading}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="dataToAppend"></div>
                        <div class="load-more-container">
                            <button class="btn btn-success btn-block load-more-data">More data ${pickerId}</button>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" onclick="hideModal('${modalFullId}')" >Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div> `;
}


const getData = (currentElement, url, data, callback) => {

    const getParams = queryString(data);

    $.ajax({
        type: "POST",
        url: url + '?' + getParams,
        dataType: 'json',
        data: {
            _token: '{{ csrf_token() }}'
        },
        success: function(data){

            if(data.status && data.data.data){
                const currentPage = data.data.current_page;
                const dataToAppend = data.data.data;

                /** Hide and show load more button */
                if(!data.data.next_page_url){
                    currentElement.find(".load-more-data").css('display','none');
                }else{
                    currentElement.find(".load-more-data").css('display','block');
                }
                currentElement.find('input[name="currentPage"]').val(currentPage);
                if(dataToAppend.length){
                    dataToAppend.forEach(( element)=>{
                        const html = htmlToAppend(element);
                        currentElement.find('.dataToAppend').append(html);
                    });
                }
            }
            
            callback(data);
        },
        error: function(error){
            console.log('error', error);
        }
    });
}

const htmlToAppend = (data) => {

    return `
        <div>${data.original_name}</div>
    `;

}

const queryString = function(obj) {
  var str = [];
  for (var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}


$.fn.rmFilePicker = function(options={}){

    $(this).each(function(index,element){
        var currentItem = $(element);
        const pickerId = createUniqueId();
        
        const button = createButton(pickerId, options.btnClasses);
        const pickerInput = createInputField(pickerId, options.inputName);
        const currentPageInput = createInputField(pickerId + '-page', 'currentPage');
        const pickerModal = createModalHtml(pickerId);

        currentItem.append(button); // create button 
        currentItem.append(pickerInput); // create hidden input
        currentItem.append(currentPageInput); // create hidden input
        currentItem.append(pickerModal); // create hidden input

        const modalId = 'file-picker-modal_' + pickerId;
        const inputId = 'file-picker-input_' + pickerId;
        const buttonId = 'file-picker-btn_' + pickerId;

        currentItem.find('#'+buttonId).on('click', function(){
            currentItem.find('.dataToAppend').empty();
            getData(currentItem, options.url, {}, ()=>{});
            currentItem.find(`#${modalId}`).modal('show');
        });

        currentItem.find(".load-more-data").on('click', function(){
            const currentPage = currentItem.find('input[name="currentPage"]').val();
            getData(currentItem, options.url, {
                page: parseInt(currentPage) + 1,
            }, ()=>{});
        })
    })
}


$(".rm-file-picker").rmFilePicker({
    btnClasses : "btn btn-success",
    inputName: "media-ids",
    url: "{{  route('admin.image_gallery.getFilesList') }}"
});

</script>
@endsection
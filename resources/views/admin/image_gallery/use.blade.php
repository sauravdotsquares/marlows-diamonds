@extends('layouts.admin.app')
@section('content')

<div class="rm-file-picker"></div>




@endsection

@section('css')
<style>
    .data-list.active{
        background: red;
    }
</style>
@endsection

@section('js')
<script>



(function ( $ ) {
    const createButton = (settings={}) => {
        return $('<button/>', {
            text: settings.fileSelectorBtnText,
            id: 'file-picker-btn_',
            class: settings.btnClasses ? settings.btnClasses : 'btn btn-success'
        });
    }

    const createInputField = (inputId,inputName='',value='') => {
        return $('<input/>', {
            type: 'hidden',
            name: inputName ? inputName : 'media-id',
            id:  inputId ? inputId : 'file-picker-input_',
            value: value
        });
    }

    const createUniqueId = () => {
        return (new Date()).getTime();
    }

    const createModalHtml = (pickerId="", settings={}) => {
        const modalFullId = `file-picker-modal_`;

        return `<div class="modal fade" id="${modalFullId}">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">${settings.modalHeading}</h4>
                        </div>
                        <div class="modal-body">
                            <div class="dataToAppend"></div>
                            <div class="load-more-container">
                                <button class="btn btn-success btn-block load-more-data">${settings.moreButtonText}</button>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-right">
                            <button type="button" class="btn btn-primary close-btn">${settings.okButtonText}</button>
                        </div>
                    </div>
                </div>
            </div>`;
    }

    const getData = (currentElement, settings, data) => {

        const getParams = queryString(data);
        currentElement.find(".load-more-data").attr('disabled','disabled');

        $.ajax({
            type: "POST",
            url: settings.url + '?' + getParams,
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
                currentElement.find(".load-more-data").removeAttr('disabled');
            },
            error: function(error){
                console.log('error', error);
                currentElement.find(".load-more-data").removeAttr('disabled');
            }
        });
    }

    const htmlToAppend = (data) => {
        return `<div class="data-list" data-value="${data.id}">${data.original_name}</div>`;
    }

    const queryString = function(obj) {
        var str = [];
        for (var p in obj)
            if (obj.hasOwnProperty(p)) {
            str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
            }
        return str.join("&");
    }

    $.fn.rmFilePicker = function(options){

        /** This is the easiest way to have default options. */
        var settings = $.extend({
            btnClasses: "#556b2f",
            inputName: "white",
            url: "",
            moreButtonText: "More data",
            modalHeading: "Media information",
            fileSelectorBtnText: "Select file",
            okButtonText: "Ok!",
            onDataReceive: () => {}
        }, options);


        this.each(function(index,element){
            var currentItem = $(element);
            const pickerId = createUniqueId();
            
            const button = createButton(settings);
            const pickerInput = createInputField('', settings.inputName);
            const currentPageInput = createInputField( 'current-page-input', 'currentPage');
            const pickerModal = createModalHtml(pickerId, settings);

            currentItem.append(button); // create button 
            currentItem.append(pickerInput); // create hidden input
            currentItem.append(currentPageInput); // create hidden input
            currentItem.append(pickerModal); // create hidden input

            const modalId = 'file-picker-modal_';
            const inputId = 'file-picker-input_';
            const buttonId = 'file-picker-btn_';

            currentItem.find('#'+buttonId).on('click', function(){
                currentItem.find('.dataToAppend').empty();
                getData(currentItem, settings);
                currentItem.find(`#${modalId}`).modal('show');
            });

            currentItem.find(".load-more-data").on('click', function(){
                const currentPage = currentItem.find('input[name="currentPage"]').val();
                getData(currentItem, settings, {
                    page: parseInt(currentPage) + 1,
                });
            });

            currentItem.find(".close-btn").on('click',function(){
                currentItem.find(`#${modalId}`).modal('hide');
            });

            currentItem.on('click',".data-list", function(){
                const selectedValue = $(this).attr('data-value');
                $(this).toggleClass('active');

                let selected_elements = [];
                currentItem.find(".data-list.active").each((index, element)=>{
                    const selectedId = $(element).attr('data-value');
                    selected_elements.push(selectedId);
                });
                
                currentItem.find("#"+inputId).val(selected_elements);
            });

        })
    }
}( jQuery ));


$(".rm-file-picker").rmFilePicker({
    btnClasses : "btn btn-success",
    inputName: "media-ids",
    url: "{{  route('admin.image_gallery.getFilesList') }}",
    okButtonText: "Save selections",
    onDataReceive: function(data){
        console.log('first', data);
    }
});

</script>
@endsection
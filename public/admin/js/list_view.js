/**
 * addDots
 * @param {*} text 
 * @param {*} limit 
 * @returns 
 */
function addDots(text, limit){
    if(typeof text=='undefined' || text=='' || text==null){return 'N/A'};
    return text.length > limit ? `${text.substring(0, limit)}...` : text;
} // endof addDots


function hideLoader() {
    
}

/**
 * initViewForList
 * @param {*} options 
 */
function initViewForList(options){
    
    const htmlContent = options.html;
    const csrf = options.csrf;
    const url = options.url;
    const contentAppendAt = options.contentAppendAt; //event append at
    const showMoreAppendAt = options.showMoreAppendAt; // event of event showMore
    
    const recordsAccess = typeof options.noRecords!='undefined' && options.noRecords!='' ? options.noRecords : true;
    const noRecordsImage = typeof options.noRecordsImage!='undefined' && options.noRecordsImage!='' ? options.noRecordsImage : data_not_found_image;

    const processComplete = typeof options.onComplete!="undefined" ? options.onComplete :  function onComplete(...arg){  } ;
    const loader = typeof options.loader!="undefined" && options.loader==true ? true : false ;

    var showMoreButton = function(pageNo){
        // <a id="addtobasket" href="javascript:void(0);" class="btn-bg-small" role="button">Add to basket</a>
        return `<div class="card-action border-non center show_more_button"><a onClick="callAjaxCard(${pageNo},true)" class="btn-bg-small">Show more</a></div>`
    };

    var loadingShowMore = function(){
        $(".show_more_button>a").addClass('disabled');
        $(".show_more_button>a").text('Loading...');
    }

    var stopLoadingShowMore = function(){
        $(".show_more_button>a").removeClass('disabled');
        $(".loading_show_more").remove();
    }

    if(loader){
        console.log('loader',loader);
        showLoader();
    }

    /** Show data on scroll */
    var triggerScrollEvent = true;
    $(document).on('scroll',function(){
        if($(".show_more_button").length){
            if($(".show_more_button").isInViewport()){
                if(triggerScrollEvent){
                    triggerScrollEvent = false;
                    $(".show_more_button>a").trigger('click');
                }
            };
        }
    });

    $(".search-card").on('keyup change click',function(){
        callAjaxCard('1');
    });
    
    callAjaxCard = function(page,isShowMore=false){

        if(isShowMore){
            loadingShowMore();
            // showLoader();
        }

        var searchvalues = {};
        $(".search-card").each((e,i)=>{
            var value = $(i).val();
            var name = $(i).attr('name');
            searchvalues[name] = value;
        });

        let form_data = new FormData();
        form_data.append('pageNo',page);
        form_data.append('_token',csrf);
        form_data.append('search',searchvalues ? JSON.stringify(searchvalues) : false);

        $.ajax({
            url: url,
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false,
            error: function (errorData) {
                triggerScrollEvent=true;
                hideLoader();
                $(this).prop("disabled", false);
                
            },
            success:function(response){

                if(response.data.length){

                    if(!isShowMore){
                        contentAppendAt.empty();
                    }

                    $(".show_more_button").remove();
                    response.data.forEach((e,i)=>{
                        var html = htmlContent(e);
                        contentAppendAt.append(html);
                    });

                    if(response.isNextPage){
                        var nextPageHtml = showMoreButton(response.nextPage);
                        showMoreAppendAt.append(nextPageHtml);
                    };
                    
                    // if($('.dropdown-trigger').length){
                    //     $('.dropdown-trigger').dropdown({
                    //         inDuration: 300,
                    //         outDuration: 225,
                    //         constrainWidth: false,
                    //         hover: false,
                    //         gutter: 0,
                    //         coverTrigger: false,
                    //         alignment: 'left',
                    //         stopPropagation: false
                    //     });
                    // };
                }else{
                    contentAppendAt.empty();
                    $(".show_more_button").remove();
                }
                
                if(!$(recordsAccess).length){
                    const notFoundHtml = `<div class="card-content center">
                        ${noRecordsImage ? `<img src="${noRecordsImage}" class="width-40 responsive-img" alt="image">` : `No records found` }
                    </div>`;
                    contentAppendAt.append(notFoundHtml);
                }
                
                
                hideLoader();
                stopLoadingShowMore();
                processComplete(response.data.length);
                triggerScrollEvent=true;
            }
        });
    }

    callAjaxCard('1');
} // endof 
var MarlowsAPP = angular.module('MarlowsAPP', ['ui.bootstrap','ngRoute', 'ngSanitize'], function($interpolateProvider) {
$interpolateProvider.startSymbol('<%');
$interpolateProvider.endSymbol('%>');

});

// var base_url = "/api/v1/";
var base_url = systemBaseUrl + 'api/v1/';

/******** Define the Common controller  ***************/

MarlowsAPP.controller("CommonController",function($scope, $http,$compile) {
    
    $scope.searchProducts = function(){
        // console.log($scope.search);
        var url  = base_url+"searchProducts";
        if($scope.search){
            $http({
                method  : 'POST',
                url     : url,
                data    : {name:$scope.search}
            }).success(function(data) {
                    // console.log(data);
                    $('.search-suggestion').show();
                    $scope.searchResults = data;
            });
        }else{
            $('.search-suggestion').hide();
        }
    }

   
});
/******** Define the diamond search controller  ***************/

MarlowsAPP.controller("DiamondSearchController",function($scope, $http,$compile,$window,$sce, $timeout,diamondSearchService) {
    
    $scope.getDiamondResults=function(){
        $scope.loader=true;
        $scope.limit= 10;
        $scope.totalPages = 0;
        $scope.currentPage = 1;
        $scope.range = [];

        $scope.shape = $("input[name='shape']:checked").val(); // Shape
        $scope.payment_mode = $("input[name='payment_mode']:checked").val(); // Shape

        $scope.temp_value_type = $("input[name=payment_mode]").prop('checked');
        $scope.temp_value_partial_deposit_payment = parseInt($("#partial_deposit_payment").val());
       

        setTimeout(function() { // Carat
            $scope.carat_min = $("#input-carat-min").val();
            $scope.carat_max = $("#input-carat-max").val();
            getData();
        }, 0);
        
        $scope.colour = [];
        $("input[name='colour[]']:checked").each(function () { // Colour
            $scope.colour.push($(this).val());
        });
        $scope.clarity = [];
        $("input[name='clarity[]']:checked").each(function () { // Clarity
            $scope.clarity.push($(this).val());
        });
        $scope.grade = [];
        $("input[name='grade[]']:checked").each(function () { // Cut grade
            $scope.grade.push($(this).val());
        });

        $scope.polish = [];
        $("input[name='polish[]']:checked").each(function () { // Polish
            $scope.polish.push($(this).val());
        });
        $scope.symmetry = [];
        $("input[name='symmetry[]']:checked").each(function () { // Symmetry
            $scope.symmetry.push($(this).val());
        });
        $scope.fluorescence = [];
        $("input[name='fluorescence[]']:checked").each(function () { // Fluorescence
            $scope.fluorescence.push($(this).val());
        });

        $scope.certificate = [];
        $("input[name='certificate[]']:checked").each(function () { // Certificate
            $scope.certificate.push($(this).val());
        });

        $scope.partial_deposit_payment = [];
        $("input[name='payment_mode']:checked", function () { // Flu
            var temp_value = 0;
            if($("input[name=payment_mode]").prop('checked')){
                temp_value = $("#full_payment").val();
            }else{
                temp_value = $("#partial_deposit_payment").val();
            }
            $scope.partial_deposit_payment.push(temp_value);
        });

        
        
        function getData(){
            
            $scope.fromService = diamondSearchService.diamondSearch($scope.limit,$scope.currentPage,$scope.next_page_url,$scope.shape,$scope.carat_min,$scope.carat_max,$scope.colour,$scope.clarity,$scope.grade,$scope.polish,$scope.symmetry,$scope.fluorescence,$scope.certificate,$scope.partial_deposit_payment).then(function(result) {

                
               
               
                $scope.data = result.data.data;
                
                $scope.paging = result.data;
                if($scope.temp_value_type){
                    $scope.partial_deposit_payment = $scope.paging.firstDiamondAmount;
                }else{
                    $scope.partial_deposit_payment = $scope.paging.firstDiamondAmount * ($scope.temp_value_partial_deposit_payment / 100);
                }
                if($scope.data.length){
                    $scope.currentPage = $scope.paging.current_page;
                    $scope.numPerPage = $scope.paging.per_page;
                    $scope.maxSize = 2;
                    $scope.totalItems = $scope.paging.total;
                    $scope.next_page_url = $scope.paging.next_page_url;
                    $scope.prev_page_url = $scope.paging.prev_page_url;
                    $scope.totalPages = $scope.paging.last_page;
                    $scope.VAT = $scope.paging.VAT;
                    $scope.firstDiamondAmount = $scope.paging.firstDiamondAmount;
                    $scope.isPagignationShow = true;
                }else{
                    $scope.currentPage = $scope.paging.current_page;
                    $scope.numPerPage = $scope.paging.per_page;
                    $scope.maxSize = 1;
                    $scope.totalItems = $scope.paging.total;
                    $scope.next_page_url = $scope.paging.next_page_url;
                    $scope.prev_page_url = $scope.paging.prev_page_url;
                    $scope.totalPages = $scope.paging.last_page;
                    $scope.VAT = $scope.paging.VAT;
                    $scope.firstDiamondAmount = $scope.paging.firstDiamondAmount;
                    $scope.isPagignationShow = false;
                }
                
                // $scope.partial_deposit_payment = $scope.paging.firstDiamondAmount/10;
                $scope.loader=false;
                // console.log('Sumit', $scope);
            });


        }
        $scope.pageChanged = function() {
            $scope.loader=true;
            getData();
        };
    };

    $scope.updateDiamondPrice = function(price){
        $scope.firstDiamondAmount = price;
        if($scope.temp_value_type){
            $scope.partial_deposit_payment = $scope.firstDiamondAmount;
        }else{
            $scope.partial_deposit_payment = $scope.firstDiamondAmount * ($scope.temp_value_partial_deposit_payment / 100);
        }
        // console.log("Sumit", $scope);
    }

});

/******** Define the Product controller  ***************/

MarlowsAPP.controller("ProductController",function($scope, $http,$compile) {
    
    $scope.productCatFilters = function(cat1,cat2,cat3){
        $scope.display_filter = false;
        var url  = base_url+"getProductCatFilter";
        $http({
            method  : 'POST',
            url     : url,
            data    : {cat1:cat1,cat2:cat2,cat3:cat3}

        }).success(function(data) {
            $scope.display_filter = true;
            $scope.parent_cat = data.parent_cat;
            $scope.subCats = data.subCats;

            $scope.subSubCats = data.subSubCats;
            if(data.subSubCats.length==0){
                $scope.showsubCatOnly = 'display_first_filter';
            }else{
                $scope.showsubCatOnly = '';
            }
        });
    }

   
});
/******** Define the Dekopay controller  ***************/

MarlowsAPP.controller("DekopayController",function($scope, $http,$compile) {
    var dekoFilters = null;
    if(undefined !== window.dekofilters){
        dekoFilters = window.dekofilters;
    }
    $scope.financeOptions = function(){
        $scope.term='ONIB12-22.9';
        $scope.percentage='10';
        $scope.productPrice = $("#finaldiamondprice .price").text().replace("£", "");
        $('#totalOrder').val($scope.productPrice);
        $('#totalOrderText').text($scope.productPrice);
        $('#totalOrderText').attr('data-val',$scope.productPrice);
        $('#financeAvailableModal').modal('show');
        if(undefined !== $('#totalOrderText') && null != $('#totalOrderText')){
            
            alterFilters(); 

            $scope.dekoInit(); 
        }
    }
    $scope.financeOptionsCheckout = function(){
        $scope.term='ONIB12-22.9';
        $scope.percentage='10';
       
        alterFilters(); 

        $scope.dekoInit(); 
        
    }
    $scope.calculate = function(){
       $scope.dekoInit(); 
    }
    function alterFilters(){
                if(null != dekoFilters){
                var term = $('select[name="term"]').val(); 
                if(dekoFilters.hasOwnProperty(term)){
                    termProp = parseInt(dekoFilters[term]);
                    $('select[name="percentage"] option').attr('disabled', 'disabled'); 
                    $('select[name="percentage"] option').each(function(){
                        var valInt = parseInt($(this).val());
                        if(valInt >= termProp){
                            $(this).removeAttr('disabled'); 
                        }
                    });
                    
                }else{
                    $('select[name="percentage"] option').removeAttr('disabled'); 
                }
        }
     }
    function alterMinOption(){
       var payedVal = $('select[name="percentage"]').val();
       var update = false;
       $('select[name="percentage"] option').each(function(){   
           if($(this).val() == payedVal){
                if($(this).prop('disabled')){
                    update = true;  
                }
           }
       });     
        if(update || payedVal == null){
            $('select[name="percentage"]').val($('select[name="percentage"] option:not([disabled]):first'));
            $('select[name="percentage"] option:not([disabled]):first').prop('selected', 'selected');
        }
    }
    $scope.dekoInit = function(){
        
        alterMinOption(); 
       //Call the api 
       var price = $('#totalOrder').val();
       var payedVal = $('#payed').val();

       var deposit  = parseFloat($('#payed').val()); 

       var code = $('#terms').val();
      
       $('#payPro').val(code); 
       $('#payPer').val(payedVal); 
        
       var amount = (parseFloat(price)/100)* deposit;
       var my_fd = new FinanceDetails(code, parseFloat(price), deposit, amount);
       
       var preSetVal = parseFloat($('#preSetValue').val());
       //console.log(price);
       //console.log(preSetVal);
       if(price>preSetVal){
            $('.finance-available-options').css('display','block');
            $('.finance_options_not_available').css('display','none');
        }else{
            $('.finance-available-options').css('display','none');
            $('.finance_options_not_available').css('display','block');
       }

       $('#perMonths').text(parseFloat(my_fd.m_inst).toFixed(2)); 
       $('#cashPrices').text(parseFloat(my_fd.goods_val).toFixed(2));
       $('#Deposited').text(parseFloat(my_fd.d_amount).toFixed(2));
       $('#loanAmt').text(parseFloat(my_fd.l_amount).toFixed(2));
       $('#loanRepay').text(parseFloat(my_fd.l_repay).toFixed(2));
       $('#costLoan').text(parseFloat(my_fd.l_cost).toFixed(2));
       $('#totalAmt').text(parseFloat(my_fd.total).toFixed(2));
       $('#noTerm').text(my_fd.term);
    }
   
});
/*
*** Angular JS Services
*/

MarlowsAPP.service('diamondSearchService', function($http, $location){
    var apiUrl = base_url;
    this.diamondSearch= function(limit,currentPage, nextpage,shape,carat_min,carat_max,colour,clarity,grade,polish,symmetry,fluorescence,certificate){
        
        var apiUrls = '';
        if(nextpage == ''){
            apiUrls = apiUrl+'getDiamondDataFromAPI?page='+1+'&shape='+shape+'&carat_min='+carat_min+'&carat_max='+carat_max+'&colour='+colour+'&clarity='+clarity+'&grade='+grade+'&polish='+polish+'&symmetry='+symmetry+'&fluorescence='+fluorescence+'&certificate='+certificate;
        } else {
            apiUrls = apiUrl+'getDiamondDataFromAPI?page='+currentPage+'&shape='+shape+'&carat_min='+carat_min+'&carat_max='+carat_max+'&colour='+colour+'&clarity='+clarity+'&grade='+grade+'&polish='+polish+'&symmetry='+symmetry+'&fluorescence='+fluorescence+'&certificate='+certificate;
        }
        return $http({
            method: 'GET',
            url: apiUrls
        });
    };
});


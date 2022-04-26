var MarlowsAPP = angular.module('MarlowsAPP', ['ui.bootstrap','ngRoute', 'ngSanitize'], function($interpolateProvider) {
$interpolateProvider.startSymbol('<%');
$interpolateProvider.endSymbol('%>');

});

var base_url = "/api/v1/";


/******** Define the diamond search controller  ***************/

MarlowsAPP.controller("DiamondSearchController",function($scope, $http,$compile,$window,$sce, $timeout,diamondSearchService) {
    
    $scope.getDiamondResults=function(){
        $scope.loader=true;
        $scope.limit= 10;
        $scope.totalPages = 0;
        $scope.currentPage = 1;
        $scope.range = [];

        $scope.shape = $("input[name='shape']:checked").val();
        setTimeout(function() {
            $scope.carat_min = $("#input-carat-min").val();
            $scope.carat_max = $("#input-carat-max").val();
            getData();
        }, 0);
       
        
        function getData(){
            
            $scope.fromService = diamondSearchService.diamondSearch($scope.limit,$scope.currentPage,$scope.next_page_url,$scope.shape,$scope.carat_min,$scope.carat_max).then(function(result) {
               
                $scope.data = result.data.data;
                
                $scope.paging = result.data;
                $scope.currentPage = $scope.paging.current_page;
                $scope.numPerPage = $scope.paging.per_page;
                $scope.maxSize = 10;
                $scope.totalItems = $scope.paging.total;
                $scope.next_page_url = $scope.paging.next_page_url;
                $scope.prev_page_url = $scope.paging.prev_page_url;
                $scope.totalPages = $scope.paging.last_page;
                $scope.VAT = $scope.paging.VAT;
                $scope.firstDiamondAmount = $scope.paging.firstDiamondAmount;
                $scope.loader=false;
            });


        }
        $scope.pageChanged = function() {
            $scope.loader=true;
            getData();
        };
    };

    $scope.updateDiamondPrice = function(price){
        $scope.firstDiamondAmount = price;
    }

});


/*
*** Angular JS Services
*/

MarlowsAPP.service('diamondSearchService', function($http, $location){
var apiUrl = base_url;
this.diamondSearch= function(limit,currentPage, nextpage,shape,carat_min,carat_max){
    
    var apiUrls = '';
    if(nextpage == ''){
        apiUrls = apiUrl+'getDiamondDataFromAPI?page='+1+'&shape='+shape+'&carat_min='+carat_min+'&carat_max='+carat_max;
    } else {
        apiUrls = apiUrl+'getDiamondDataFromAPI?page='+currentPage+'&shape='+shape+'&carat_min='+carat_min+'&carat_max='+carat_max;
    }
    return $http({
        method: 'GET',
        url: apiUrls
    });
};
});


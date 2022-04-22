var MarlowsAPP = angular.module('MarlowsAPP', ['ngRoute', 'ngSanitize'], function($interpolateProvider) {
$interpolateProvider.startSymbol('<%');
$interpolateProvider.endSymbol('%>');

});

var base_url = "/api/v1/";


/******** Define the main controller  ***************/

MarlowsAPP.controller("mainController", function($scope,$http,GlobalSearch) {

$scope.next_page = '1';
$scope.limit= 2;
$scope.currentPage = 1,
    $scope.course_list = [];
$scope.next_page_url = '';
$scope.show = true;
$scope.flag = true;

getData($scope.next_page_url);
$scope.currentPage = $scope.next_page;
function getData(){
    $scope.flag = false;
    $scope.fromService = GlobalSearch.searchcourse($scope.limit,$scope.currentPage, $scope.next_page_url).then(function(result) {
        $scope.show = false;
        $scope.flag = true;
        if($scope.course_list.length == 0){
            $scope.course_list = result.data.course_list.data;
        }else {
            $scope.course_list = $scope.course_list.concat(result.data.course_list.data);
        }

        $scope.paging = result.data.course_list;

        $scope.currentPage = $scope.paging.current_page,
            $scope.numPerPage = $scope.paging.per_page,
            $scope.maxSize = 5;
        $scope.totalItems = $scope.paging.total;
        $scope.next_page_url = $scope.paging.next_page_url;
        $scope.prev_page_url = $scope.paging.prev_page_url;

    });
}
$scope.pageChanged = function() {
    if($scope.flag==true){
        getData($scope.next_page_url);
    }
};
$scope.getCatType = function(cat){
    return cat=='2'?'f2f-course':'course';
}
$scope.getCourseURL = function(baseURL, type, course_slug){
    course_slug = course_slug || '';
    return baseURL+"/"+$scope.getCatType(type)+"/"+course_slug;
}
});

MarlowsAPP.service('GlobalSearch', function($http, $location){

var firscatturl = $location.absUrl().split('/');
var lang = firscatturl[3];
var action = $("#sreachGlobal").val();
var type = $("#type").val();

if(typeof lang == 'undefined'){
    lang = 'en';
}


this.searchcourse= function(limit,currentPage, nextpage){
    
    var apiUrls = '';
    if(nextpage == ''){
        apiUrls = base_url+'GlobalSearch'+"?page="+1;
    }  else {
        apiUrls = nextpage;
    }
    return $http({
        method: 'POST',
        url: apiUrls,
        data: { "lang": lang, "action": action, "type": type  },

    });
};

});

MarlowsAPP.controller("commonController",function($scope, $http,$mdDialog,$compile,$window,$sce, $timeout,newsCatService) {
    //Get news by category
    $scope.getNewsCategory=function(){
        $scope.limit= 10;
        $scope.currentPage = 1,
            $scope.newsCat = [];

        getData();
        function getData(){
            $scope.fromService = newsCatService.newsCat($scope.limit,$scope.currentPage,$scope.next_page_url).then(function(result) {

                $scope.newsCat = result.data.data;
                $scope.paging = result.data;
                $scope.currentPage = $scope.paging.current_page,
                $scope.numPerPage = $scope.paging.per_page,
                $scope.maxSize = 5;
                $scope.totalItems = $scope.paging.total;
                $scope.next_page_url = $scope.paging.next_page_url;
                $scope.prev_page_url = $scope.paging.prev_page_url;
            });
        }
        $scope.pageChanged = function() {
            getData();
        };
    };
});

MarlowsAPP.controller("DiamondSearchController",function($scope, $http,$compile,$window,$sce, $timeout,diamondSearchService) {
    //Get news by category
    $scope.getDiamondResults=function(){
        $scope.limit= 10;
        $scope.currentPage = 1,
        $scope.shape = $("input[name='shape']:checked").val();
        $scope.carat = [];
        //$scope.filterdata = [];
        console.log($scope.shape);
        getData();
        function getData(){
            $scope.fromService = diamondSearchService.diamondSearch($scope.limit,$scope.currentPage,$scope.next_page_url,$scope.filterdata).then(function(result) {

                $scope.data = result.data.data;
                $scope.paging = result.data;
                $scope.currentPage = $scope.paging.current_page,
                $scope.numPerPage = $scope.paging.per_page,
                $scope.maxSize = 5;
                $scope.totalItems = $scope.paging.total;
                $scope.next_page_url = $scope.paging.next_page_url;
                $scope.prev_page_url = $scope.paging.prev_page_url;
            });
        }
        $scope.pageChanged = function() {
            getData();
        };
    };
});


/*
*** Angular JS Services
*/

MarlowsAPP.service('diamondSearchService', function($http, $location){
var apiUrl = base_url;
this.diamondSearch= function(limit,currentPage, nextpage,filterdata){
    
    var apiUrls = '';
    if(nextpage == ''){
        apiUrls = apiUrl+'getDiamondDataFromAPI?page='+1+filterdata;
    } else {
        apiUrls = apiUrl+'getDiamondDataFromAPI?page='+currentPage+filterdata;
    }
    return $http({
        method: 'GET',
        url: apiUrls
    });
};
});
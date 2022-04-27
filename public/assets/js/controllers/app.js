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

        $scope.shape = $("input[name='shape']:checked").val(); // Shape

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
        
        function getData(){
            
            $scope.fromService = diamondSearchService.diamondSearch($scope.limit,$scope.currentPage,$scope.next_page_url,$scope.shape,$scope.carat_min,$scope.carat_max,$scope.colour,$scope.clarity,$scope.grade,$scope.polish,$scope.symmetry,$scope.fluorescence,$scope.certificate).then(function(result) {
               
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


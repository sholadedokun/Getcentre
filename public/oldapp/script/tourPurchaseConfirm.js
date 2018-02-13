// JavaScript Document
var TourPurchaseConfirm =  angular.module('TourPurchaseConfirm', ['angular.filter', 'ui.bootstrap']);

 TourPurchaseConfirm.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
 })
TourPurchaseConfirm.controller('TourPurchaseConfirm', ['$scope', 'searchData', 'tourpConfirmRs', 'purchaseData', function($scope, searchData, tourpConfirmRs, purchaseData) {
	$scope.getData= searchData.data();
	$scope.getSelected= purchaseData.data();
	console.log($scope.getSelected);
	$scope.tpurchaseConf =  tourpConfirmRs.get({
	ptoken:$scope.getSelected[0]['@purchaseToken'], 
	SerSpui:$scope.getSelected[0].ServiceList.Service['@SPUI']},
	function(tpurchaseConf) {	$scope.AddedServRs=$scope.tpurchaseConf
	console.log($scope.AddedServRs);
	purchaseData.setData($scope.AddedServRs)
	//$scope.cancel_policies=$scope.AddedServRs.ServiceList.Service.AvailableRoom
	
	//$scope.mainImageUrl = $scope.Tour_Detail.details[0].img_path;
  });
  
}]);




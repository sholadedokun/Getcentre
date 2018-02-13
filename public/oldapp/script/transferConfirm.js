// JavaScript Document
var transferConfirm =  angular.module('transferConfirm', ['angular.filter', 'ui.bootstrap']);
 transferConfirm.directive('onFinishRender', function ($timeout) {
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
transferConfirm.controller('transferConfirm', ['$scope', 'searchData', 'transferData', 'purchaseData', 'userData', function($scope, searchData, transferData, purchaseData, userData) {
	
	$scope.getData= searchData.data();
	$scope.getTransfer= transferData.data();
	console.log($scope.getTransfer);
	$scope.adultGuest=$scope.getTransfer[1][0]
	$scope.transInfo=$scope.getTransfer[0]
	$scope.user=userData.data()[1];
	console.log($scope.adultGuest);
	var lead_index=$scope.getTransfer.length;
	console.log($scope.getTransfer[lead_index-1]);
	$scope.getSelected= purchaseData.data();
	console.log($scope.getSelected);
	
  
}]);

transferConfirm.controller('paymentDialog', function ($scope, $modal, $log) {
	
	$scope.makePayment = function () {
		console.log("I was here");
		var modalInstance = $modal.open({
		  templateUrl: 'makePayment.html',
		  controller: 'ModalpaymentCtrl',
		  size: 'lg',
		  resolve: {
			tour: function () {
			  return $scope.tour;
			}
		  }
		});
	  };
});

transferConfirm.controller('ModalpaymentCtrl', ['$scope',  'tourpConfirmRs', 'purchaseData', '$modalInstance', '$location', function($scope,  tourpConfirmRs, purchaseData, $modalInstance, $location) {
  $scope.temp_getTour=[];//stores temporary tours before voing them...  
  $scope.selectedTour=[];//stores temporary tours before voing them...  
  $scope.checktour=[];
  $scope.adult_sel=1; $scope.child_sel=2;
  
  $scope.ok = function() {
	$location.path('/booked');
    $modalInstance.close();
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);


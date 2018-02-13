// JavaScript Document
var tourConfirm =  angular.module('tourConfirm', ['angular.filter', 'ui.bootstrap']);

 tourConfirm.directive('onFinishRender', function ($timeout) {
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
tourConfirm.controller('tourConfirm', ['$scope', 'searchData', 'tourData', 'purchaseData', 'userData', function($scope, searchData, tourData, purchaseData, userData) {
	
	$scope.getData= searchData.data();
	$scope.getTour= tourData.data();
	console.log($scope.getTour);
	//$scope.adultGuest=$scope.getTour[1][0]
	$scope.transInfo=$scope.getTour[0]
	$scope.user=userData.data()[1];
	
	var lead_index=$scope.getTour.length;
	console.log($scope.getTour[lead_index-1]);
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

transferConfirm.controller('ModalpaymentCtrl', ['$scope', '$modalInstance', '$location', function($scope, $modalInstance, $location) {
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




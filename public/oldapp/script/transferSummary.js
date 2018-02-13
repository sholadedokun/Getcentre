// JavaScript Document
var transferSummary =  angular.module('transferSummary', ['angular.filter', 'ui.bootstrap']);
 transferSummary.directive('onFinishRender', function ($timeout) {
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
transferSummary.controller('transferSummary', ['$scope', 'searchData', 'transferData', 'purchaseData', 'serviceAddRs', 'userData','$location', function($scope, searchData, transferData, purchaseData, serviceAddRs, userData, $location) {
	$scope.getData= searchData.data();
	$scope.getTransfer= transferData.data();
	console.log($scope.getTransfer);
	$scope.adultGuest=$scope.getTransfer[1][0]
	$scope.transInfo=$scope.getTransfer[0]
	$scope.purchaseD=purchaseData.data();
	$scope.purchaseT='none';
	if($scope.purchaseD[0]!=null){ $scope.purchaseT=$scope.purchaseD[0]['@purchaseToken']}
	$scope.tservAdd = serviceAddRs.get({
	pToken:$scope.purchaseT,
	Guest:JSON.stringify($scope.getTransfer[1]),
	Availtoken:$scope.getTransfer[0]['@availToken'], 
	contractName:$scope.getTransfer[0].ContractList.Contract.Name, 
	contractCode:$scope.getTransfer[0].ContractList.Contract.IncomingOffice['@code'],
	ServiceType:'ServiceTransfer', 
	TransferType:'IN',
	DateFrom:$scope.getTransfer[0].DateFrom['@date'], 
	DateFTime:$scope.getTransfer[0].DateFrom['@time'], 
	currency:$scope.getTransfer[0].Currency['@code'], 
	code:$scope.getTransfer[0].TransferInfo.Code, 
	codeType:$scope.getTransfer[0].TransferInfo.Type['@code'],
	VType:$scope.getTransfer[0].TransferInfo.VehicleType['@code'],
	tourAdult:$scope.getTransfer[0].Paxes.AdultCount,
	tourChild:$scope.getTransfer[0].Paxes.ChildCount,
	destLoc:$scope.getTransfer[0].DestinationLocation.Code,
	DesType:$scope.getData[9].valueCountry,
	pickLoc:$scope.getTransfer[0].PickupLocation.Code,
	picType:$scope.getData[6].valueCountry,	
	tourBreakDown:JSON.stringify($scope.getData[28])
	},
	function(tservAdd) {	
	$scope.AddedtransferServRs=$scope.tservAdd.ServiceAddRS.Purchase;
	
	$scope.service=$scope.AddedtransferServRs.ServiceList.Service;
	if($scope.purchaseD[0]!=null){var pos=$scope.service.length; $scope.service=$scope.service[pos-1]}
	console.log($scope.service)
	purchaseData.setData($scope.AddedtransferServRs)	
	$scope.travelers=$scope.service.Paxes.GuestList;
	var i=0;
	firstad();
	function firstad(){
		if(Array.isArray($scope.travelers)){
			if($scope.travelers[i]['@type']!='CH'){	$scope.lead = { user: $scope.travelers[0].CustomerId+'|'+$scope.adultGuest[0][0]};}
			else{i++; firstad()}
		}
		else{
			if($scope.travelers['@type']!='CH'){	$scope.lead = { user: $scope.travelers.Customer.CustomerId+'|'+$scope.adultGuest[0]};}
			else{i++; firstad()}
		}
	}
	$scope.cancel_policies=$scope.AddedtransferServRs.ServiceList.Service.CancellationPolicies.CancellationPolicy
	$scope.modify_policies=$scope.AddedtransferServRs.ServiceList.Service.ModificationPolicyList.ModificationPolicy;
	$scope.max_wait_time_dom=$scope.AddedtransferServRs.ServiceList.Service.TransferInfo.TransferSpecificContent.MaximumWaitingTimeSupplierDomestic['@time'];
	$scope.max_wait_time_int=$scope.AddedtransferServRs.ServiceList.Service.TransferInfo.TransferSpecificContent.MaximumWaitingTimeSupplierInternational['@time'];
	$scope.reserve_rules=$scope.AddedtransferServRs.ServiceList.Service.TransferInfo.TransferSpecificContent.GenericTransferGuidelinesList.TransferBulletPoint;
	$scope.info=$scope.AddedtransferServRs.ServiceList.Service.TransferPickupInformation.Description;
	//$scope.totalAmount=$scope.AddedtransferServRs.ServiceList.CancellationPolicies.CancellationPolicy;
	//$scope.mainImageUrl = $scope.hotel_Detail.details[0].img_path;
  });
  
  $scope.next=function(next, lead){	
  	  $scope.getTransfer.push(lead.user);
	  $location.path(next);  
  }
  
}]);

transferSummary.controller('paymentDialog', function ($scope, $modal, $log) {	
	$scope.makePayment = function () {
		console.log("I was here");
		var modalInstance = $modal.open({
	  		templateUrl: 'makePayment.html',
	  		controller: 'ModalpaymentCtrl',
	  		size: 'lg',
	  		resolve: {
				transfer: function () {
		  			return $scope.transfer;
				}
	  		}
		});
	};
});

transferSummary.controller('ModalpaymentCtrl', ['$scope',  'tourpConfirmRs', 'purchaseData', '$modalInstance', function($scope,  tourpConfirmRs, purchaseData, $modalInstance) {
  $scope.temp_getTransfer=[];//stores temporary transfers before voing them...  
  $scope.selectedTour=[];//stores temporary transfers before voing them...  
  $scope.checktransfer=[];
  $scope.adult_sel=1; $scope.child_sel=2;
  
  $scope.ok = function() {
	$scope.getSelected= purchaseData.data();
	console.log($scope.getSelected);
	$scope.tpurchaseConf =  tourpConfirmRs.get({
	ptoken:$scope.getSelected[0]['@purchaseToken'], 
	SerSpui:$scope.getSelected[0].ServiceList.Service['@SPUI']},
	function(hpurchaseConf) {	$scope.AddedServRs=$scope.hpurchaseConf
	console.log($scope.AddedServRs);
	purchaseData.setData($scope.AddedServRs)
	})
    $modalInstance.close();
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);
// JavaScript Document
var tourCheckout =  angular.module('tourCheckout', ['ui.bootstrap']);
 tourCheckout.directive('onFinishRender', function ($timeout) {
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
tourCheckout.controller('tourCheckout', ['$scope', 'searchData', 'tourData', 'purchaseData', 'serviceAddRs', '$location', function($scope, searchData, tourData, purchaseData, serviceAddRs, $location){
	$scope.getData= searchData.data();
	$scope.getTour= tourData.data();
	$scope.adultGuest=$scope.getTour[0][2][0];
	$scope.purchaseD=purchaseData.data();
	$scope.purchaseT='none';
	if($scope.purchaseD[0]!=null){ $scope.purchaseT=$scope.purchaseD[0]['@purchaseToken']}
	console.log($scope.getTour);
	$scope.tservAdd = serviceAddRs.get({
	Availtoken:$scope.getData[26].availToken, 
	contractName:$scope.getTour[0][0].ContractList.Contract.Name, 
	contractCode:$scope.getTour[0][0].ContractList.Contract.IncomingOffice['@code'],
	pToken:$scope.purchaseT,
	ServiceType:'ServiceTicket', 
	tourBreakDown:JSON.stringify($scope.getData[28]),
	Guest:JSON.stringify($scope.getTour[0][2]),
	DateFrom:$scope.getTour[0][0].DateFrom['@date'], 
	DateTo:$scope.getTour[0][0].DateFrom['@date'], 
	currency:$scope.getTour[0][0].Currency['@code'], 
	ticketcode:$scope.getTour[0][0].TicketInfo.Code, 
	destcode:$scope.getTour[0][0].TicketInfo.Destination['@code'],
	availcode:$scope.getTour[0][0].AvailableModality['@code'],
	availName:$scope.getTour[0][0].AvailableModality.Name,
	availContactName:$scope.getTour[0][0].AvailableModality.Contract.Name, 
	availContactcode:$scope.getTour[0][0].AvailableModality.Contract.IncomingOffice['@code'], 
	tourAdult:$scope.getTour[0][0].Paxes.AdultCount,
	tourChild:$scope.getTour[0][0].Paxes.ChildCount},
	function(tservAdd) {	
	$scope.AddedtourServRs=$scope.tservAdd.ServiceAddRS.Purchase;
	$scope.service=$scope.AddedtourServRs.ServiceList.Service;
	if($scope.purchaseD[0]!=null){var pos=$scope.service.length; $scope.service=$scope.service[pos-1]}
	console.log($scope.service)
	purchaseData.setData($scope.AddedtourServRs)
	$scope.travelers=$scope.service.Paxes.GuestList.Customer;
	var i=0;
	firstad();
	function firstad(){
		if(Array.isArray($scope.travelers)){
			console.log('here');
			if($scope.travelers[i]['@type']!='CH'){	$scope.lead = { user: $scope.travelers[0].CustomerId+'|'+$scope.adultGuest[0][0]};}
			else{i++; firstad()}
		}
		else{
			
			if($scope.travelers['@type']!='CH'){ console.log('ok, here');	
				$scope.lead = { user: $scope.travelers.CustomerId+'|'+$scope.adultGuest[0][0]};}
			else{i++; firstad()}
		}
	}
	//$scope.mainImageUrl = $scope.hotel_Detail.details[0].img_path;
  });
  $scope.next=function(next, lead){	
  	  $scope.getTour[0].push(lead.user);
	  $location.path(next);  
  }
  
}]);
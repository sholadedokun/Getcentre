// JavaScript Document
var tourSummary =  angular.module('tourSummary', ['angular.filter', 'ui.bootstrap']);

 tourSummary.directive('onFinishRender', function ($timeout) {
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
tourSummary.controller('tourSummary', ['$scope', 'searchData', 'tourData', 'purchaseData', 'serviceAddRs', function($scope, searchData, tourData, purchaseData, serviceAddRs){
	$scope.getData= searchData.data();
	$scope.getTour= tourData.data();
	console.log($scope.getTour);
	$scope.tservAdd = serviceAddRs.get({
	Availtoken:$scope.getData[26].availToken, 
	contractName:$scope.getTour[0][0].ContractList.Contract.Name, 
	contractCode:$scope.getTour[0][0].ContractList.Contract.IncomingOffice['@code'],
	ServiceType:'ServiceTicket', 
	tourBreakDown:JSON.stringify($scope.getData[28]),
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
	console.log($scope.AddedtourServRs)
	purchaseData.setData($scope.AddedtourServRs)
	$scope.travelers=$scope.AddedtransferServRs.ServiceList.Service.Paxes.GuestList.Customer;
	//$scope.mainImageUrl = $scope.hotel_Detail.details[0].img_path;
  });
  
}]);


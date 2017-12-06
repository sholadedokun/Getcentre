// JavaScript Document
var voucher =  angular.module('voucher', ['angular.filter', 'ui.bootstrap']);

 voucher.directive('onFinishRender', function ($timeout) {
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
voucher.controller('voucher', ['$scope',  'tourData', 'hotelData',  'purchaseConfirmRs', 'purchaseData', 'sendmailRS', 'userData', '$http', 'flightBookRs', 'travelPackD', function($scope, tourData, hotelData,  purchaseConfirmRs, purchaseData, sendmailRS, userData, $http, flightBookRs,  travelPackD) {
	// $scope.pGate = PayGatewayRQRS.get($scope.search_c, function(pGate) {console.log($scope.pGate);});
	 $scope.tot_trip= checkCookie('travelPD');
	 $scope.lead_guest=checkCookie('lead_guest')
	 $scope.user=userData.data();
     $scope.voucher_det={};
     $scope.basketId= checkCookie('basketId');
	 setCookie('travelPD', '', 0)
     setCookie('basketId', '', 0)
      $scope.voucher_det.bookref=$scope.tot_trip.bookref
	 if($scope.user[0].status=='Register')	$scope.voucher_det.email=$scope.lead_guest.email;
	 else{ $scope.voucher_det.email=$scope.user[1].email}
     function getCookie(cname) {
         var name = cname + "=";
         var ca = document.cookie.split(';');
     	for(var i=0; i<ca.length; i++) {
             var c = ca[i].trim();
                if (c.indexOf(name)==0) {return c.substring(name.length,c.length);}
         }
     }
	function checkCookie(category) {
		var lSsearch=getCookie(category);
		if (lSsearch != "") {
			console.log(lSsearch)
			$scope.trip = JSON.parse(lSsearch);
			return $scope.trip;
		}
		else {}
	}
    function setCookie(cname, cvalue, exmins) {
        var d = new Date();
        d.setTime(d.getTime() + (exmins*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
    }
	for($i=0; $i<$scope.tot_trip.length; $i++){
		if($scope.tot_trip[$i].productType=='Flight'){

		}
		if($scope.tot_trip[$i].product=='HotelBed'){

		}
	}
}]);

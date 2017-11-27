// JavaScript Document
var TravelPack =  angular.module('TravelPack', ['angular.filter', 'ui.bootstrap']);
TravelPack.directive('onFinishRender', function ($timeout) {
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
TravelPack.controller('TravelPack', ['$scope', '$rootScope', 'searchDatas',  'travelPackD', 'flightCheckRs', 'serviceRemoveRs', 'currencyData', 'currencyConvertFilter', '$modal', function($scope, $rootScope, searchDatas, travelPackD, flightCheckRs, serviceRemoveRs, currencyData, currencyConvertFilter, $modal) {
	//flight cookie search and Update
    $rootScope.search=false;
    $scope.disabled=false;
	$scope.getData= searchDatas.data();
	$scope.travelPD=travelPackD.data();
	$scope.rate=currencyData.data();
    $scope.totalPrice=0.00;
    $scope.erro=false;
	if($scope.travelPD.length<1){
		$scope.cc=getCookie('travelPD')
		if($scope.cc!=''){
		    $scope.travelPD=JSON.parse($scope.cc);
		}
	}
    // else{
    //     setCookie("travelPD", $scope.travelPD, 30 );
    // }
    console.log($scope.travelPD);
	$scope.getCond=function(ofrcode){
        var code=ofrcode;
    	var modalInstance = $modal.open({
            templateUrl: 'template/flight_condition.html',
            controller: 'conditionModalInstanceCtrl',
            size: 'lg',
            windowClass: 'condition-modal-window',
            resolve: {
                offer: function () {
                    return code;
                },
                search_c:function () {return $scope.getData[0]}
            }
    	})
	}
	$scope.stripTravelPD=function(data){
		$scope.flightD=[];
		$scope.hotelD=[];
		$scope.tourD=[];
		$scope.transferD=[];
        $scope.insuranceD=[];
		$scope.data=[];
		$scope.totalPrice=0;
		console.log(data)
		 for($i=0; $i<data.length; $i++){

		 	if((data[$i].product=='Sabre')&&(data[$i].productType=='Flight')&&(data[$i].status!='booked')){


				// if(flightData.data()==''){
					$scope.data=data[$i];
                	$scope.fCheck = flightCheckRs.get({Adult:data[$i].Adult,Child:data[$i].Child,	Infant:data[$i].Infant, tourop:data[$i].tourOp, fOfferCode:data[$i].fOfferCode}, function(fCheck) {
						$scope.check=$scope.fCheck.response;
                        console.log($scope.check);
                        if($scope.check.ERROR){
                            $scope.error=true;
                            $scope.data.errorMessage='Flight couldn\'t be validated please click "Delete Booking" to Continue.'
                        }
                        else{
    						$scope.data.Price=$scope.check.pricetotal['@price'];
    						console.log($scope.fCheck.response);
    						$scope.data.lastTicketDate==$scope.check.forminfo.LastTicketDate.value;

    						console.log($scope.flightD)
                        }
                        // $scope.flightD.push($scope.data);
					})
				// }
				// else{
				// 	data[$i].idc=$i;
				// 	$scope.flightD.push(data[$i]);
				// }
                $scope.data.idc=$i;
                $scope.flightD.push(data[$i]);
                //assumming that all flight price are displayed in Naira.
                data[$i].convertedPrice=data[$i].Price;
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].convertedPrice);
                console.log($scope.totalPrice);
			}
			if(data[$i].product=='HotelBed' || data[$i].product=='Juniper'&&(data[$i].status!='booked')){
				for ($a=0; $a<4; $a++){
					console.log($scope.rate[1].currencyList[$a].curr)
					console.log($scope.rate[1].currencyList[$a].symbol)
					console.log(data[$i].currency)
					if(data[$i].currency==$scope.rate[1].currencyList[$a].curr){
						data[$i].currency_sy=$a;
                        data[$i].convertedPrice=data[$i].Price*$scope.rate[1].currencyList[$a].rate;
					}
				}
                data[$i].idc=$i;
				if(data[$i].productType=='Hotel'){$scope.hotelD.push(data[$i])}
				else if(data[$i].productType=='Tour'){$scope.tourD.push(data[$i])}
				else{$scope.transferD.push(data[$i])}
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].convertedPrice);
			}
            if(data[$i].product=='Aiico' &&(data[$i].status!='booked')){
				for ($a=0; $a<4; $a++){
					console.log($scope.rate[1].currencyList[$a].curr)
					console.log($scope.rate[1].currencyList[$a].symbol)
					console.log(data[$i].currency)
					if(data[$i].currency==$scope.rate[1].currencyList[$a].curr){
						data[$i].currency_sy=$a;
					}
				}
				$scope.insuranceD.push(data[$i])
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].Price);
			}

		}
	}
	$scope.remFlight=function(ind){
		var tr= $scope.flightD[ind].idc;
        $scope.totalPrice=$scope.totalPrice - $scope.flightD[ind].Price;
		$scope.flightD.splice(ind, 1);
		$scope.travelPD.splice(tr, 1);
        console.log($scope.travelPD);
        setCookie('travelPD', JSON.stringify($scope.travelPD), 30)
	}


	$scope.serRemove=function(spui, ptoken, index){
        var trace = $scope.hotelD[index].idc;
		$scope.sRemove=serviceRemoveRs.get({spui:spui, pToken:ptoken}, function(sRemove){alert('Removed');
            $scope.totalPrice=$scope.totalPrice - $scope.hotelD[ind].convertedPrice;
            $scope.hotelD.splice(index, 1)
            $scope.travelPD.splice(trace, 1);
            setCookie('travelPD', JSON.stringify($scope.travelPD), 30)
        })
    }
	function getCookie(cname) {
		var name = cname + "=";
		var ca = document.cookie.split(';');
		for(var i=0; i<ca.length; i++) {
			var c = ca[i].trim();
		   if (c.indexOf(name)==0) {
               return c.substring(name.length,c.length);
           }
		}
		return "";
	}
    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
    	document.cookie = cname + "=" + cvalue + "; " + expires;
    }
}]);

TravelPack.controller('TPfList', ['$scope', 'searchData', 'flightListRs', function($scope, searchData, flightListRs) {
  $scope.getData= searchData.data();
  $scope.offer="";
  $scope.fList = flightListRs.get({Adult:$scope.getData[0].Adult,Child:$scope.getData[0].Child,fSeniors:$scope.getData[0].fSenior,
							Infant:$scope.getData[0].Infant,fDepCode:$scope.getData[0].fDepCode,
							fDesCode:$scope.getData[0].fDesCode, fTravelDays:$scope.getData[0].fTravelDays, fDepDate:$scope.getData[0].fDepDate}, function(fList){
	$scope.list=$scope.fList.response.ofr;
	console.log($scope.list);
  });
}]);

TravelPack.controller('TPhList', ['$scope', 'searchData', 'hotelListRs', function($scope, searchData, hotelListRs) {
  $scope.getData= searchData.data();

  $scope.offer="";
  $scope.hList = hotelListRs.get({hAdult:$scope.getData[17].valueData, hChild:$scope.getData[18].valueData, hDesCode:$scope.getData[20].valueData,
									hcheckin:$scope.getData[22].valueData, hcheckout:$scope.getData[23].valueData, 'hRoomBreakDown':JSON.stringify($scope.getData[27])}, function(hList) {
    //$scope.mainImageUrl = phone.images[0];
	$scope.hotels_total=$scope.hList.HotelValuedAvailRS['@totalItems'];
	$scope.hotels=$scope.hList.HotelValuedAvailRS.ServiceHotel;
  });
}]);
TravelPack.controller('TPtList', ['$scope', 'searchData', 'tourData', 'tourListRs', function($scope, searchData, tourData, tourListRs) {
  $scope.getData= searchData.data();
  $scope.getTour=tourData.data();//stores all ticket booked
  $scope.tourlist=[];
  $scope.offer="";
  search_tour();

  function search_tour(){
  var tour={};
  $scope.tList = tourListRs.get({hDesCode:$scope.getData[20].valueData,	hTourin:$scope.getData[22].valueData, hTourout:$scope.getData[23].valueData, tourBreakDown:JSON.stringify($scope.getData[28])}, function(tList) {
	$scope.tours_p=$scope.tList.TicketAvailRS;
    $scope.tours_total=$scope.tours_p['@totalItems'];
	console.log($scope.tList)
	$scope.tours=$scope.tours_p.ServiceTicket

	$scope.getData[26].availToken=$scope.tours[0]['@availToken'];
  })
  }
}]);
TravelPack.controller('conditionModalInstanceCtrl', ['$scope', '$modalInstance', 'offer','search_c', 'flightCondRs', function ($scope,  $modalInstance, offer,search_c, flightCondRs) {
search_c.fOfferCode=offer;
$scope.load_note=true;
$scope.fnCond=flightCondRs.get({f_det:JSON.stringify(search_c)}, function(fnCond){
	$scope.load_note=false;
	$scope.condition=$scope.fnCond.response;
	$scope.conditionz=$scope.condition.segments1;
	$scope.paragraph=$scope.conditionz.paragraphs.paragraph[0];
});
$scope.change_flight=function(flight){
	$scope.conditionz=flight;
	$scope.paragraph=$scope.conditionz.paragraphs.paragraph[0];
}
$scope.change_rule=function(rule){
	$scope.paragraph=rule;
}
$scope.cancel = function () {  $modalInstance.dismiss('cancel');  };
}]);
TravelPack.controller('TPtrList', ['$scope', 'searchData', 'transferData', 'transferListRs', 'transferServiceAddRs',  function($scope, searchData, transferData, transferListRs, transferServiceAddRs) {
  $scope.getData= searchData.data();
  $scope.transferlist=transferData.data();//stores all transfer booked
  $scope.offer="";
  $scope.guest=[[],[]];
  $scope.selecV=false;
  $scope.adult=$scope.getData[28][0]
  $scope.children=$scope.getData[28][1].length;
  while( $scope.guest[0].push([]) < $scope.adult);
  if($scope.children>0){  while( $scope.guest[1].push([]) < $scope.children);}
  search_transfer();

  function search_transfer(){
  var transfer={};
  $scope.tList = transferListRs.get({hDesCode:$scope.getData[5].valueData, hDesType:$scope.getData[6].valueCountry, hReturnCode:$scope.getData[8].valueData, hReturnType:$scope.getData[9].valueCountry, hReturnOption:$scope.getData[9].valueName,
  htransferin:$scope.getData[22].valueData,
  htransferout:$scope.getData[23].valueData,
  ttransferin:$scope.getData[22].valueName,
  ttransferout:$scope.getData[23].valueName,
  'transferBreakDown':JSON.stringify($scope.getData[28])}, function(tList) {
	$scope.transfers_p=$scope.tList.TransferValuedAvailRS;
    $scope.transfers_total=parseInt($scope.transfers_p['@totalItems']);
	console.log($scope.tList)
	$scope.transfers=$scope.transfers_p.ServiceTransfer;
	if($scope.transfers_total!=0){	$scope.getData[26].availToken=$scope.transfers[0]['@availToken'];}

  })
  }

}]);

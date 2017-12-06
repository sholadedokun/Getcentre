
var getcentre = angular.module('getcentre', ['ngRoute','ngResource','ngSanitize','ngAnimate','getAnimations','ui','angular.filter', 'ui.bootstrap','TravelPack', 'flightList','hotelList','hotelDetails','AddGuest','voucher']);
getcentre.run(['currencyData','$rootScope','apiProxy', 'userData', '$http', 'retrieveAirports', function(currencyData, $rootScope, apiProxy, userData, $http, retrieveAirports){
    $rootScope.user=userData.data();
    retrieveAirports.getAllAirports()
    var checkCookie=getCookie("getCentreUser");
    if (checkCookie!=""){
	     $rootScope.user=JSON.parse(checkCookie);
       console.log( $rootScope.user);
       userData.saveData($rootScope.user);
    }
    function getCookie(cname){
	     var name = cname + "=";
	     var ca = document.cookie.split(';');
  		 for(var i=0; i<ca.length; i++) {
	       var c = ca[i].trim();
	       if (c.indexOf(name)==0){
				       return c.substring(name.length,c.length);
			   }
  	  }
  	    return "";
  	}

    $rootScope.rate=currencyData.data();
    $rootScope.convF=$rootScope.rate[0].baseCurrency.currFrom;
    $rootScope.convS=$rootScope.rate[0].baseCurrency.symbol;
    $rootScope.convL=$rootScope.rate[1].currencyList;
    $http({method:'GET',
       url:'server/getConversionRate.php?fetcher=true'
     }).then(function successCallback(response) {
       console.log(response)
       for(item in response.data){
         for(var a=0; a<4; a++){
           if(item===$rootScope.convL[a].curr){
             $rootScope.convL[a].rate=response.data[item]
           }
         }
       }
       // for ($a=0; $a<4; $a++){
       //     if($rootScope.rate[0].baseCurrency.currTo !=$rootScope.convL[$a].curr){
       //         $rootScope.currentcur= apiProxy.query(
       //             {url:'http://www.getcentre.com/server/getConversionRate.php?fetcher=true'},
       //             function(currenrcur){
       //                 console.log(currenrcur);
       //                 $rootScope.conver_rate=currenrcur[0].rate;
       //                 $rootScope.convL[currenrcur[0].index].rate=$rootScope.conver_rate
       //             }
       //         )
       //     }
       // }
     })


  }])


var getcentre = angular.module('getcentre', ['ngRoute','ngResource','ngSanitize','ngAnimate','getAnimations','ui','angular.filter', 'ui.bootstrap','TravelPack', 'flightList','hotelList','hotelDetails','AddGuest','voucher']);
// var getcentre = angular.module('getcentre', ['ngRoute','ngResource','ngAnimate','getAnimations','ui','TravelPack', 'flightList','AddGuest']);
getcentre.run(['currencyData','$rootScope','apiProxy', 'userData', function(currencyData, $rootScope, apiProxy, userData){
    $rootScope.user=userData.data();
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
    for ($a=0; $a<4; $a++){
        if($rootScope.rate[0].baseCurrency.currTo !=$rootScope.convL[$a].curr){
            $rootScope.currentcur= apiProxy.query(
                {url:'http://www.google.com/finance/converter?a=1&from='+$rootScope.convL[$a].curr+'&to='+$rootScope.rate[0].baseCurrency.currTo, index:$a},
                function(currenrcur){
                    console.log(currenrcur);
                    $rootScope.conver_rate=currenrcur[0].rate;
                    $rootScope.convL[currenrcur[0].index].rate=$rootScope.conver_rate
                }
            )
        }
    }

  }])

var appServices = angular.module('appServices', ['ngResource']);
appServices.filter('custNo', function () {
    return function (input) {
        var n = input;
        if(n < 10){ if(n < 0){n=0; n='0' + n;}  else{ n='0' + n}}

        return n;
    }
});
appServices.filter('time_am_pm', function () {
    return function (input) {
        var n =moment(input).format('hh:mm a');
        return n;
    }
});

appServices.filter('hdate', function () {
    return function (input) {
        console.log(input);
        input= input.substr(0, 4) + "." + input.substr(4,2)+'.'+input.substr(6);
        console.log(input);
        var n =moment(input, "YY.MM.DD").format('ddd. DD MMM ');
        return n;
    }
});
appServices.filter('htime', function () {
    return function (input) {
        input=input.substring(0, 2) + ":" + input.substring(2);
        return input+"pm";
    }
});
appServices.filter('fltime', function () {
    return function (input) {
        input=input.split(':'); input=input[0] + "hrs " + input[1]+'mins';
        return input;
    }
});
appServices.filter('hrtomin', function () {
    return function (minu) {
        var hours = Math.floor( minu / 60);
        var minutes = minu% 60;
        return(hours+'hrs '+minutes+'mins');
    }
})

appServices.filter('shortdate', function () {
    return function (date) {
        var n=moment(date).format('ddd. DD MMM YYYY');
        return(n)
    }
})
appServices.filter('shortdateF', function () {
    return function (date) {
        var n=moment(date, "DD.MM.YY" ).format('DD MMM YYYY');
        return(n)
    }
})
appServices.filter('lastlegDes', function () {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $des_desc=legobj[$arr_leg]['@desDesc'];//getting the destination date of the last leg
        $des_ext='<label>'+$des_desc+'</label> '+legobj[$arr_leg]['@desDescExt'];//format the date to a better readable format
        return($des_ext)
    }
})
appServices.filter('lastlegDate', function () {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $arr_date=legobj[$arr_leg]['@desDate'];//getting the destination date of the last leg
        $arr_date=moment($arr_date).format('ddd. DD MMM YYYY');//format the date to a better readable format
        return($arr_date)
    }
})
appServices.filter('lastlegTime', function () {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $arr_time=legobj[$arr_leg]['@desTime'];//getting the destination date of the last leg
        return($arr_time)
    }
})
appServices.filter('stopover', function () {
    return function (legobj) {
        $total_channel=-1;
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        return($total_channel)
    }
})
appServices.filter('fprice', function () {
    return function (price) {
        $tot_price=0;
        for (property in price){//loop through each person
            cprice=price[property]
            //check if this flight has been markup_down by checking the the margin object
            if(cprice['@margin']==0 || typeof cprice['@margin']=='undefined'){
                $tot_price=$tot_price+parseInt(cprice['@price']);
            }
            else{
                $tot_price=$tot_price+parseInt(cprice['@margin']);
            }
        }
        return $tot_price;
    }
})
appServices.filter('currencyConvert', function (currencyData) {
    return function (price) {
        var rate=currencyData.data();
        var convF=rate[0].baseCurrency.currFrom;
        var convL=rate[1].currencyList;
        var currR=1;
        for ($a=0; $a<4; $a++){
            if(convL[$a].curr==convF){
                currR=convL[$a].rate;
                return currR*price
            }
        }
    }
})
appServices.filter('lower_price', function (searchData) {
    return function (price) {
        htroom=searchData.data();htroom=htroom[1].hTotalroom
        try{room_count= price[0].HotelOccupancy.RoomCount; return price[0].HotelRoom.Price.Amount}//return (room_count)*(price[0].HotelRoom.Price.Amount);
        catch(e){room_count= price.HotelOccupancy.RoomCount; return price.HotelRoom.Price.Amount }// return (room_count)*(price.HotelRoom.Price.Amount)}
    }
})
appServices.filter('first_b', function () {
    return function (board) {
        try{return board[0].HotelRoom.Board.$;}
        catch(e){return board.HotelRoom.Board.$;}
    }
})
appServices.filter('first_r', function () {
    return function (rtype) {
        try{return rtype[0].HotelRoom.RoomType.$;}
        catch(e){return rtype.HotelRoom.RoomType.$;}
    }
})
appServices.filter('first_c', function () {
    return function (category) {
        try{return category[0].Name;}
        catch(e){return category.Name;}
    }
})
appServices.filter('isArray', function() {
  return function (input) {
    return angular.isArray(input);
  };
});
appServices.filter('peradult', function () {
    return function (price) {
        if(Array.isArray(price)){
            if(Array.isArray(price[0].PriceList.Price)){return price[0].PriceList.Price[0].Amount;}
            else{return  price[0].PriceList.Price.Amount}
        }
        else{
            if(Array.isArray(price.PriceList.Price)){
                return price.PriceList.Price[0].Amount;
            }
            else{return price.PriceList.Price.Amount}
        }

    }
})
appServices.filter('first_d',  function (hdateFilter) {
    return function (dates) {
        if(Array.isArray(dates)){
            if(Array.isArray(dates[0].OperationDateList.OperationDate)){return hdateFilter(dates[0].OperationDateList.OperationDate[0]['@date']);}
            else{return  hdateFilter(dates[0].OperationDateList.OperationDate['@date'])}
        }
        else{
            if(Array.isArray(dates.OperationDateList.OperationDate)){
                return hdateFilter(dates.OperationDateList.OperationDate[0]['@date']);
            }
            else{return hdateFilter(dates.OperationDateList.OperationDate['@date'])}
        }
    }
})
appServices.filter('hotel_room', function () {
    return function (room) {
        room_opt=room.length
        if(room_opt>1){return room_opt}
        else{ return 1;}
    }
})
appServices.filter('imglarge', function () {
    return function (imgs) {
        try{newimg=imgs.replace("/small", "");}
        catch(e){newimg=imgs}
        return newimg
    }
})
appServices.filter('hotel_r', function () {
    return function (room) {
        room_opt=room.length
        if(room_opt>1){return 'Room Options'}
        else{ return  'Room Option';}
    }
})
appServices.filter('currency_ex', function (numberFilter) {
    return function (base, exchange, amount) {
        $scope.curr= amount * exchange;
        return $scope.curr;
    }
})
appServices.filter('pernight', function () {
    return function (price, tnights) {
        if(price instanceof Array){
            if(typeof price[0].HotelRoom.Price.PriceList =='undefined'){return parseFloat(parseFloat(price[0].HotelRoom.Price.Amount)/tnights).toFixed(2); }
            else if(price[0].HotelRoom.Price.PriceList.Price instanceof Array){return price[0].HotelRoom.Price.PriceList.Price[0].Amount;}
            else if(price[0].HotelRoom.Price.PriceList.Price.Amount)return price[0].HotelRoom.Price.PriceList.Price.Amount;

        }
        else {
            if(typeof price.HotelRoom.Price.PriceList !='undefined'){
                if( price.HotelRoom.Price.PriceList.Price instanceof Array){return price.HotelRoom.Price.PriceList.Price[0].Amount;}
                else {return price.HotelRoom.Price.PriceList.Price.Amount;}
            }
            else{return price.HotelRoom.Price.Amount}
        }
    }
})
appServices.filter('hotel_contract_comment', function () {
    return function (comment) {
        if(Array.isArray(comment)){
            policy=''
            for($i=0; $i<comment.length; $i++){
                policy= '<div class="col-md-18"><b> Please Take Note : </b>'+comment[$i].Comment['$']+'</div>'+policy;
            }
            return policy
        }
        else{ return  '<div class="col-md-18"><b> Please Take Note : </b>'+comment.Comment['$']+'</div>';}
    }
})
appServices.filter('hotel_room_policy', function (currencyData, htimeFilter, hdateFilter, currencyConvertFilter, numberFilter) {
    return function (cancelation) {
        if(Array.isArray(cancelation.CancellationPolicy)){
            var curr=currencyData.data();
            curr=curr[0].baseCurrency.symbol;
            policy=''
            for($i=0; $i<cancelation.CancellationPolicy.length; $i++){
                policy= '<div class="col-md-18">Cancellation after '+htimeFilter(cancelation.CancellationPolicy[$i]['@time'])+' '+hdateFilter(cancelation.CancellationPolicy[$i]['@dateFrom'])+' will Cost <span class="curr_book ng-binding" >'+curr+'</span> '+currencyConvertFilter(cancelation.CancellationPolicy[$i]['@amount']).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '1,')+"</div>" + policy;
            }
            return policy;
        }
        else{ return  '<div> Cancellation after '+htimeFilter(cancelation.CancellationPolicy['@time'])+' '+hdateFilter(cancelation.CancellationPolicy['@dateFrom'])+' will Cost <span class="curr_book ng-binding" ng-bind-html="convS"></span>'+currencyConvertFilter(cancelation.CancellationPolicy['@amount']).toFixed(2)+'</div>';}
    }
})
appServices.filter('tour_cancel_policy', function (htimeFilter, hdateFilter, currencyConvertFilter) {
    return function (cancelation) {
        if(Array.isArray(cancelation)){
            policy=''
            for($i=0; $i<cancelation.length; $i++){

                policy= '<div class="col-md-18">Cancellation from '+hdateFilter(cancelation[$i].Price.DateTimeFrom['@date'])+' to '+hdateFilter(cancelation[$i].Price.DateTimeTo['@date'])+' will Cost '+currencyConvertFilter(cancelation[$i].Price.Amount)+"</div>" + policy;
            }
            return policy;
        }
        else{ return  '<div class="col-md-18">Cancellation from '+hdateFilter(cancelation.Price.DateTimeFrom['@date'])+' to '+hdateFilter(cancelation.Price.DateTimeTo['@date'])+' will Cost '+cancelation.Price.Amount+"</div>";}
    }
})
appServices.service('travelPackD',function(){
    var savedData=[]
    return{
         data:function() {
           return savedData;
         },
         setData:function(data) {
            savedData.push(data);
         },
         deleteData:function(){
            savedData=[];
         }
    }
})
appServices.service('Add_guest',function(){
    var savedData=[]
    return{
         data:function() {
           return savedData;
         },
         setData:function(data) {
            savedData.push(data);
         },
         deleteData:function(){
            savedData=[];
         }
    }
})
appServices.service('purchaseData', function(){
    var purchaseData =  []
    return{
         data:function() {
           return purchaseData;
         },
         setData:function(data) {
            purchaseData.push(data);
         }
    }
})


appServices.service('searchData', function(){
    var savedData =  [
                     {fAdult:1, fChild:0, fSenior:0, fInfant:0, fDepDate:0, fDesDate:0, fClass:'all', fDepAirpCode:'LOS', fDepAirpName:'Murtala Mohammed Airport', fDepTown:'Lagos', fDepCountry:'Nigeria', fDesAirpCode:'LHR', fDesAirpName:'London Heathrow Airport', fDesTown:'London', fDesCountry:'United Kingdom', fTravelDays:5, fDepDateLong:'', fDesDateLong:'', fDepstop:0, fDesstop:0, fOfferCode:'', lastOfferDate:'', limit_count:11, fsearch:'', fPassBreak:[], flightType:'MF',
                     otherRoutes:[
                         {dep:'LOS', date:'20161211', des:'LHR'},
                         {dep:'LHR', date:'20161216', des:'DXB'}
                     ] },//0
                     {hAdult:1, hChild:0, hcheckin:0, hcheckout:0, hcheckinL:'', hcheckoutL:'', hdesdesc:'London, United Kingdom', hdescode:'LON', hTotalroom:1, htotalnight:1, hRoomBreak:[], hcode:0, hname:'', hsearch:'No'},//1
                     {Adult:1, Child:0, Senior:0, Infant:0, hdescode:'LON', hTotalroom:1, hRoomBreak:[] },//2
                     {valueName:'fInfant', valueData:0},//3
                     {TpickCode:'LOS' , TpickTairName:'Murtala Mohammed Airport', TpickTcityName:'Lagos', TpickType:'', TpickTime:'', tpickHotelName:'', tpickHotelCode:'', TdropCode:'LHR', TdropTairName:'London Heathrow Airport', TdropTcityName:'London', TdropType:'', TdropDate:'', tdropHotelName:'', tdropHotelCode:'', transfer_return:'Y' },//4
                     {valueName:'fDepAirpCode', valueData:'LOS'},//5
                     {valueName:'fDepAirpName', valueAirport:'Murtala Mohammed Airport', valueTown:'Lagos', valueCountry:'Nigeria'},//6
                     {valueName:'fDepDate', valueData:'20150130'},//7
                     {valueName:'fDesAirpCode', valueData:'LHR'},//8
                     {valueName:'fDesAirpName', valueAirport:'London Heathrow Airport',  valueTown:'London', valueCountry:'United Kingdom'},//9
                     {valueName:'fReturnDate', valueData:'20150128'},//10
                     {valueName:'fTravelDays', valueData:'7'},//11
                     {valueName:'fDepDateLong', valueData:''},//12
                     {valueName:'fDesDateLong', valueData:''},//13
                     {valueName:'fDepstop', valueData:''},//14
                     {valueName:'fDesstop', valueData:''},//15
                     {valueName:'fOfferCOde', valueData:''},//16
                     {valueName:'hAdult', valueData:1},//17
                     {valueName:'hChild', valueData:0},//18
                     {valueName:'hTotalroom', valueData:0},//19
                     {valueName:'hdescode', valueData:'LON'},//20
                     {valueName:'hdesdesc', valueData:'London, United Kingdom'},//21
                     {valueName:'hcheckin', valueData:0, valueDataLong:0},//22
                     {valueName:'hcheckout', valueData:0, valueDataLong:0},//23
                     {valueName:'htotalnight', valueData:1},//24
                     {valueName:'hrate', valueData:0},//25
                     {availToken:0, hotelCode:0, imgUrl:''},//26
                     {},//27 always be for hotels
                     {}//28 always be for tours
                    ]
    return{
         data:function() {
           return savedData;
         },
         setData:function(dataName, dataValue) {
            savedData.push({valueName:dataName, valueData:dataValue});
         }
    }
})
appServices.service('searchDatas', function(){
    var savedData = {}
    return{
        data:function() {
            return savedData;
        }
    }
})
appServices.service('flightData', function(){
    var flightData =  []
    return{
         data:function() {
           return flightData;
         },
         setData:function(data) {
             while(flightData.length > 0) {
                flightData.pop();
            }
            flightData.push(data);
         },
         addData:function(data){
            flightData.push(data);
         }
    }
})
appServices.service('hotelData', function(){
    var hotelData =  []
    return{
         data:function() {
           return hotelData;
         },
         setData:function(data) {
             while(hotelData.length > 0) {
                hotelData.pop();
            }
            hotelData.push(data);
         },
         addData:function(data){
            hotelData.push(data);
         }
    }
})
appServices.service('tourData', function(){
    var tourData =  []
    return{
         data:function() {
         return tourData;
         },
         setData:function(data) {
            tourData.push(data);
         },
         addData:function(data, index){
            tourData[index].push(data);
         }
    }
})
appServices.service('currSearch', function(){
    var curr_Search =  {service:'Flights', url:'server/flight_autocomplete.php', dep:'', des:''}
    return{
         getSearch:function() {
           return curr_Search;
         },
         setSearch:function(ns,nu) {
            curr_Search.service =  ns;
            curr_Search.url= nu;

         },
         setDep:function(dep){curr_Search.dep=dep},
         setDes:function(des){curr_Search.des=des}
    }
})
appServices.service('transferData', function(){
    var transferData =  [[],[]]
    return{
         data:function() {
           return transferData;
         },
         settransfer:function(data) {
            transferData[0]=data;
         },
         settraveler:function(data, index){
            transferData[1]=data;
         }
    }
})
appServices.service('currencyData', function(){
    var currencyData =
    [
        {baseCurrency:
            {currTo:'NGN', currFrom:'', symbol:'&#8358;'}
        }
        ,
        {currencyList:
            [{curr:'NGN', rate:1, symbol:'&#8358;'},
             {curr:'USD', rate:'', symbol:'$'},
             {curr:'GBP', rate:'', symbol:'&pound;'},
             {curr:'EUR', rate:'', symbol:'&euro;'}
            ]
        }

    ]
    return{
         data:function() {
           return currencyData;
         },
         settransfer:function(data) {
            currencyData[0]=data;
         },
         settraveler:function(data, index){
            currencyData[1]=data;
         }
    }
})
appServices.service('userData', function(){
    var userData =  [{
            status:'Register'
        }]
    return{
         data:function() {
           return userData;
         },
         setData:function(data) {
            userData.splice(1, 1, data);
         },
         addData:function(data, index){
            userData[index].push(data);
         }
    }
})

appServices.factory('flightListRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('flightListNextRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailRQ_next.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('flightCondRs', ['$resource',
  function($resource){
    return $resource('server/flightConditionRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
appServices.factory('flightCheckRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailCheckRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
appServices.factory('hotelListRs', ['$resource',
  function($resource){
    return $resource('server/hotelAvail_httpRQ.php', {}, {
      query: {method:'GET',
				params:{

				},
				isArray:true
			}
    });
  }]);
  appServices.factory('hotelListRs', ['$resource',
  function($resource){
    return $resource('server/hotelAvail_httpRQ.php', {}, {
      query: {method:'GET',
				params:{

				},
				isArray:true
			}
    });
  }]);
    appServices.factory('hotelDetailsRs', ['$resource',
  function($resource){
    return $resource('server/hotelDetailsRQ.php', {}, {
      query: {method:'GET',
				params:{

				},
				isArray:true
			}
    });
  }]);

 appServices.factory('hotelShortDetailsRs', ['$resource',
  function($resource){
    return $resource('server/hshotdet.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelFprox', ['$resource',
  function($resource){
    return $resource('server/hotelFilterProxRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelChain', ['$resource',
  function($resource){
    return $resource('server/hotelFilterChainRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

   appServices.factory('blogImageRs', ['$resource',
  function($resource){
    return $resource('server/bimage.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('toursRs', ['$resource',
  function($resource){
    return $resource('server/tour_package.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('tourListRs', ['$resource',
  function($resource){
    return $resource('server/tourAvail_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('transferListRs', ['$resource',
  function($resource){
    return $resource('server/transferAvail_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('tourValuationRs', ['$resource',
  function($resource){
    return $resource('server/tourValuation_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('tourCheckoutRs', ['$resource',
  function($resource){
    return $resource('server/tourAvail_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.factory('serviceAddRs', ['$resource',
  function($resource){
    return $resource('server/serviceAdd_httpRQ.php', {}, {
      query: {method:'POST',
				params:{
				},
				isArray:true
			}
    });
  }]);
    appServices.factory('serviceRemoveRs', ['$resource',
  function($resource){
    return $resource('server/serviceRemove_httpRQ.php', {}, {
      query: {method:'POST',
				params:{
				},
				isArray:true
			}
    });
  }]);

      appServices.factory('purchaseRemoveRs', ['$resource',
  function($resource){
    return $resource('server/purchaseRemove_httpRQ.php', {}, {
      query: {method:'POST',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.factory('tourServiceAddRs', ['$resource',
  function($resource){
    return $resource('server/tourServiceAdd_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('transferServiceAddRs', ['$resource',
  function($resource){
    return $resource('server/transferServiceAdd_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('tourPaymentRs', ['$resource',
  function($resource){
    return $resource('server/tourPayment_httpRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('registerUser', ['$resource',
  function($resource){
    return $resource('server/register_user.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('flightBookRs', ['$resource',
  function($resource){
    return $resource('server/flight_book.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('purchaseConfirmRs', ['$resource',
  function($resource){
    return $resource('server/PurchaseConfirmRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  appServices.factory('tourpConfirmRs', ['$resource',
  function($resource){
    return $resource('server/tourPurchaseConfirmRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.service('sendmailRS', ['$http','$q',  function($http, $q){
    return {
		sendmail:
			function(userE, leadGuest, searchD){
				return $q(
					function(resolve, reject) {
						hdata={userE:userE, leadGuest:leadGuest, searchD:searchD};
						$http({method:'Post', url:'server/booking_email.php', data:hdata})
						.success(
							function(responseData, status, headers, config) {
								resolve(responseData[0]);
							},
							function(err) {
								reject('Can\'t send mail');
							}
						);
					}
				)
			}
		}
  }]);
  appServices.service('serviceAdd', ['$http','$q',  function($http, $q){
    return {
		addService:
			function(hdata){
				return $q(
					function(resolve, reject) {
						$http({method:'Post', url:'server/serviceAdd_httpRQ.php', data:hdata})
						.success(
							function(responseData, status, headers, config) {
								resolve(responseData);
							},
							function(err) {
								reject('Can\'t Add services');
							}
						);
					}
				)
			}
		}
  }]);
  appServices.service('getcurrency', ['$http','$q', 'currencyData','apiProxy', function($http, $q, currencyData,apiProxy){
    return {
      getccurrent:
          function(hdata){
              return $q(
                  function(resolve, reject) {
                    $scope.rate=currencyData.data();
            		$scope.convF=$scope.rate[0].baseCurrency.currFrom;
            		$scope.convS=$scope.rate[0].baseCurrency.symbol;
            		$scope.convL=$scope.rate[1].currencyList;
            		for ($a=0; $a<4; $a++){
        				if($scope.rate[0].baseCurrency.currTo !=$scope.convL[$a].curr)
        				$scope.currentcur= apiProxy.query({url:'http://www.google.com/finance/converter?a=1&from='+$scope.convL[$a].curr+'&to='+$scope.rate[0].baseCurrency.currTo, index:$a}, function(currenrcur){
        		        $scope.conver_rate=currenrcur[0].rate;	$scope.convL[currenrcur[0].index].rate=$scope.conver_rate
        				})
            		}
                  }
              )
          }
      }
  }]);

  appServices.factory('sendMailCRs', ['$resource',
  function($resource){
    return $resource('server/sendMC.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
    appServices.factory('sendMailVRs', ['$resource',
  function($resource){
    return $resource('server/sendMV.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.factory('sendmailFlight', ['$resource',
  function($resource){
    return $resource('server/booking_email_flight.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.factory('PayGatewayRQRS', ['$resource',
  function($resource){
    return $resource('server/PayGatewayRQRS.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  appServices.factory('PayMentGatewayRQRS', ['$resource',
  function($resource){
    return $resource('server/PayMentGatewayRQRS.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
    appServices.factory('blogRS', ['$resource',
  function($resource){
    return $resource('server/BlogRQRS.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
      appServices.factory('ltours', ['$resource',
  function($resource){
    return $resource('server/ltours.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
        appServices.factory('lptours', ['$resource',
  function($resource){
    return $resource('server/gettourpack.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
    appServices.factory('apiProxy', ['$resource',
  function($resource){
    return $resource('server/api_proxy.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

   appServices.factory('hotelE', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityEntertainmentRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelF', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityFactRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelG', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityGreenProRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelH', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityHealthRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelHo', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityHotelRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelM', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityMainRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelMe', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityMealOptRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelN', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityNearestRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelP', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityPaymentReceivedRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelRE', ['$resource',
	  function($resource){
		return $resource('server/hotelFacilityRoomEquipRQ.php', {}, {
		  query: {method:'GET',
					params:{
					},
					isArray:true
				}
		});
	  }]);
   appServices.factory('hotelPr', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityProxRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelR', ['$resource',
  function($resource){
    return $resource('server/hotelFacilityRoomRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelS', ['$resource',
  function($resource){
    return $resource('server/hotelFacilitySportOptRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
     appServices.factory('hotelIs', ['$resource',
  function($resource){
    return $resource('server/hotelIssuesRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
   appServices.factory('hotelTerm', ['$resource',
  function($resource){
    return $resource('server/hotelTerminalRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
     appServices.factory('hotelContact', ['$resource',
  function($resource){
    return $resource('server/hotelContactstRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
     appServices.factory('updateB', ['$resource',
  function($resource){
    return $resource('server/updateTrans.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
     appServices.factory('loginUserRs', ['$resource',
  function($resource){
    return $resource('server/login.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

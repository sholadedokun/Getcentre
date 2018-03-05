// JavaScript Document
var tourList =  angular.module('tourList', []);
tourList.factory('tour_cat', function($rootScope) {
    var tour_allot = {data:[], raw:[]};

    tour_allot.prepForBroadcast = function(msg) {
        this.data = msg;
        this.broadcastItem();
    };

    tour_allot.broadcastItem = function() {
        $rootScope.$broadcast('tourBroadcast');
    };
    return tour_allot;
});

tourList.controller('tourList', ['$scope', 'searchDatas', 'tourData', 'tourListRs', 'purchaseData', 'tourValuationRs', 'travelPackD', 'serviceAdd', '$location', 'currencyData', function($scope, searchDatas, tourData, tourListRs, purchaseData, tourValuationRs, travelPackD, serviceAdd, $location, currencyData) {

  $scope.getData= searchDatas.data();
  $scope.getTour=tourData.data();//stores all ticket booked
  $scope.tourlist=[];
  $scope.offer="";
  search_tour();
  $scope.currData= currencyData.data();
  function search_tour(){
	  var tour={};
	  $scope.load_note=true;
	  $scope.getData= searchDatas.data();
	  $scope.travelPD= travelPackD.data();
	  $scope.offer="";
	  //$scope.$watch('room_allo', function(value){$scope.room_allo=value; console.log($scope.room_allo)});
	  //$scope.$watch('roomBreak', function(value){$scope.roomBreak=value; console.log($scope.roomBreak)});
	  if(!$scope.getData.data){
		$scope.search_c=checkCookie('Last_Search');
		$scope.travelPD=checkCookie('travelPD');
		}
		else{
			$scope.search_c=$scope.getData.data;
			console.log($scope.search_c)
			setCookie("Last_Search", $scope.search_c, 30);
			setCookie("travelPD", $scope.travelPD, 30);
		}
		//$scope.search_c={};
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');

			for(var i=0; i<ca.length; i++) {
				var c = ca[i].trim();
				   if (c.indexOf(name)==0) {return c.substring(name.length,c.length);}
			}
			return "";
		}
		function checkCookie(cattype) {
			var lSsearch=getCookie(cattype);
			if (lSsearch != "") {
				return JSON.parse(lSsearch);
			}
			else {}
		}
	  $scope.tList = tourListRs.get({hDesCode:$scope.search_c.moduleCurrType[0].value.code,	hTourin:$scope.search_c.moduleCurrType[1].value.short, hTourout:$scope.search_c.moduleCurrType[2].value.short
	  ,'occupancy':JSON.stringify($scope.search_c.moduleCurrType['occupancy'])}, function(tList) {
		$scope.load_note=false;
		$scope.tours_p=$scope.tList.TicketAvailRS;
		$scope.tours_total=$scope.tours_p['@totalItems'];
		console.log($scope.tList)
		$scope.tours=$scope.tours_p.ServiceTicket
		$scope.currData[0].baseCurrency.currFrom=$scope.tours[0].Currency['@code'];
		try{$scope.lowest_price=$scope.tours[0].AvailableModality[0].PriceList.Price[0].Amount;}
		catch(e){$scope.lowest_price= parseFloat($scope.tours[0].AvailableModality.PriceList.Price[0].Amount )}
		var curr_price=0;
		console.log($scope.lowest_price)
		for (property in $scope.tours){//loop through the room_avail to get all room occupancies for this room
		  if($scope.tours.hasOwnProperty(property)){
			  if($scope.tours instanceof Array){var properti=$scope.tours[property];}
			  else{var properti=$scope.tours;}
			  var temp=$scope.lowest_price;
			  var price=properti.AvailableModality;
			 // $scope.hClist.push(properti.HotelInfo.Code)
			 // var pointOI={'pOI':[]};
			 // properti.filter=[[],[],[]];
			  if(price instanceof Array){
			  	if(price[0].PriceList instanceof Array){
					if(price[0].PriceList[0].Price instanceof Array)  	curr_price= parseFloat(price[0].PriceList[0].Price[0].Amount);
					else curr_price= price[0].PriceList[0].Price.Amount
				}
				else{
					if(price[0].PriceList.Price instanceof Array)  	curr_price= parseFloat(price[0].PriceList.Price[0].Amount);
					else curr_price= price[0].PriceList.Price.Amount
				}

			  }
			  else{
					if(price.PriceList instanceof Array){
					if(price.PriceList[0].Price instanceof Array)  	curr_price= parseFloat(price.PriceList[0].Price[0].Amount);
					else curr_price= price.PriceList[0].Price.Amount
				}
				else{
					if(price.PriceList.Price instanceof Array)  	curr_price= parseFloat(price.PriceList.Price[0].Amount);
					else curr_price= price.PriceList.Price.Amount
				}
			  }
			  if(curr_price<$scope.lowest_price){console.log(curr_price);$scope.lowest_price=curr_price}
			}
		}
	  })
  }
  function ifarray(el){ 	if(el[0]){ return el[0]}else{return el}  }
  function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
	}

  $scope.settour_details=function(code_token, index_num){
	  var json_str =  JSON.parse( $('#new_list').val() );
	  $scope.hot=json_str[index_num];
	  console.log($scope.hot);
	  tourData.setData($scope.hot);

	  $location.path('/tour/tour_detail');
	}
  $scope.book_tour = function (tour, selectedtour, date) {
	$scope.load_note=true;
	$code=tour.TicketInfo.Code;
	$avail=tour['@availToken'];
	//(selectedtour!='0'):$availModal=selectedtour['@code'];?$availModal=selectedtour;
	if(selectedtour=='0'){
		ava=ifarray(tour.AvailableModality)
		$availModal=ava['@code'];
		art= ifarray(ava.OperationDateList.OperationDate);
		date= art['@date']
	}
	else{$availModal=selectedtour['@code']}

	//if($availModal==null){ $availModal=tour.AvailableModality[0]['@code'];}
	$scope.tvList = tourValuationRs.get({tTicketCode:$code, tAvailToken: $avail, tAvailModal: $availModal, hDesCode:$scope.search_c.hdescode,	hTourin:date, hTourout:date,'occupancy':JSON.stringify($scope.search_c.moduleCurrType['occupancy'])},
	function(tvList) {
		console.log($scope.tvList);
		$scope.tours_tickets=$scope.tvList.TicketValuationRS.ServiceTicket;
		$scope.tavailTicket=$scope.tours_tickets.AvailableModality.PriceList.Price
		hdata={
			pToken:'none',
			Availtoken:$avail,
			contractName:$scope.tours_tickets.ContractList.Contract.Name,
			contractCode:$scope.tours_tickets.ContractList.Contract.IncomingOffice['@code'],
			ServiceType:'ServiceTicket',
			occupancy:JSON.stringify($scope.search_c.moduleCurrType['occupancy']),
			DateFrom:$scope.tours_tickets.DateFrom['@date'],
			DateTo:$scope.tours_tickets.DateFrom['@date'],
			currency:$scope.tours_tickets.Currency['@code'],
			ticketcode:$scope.tours_tickets.TicketInfo.Code,
			destcode:$scope.tours_tickets.TicketInfo.Destination['@code'],
			availcode:$scope.tours_tickets.AvailableModality['@code'],
			availName:$scope.tours_tickets.AvailableModality.Name,
			availContactName:$scope.tours_tickets.AvailableModality.Contract.Name,
			availContactcode:$scope.tours_tickets.AvailableModality.Contract.IncomingOffice['@code'],
			tourAdult:$scope.tours_tickets.Paxes.AdultCount,
			tourChild:$scope.tours_tickets.Paxes.ChildCount
		};
		serviceAdd.addService(hdata).then(function(response) {

				$scope.serv=response.ServiceAddRS.Purchase.ServiceList.Service;
				$scope.services=[]
				if(Array.isArray($scope.serv)){
					for(var i=0; i<$scope.services.length; i++){
						$scope.services.push($scope.serv[i])
					}
				}
				else{$scope.services.push($scope.serv) }
				for(var i=0; i<$scope.services.length; i++){
					if($scope.services[i]['@xsi:type']=='ServiceTicket'){
						$scope.cust=[];
						var tour_guests=$scope.services[i].Paxes.GuestList.Customer;
						console.log(tour_guests)
						if(Array.isArray(tour_guests)){
							var all_guest_det=[]
							total_guest=tour_guests.length;
							for(c=0; c<total_guest; c++){
								guest_det={cust_id:tour_guests[c].CustomerId, cust_type:tour_guests[c]['@type'], cust_age:tour_guests[c].Age}
								all_guest_det.push(guest_det);
							}
							$scope.cust=all_guest_det;

						}
						else{
							guest_det={cust_id:tour_guests.CustomerId, cust_type:tour_guests['@type'], cust_age:tour_guests.Age}
							$scope.cust.push(guest_det);
							console.log($scope.cust)
						}

						travel_pack={ 
							product:'HotelBed', 
							productType:'Tour', 
							purchaseToken:response.ServiceAddRS.Purchase['@purchaseToken'], 
							Adult:$scope.tours_tickets.Paxes.AdultCount, 
							Child:$scope.tours_tickets.Paxes.ChildCount,	
							hdesdesc:$scope.search_c.hdesdesc,	
							ticketDate:$scope.tours_tickets.DateFrom['@date'], 
							Name:$scope.services[i].TicketInfo.Name,  
							categoryName:$scope.tours_tickets.AvailableModality.Name, 
							Price:$scope.services[i].TotalAmount, 
							Spui:$scope.services[i]['@SPUI'], 
							occupancy:$scope.search_c.moduleCurrType['occupancy'], 
							cust_det:$scope.cust, 
							comment:$scope.services[i].CommentList.Comment.$, 
							cancel:$scope.services[i].CancellationPolicyList, 
							guestBreak:[], 
							currency:$scope.services[i].Currency['@code'], imgurl:tour.TicketInfo.ImageList.Image[0].Url};
						console.log(travel_pack);
					}
					travelPackD.setData(travel_pack)
					setCookie('travelPD',travelPackD.data(), 30)
					$location.path('/travel_pack');
				}

			}, function(err) {
				console.log('error')
			}
		);
	})
}
}]);

tourList.directive('eachTour', function(tour_cat) {
	return {
		restrict:'E',
		templateUrl: 'template/tour_valuation.html',
		controller: function($scope, $attrs,  tourValuationRs, serviceAddRs, travelPackD, $location,$window, tour_cat) {
			$scope.$on('tourBroadcast', function() {
						$scope.tour_category = tour_cat.data;
					});
				console.log($scope.tour_category)
			$scope.isArray = function(obj) {
			  //Check if Array.isArray is available (is not supported in IE8)
			  var fn = $window.Array.isArray || $window.angular.isArray;
			  return fn(obj);
			 }
			$scope.tour_date=function(selected){
				console.log('herhe')
				console.log(selected)
			}
		}
	}
})

tourList.directive('tourvaluate', function($compile, tourValuationRs, tour_cat, $rootScope) {
    return {
        link: function link($scope,  element, attrs) {
            element.bind('click', function() {
			  	  if(element.parent().parent().parent().children(".view_all_boards").length){$(".view_all_boards").remove()}
				else{
					$scope.tour=JSON.parse(attrs.tourz);
					$scope.tour_category=$scope.tour.AvailableModality
					$scope.tour_all
					console.log($scope.tour_category)
					tour_cat.prepForBroadcast($scope.tour_category);
					$scope.$on('tourBroadcast', function(event, tour_cat) {
						console.log(tour_cat)
						$scope.tour_category = tour_cat.data;
					});
					console.log($scope.tour_all)
					$scope.ind=attrs.name;
					var newElement = $compile( "<each-tour class='col-md-18 nopadding'></eachtour>" )( $scope );
					element.parent().parent().parent().append( newElement );
				}
				element.parent().parent().siblings(".hideme").toggleClass("showme");
				element.children(".minus_ic").toggleClass("showme");
				element.children(".plus_ic").toggleClass("hideme");


            })
        },
    }
});

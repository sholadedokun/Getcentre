// JavaScript Document
var tourDetail =  angular.module('tourDetail', []);


tourDetail.controller('tourDetail', ['$scope', 'searchDatas', 'tourData', 'purchaseData', 'tourValuationRs', 'travelPackD', 'serviceAdd','$http', '$location', 'currencyData', '$window', function($scope, searchDatas, tourData, purchaseData, tourValuationRs, travelPackD, serviceAdd, $http, $location, currencyData, $window) {

  $scope.getData= searchDatas.data();
  $scope.getTour=tourData.data();//stores all ticket booked
  console.log($scope.getData);
  $scope.tourlist=[];
  $scope.offer="";
  $scope.tour;
  detail_tour();
  $scope.currData= currencyData.data();
  function detail_tour(){
	  var tour={};
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
		console.log($scope.getTour[0], $scope.search_c);
		$scope.mtour=$scope.getTour[0];
		$scope.amode=ifarray($scope.getTour[0].AvailableModality);
		hdata={availToken:$scope.getTour[0]['@availToken'], ticketCode:$scope.getTour[0].TicketInfo.Code, ticketContractName:$scope.amode.Contract.Name, ticketContractCode:$scope.amode.Contract.IncomingOffice['@code']}
		$http({method:'Post', url:'server/tourDetails_httpRQ.php', data:hdata}).then(function successCallback(response) {
			console.log(response)
			$scope.tour=response.data.TicketDetailRS.Ticket;
			$scope.mainImageUrl=$scope.tour.ImageList.Image[0].Url
			$scope.allpict=$scope.tour.ImageList.Image
			$scope.curr_pict=1;
			$scope.t={}
			$scope.t.name= $scope.tour.Name
			$scope.t.brief= $scope.tour.DescriptionList.Description.$
			$scope.t.desitnation= $scope.tour.Destination.Name+' '+$scope.tour.Destination['@code']
			$scope.t.segment=$scope.tour.Segmentation.SegmentationGroup
		})
		$scope.setImage=function(thumb, index){
			index=(index*2)
			$scope.curr_pict=index+1;
			$scope.mainImageUrl=$scope.tour.ImageList.Image[index]
		}
  }
  function ifarray(el){ 	if(el[0]){ return el[0]}else{return el}  }
  function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
	$scope.isArray = function(obj) {
		  //Check if Array.isArray is available (is not supported in IE8)
		  var fn = $window.Array.isArray || $window.angular.isArray;
		  return fn(obj);
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
	$scope.tvList = tourValuationRs.get({tTicketCode:$code, tAvailToken: $avail, tAvailModal: $availModal, hDesCode:$scope.search_c.hdescode,	hTourin:date, hTourout:date, occupancy:JSON.stringify($scope.search_c.moduleCurrType.occupancy[0])},
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
			tourBreakDown:JSON.stringify($scope.search_c.moduleCurrType.occupancy[0]),
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

						travel_pack={ product:'HotelBed', productType:'Tour', purchaseToken:response.ServiceAddRS.Purchase['@purchaseToken'], Adult:$scope.tours_tickets.Paxes.AdultCount, Child:$scope.tours_tickets.Paxes.ChildCount,	hdesdesc:$scope.search_c.hdesdesc,	ticketDate:$scope.tours_tickets.DateFrom['@date'], Name:$scope.services[i].TicketInfo.Name,  categoryName:$scope.tours_tickets.AvailableModality.Name, Price:$scope.services[i].TotalAmount, Spui:$scope.services[i]['@SPUI'], hroomdist:$scope.search_c.hRoomBreak, cust_det:$scope.cust, comment:$scope.services[i].CommentList.Comment.$, cancel:$scope.services[i].CancellationPolicyList, guestBreak:[], currency:$scope.services[i].Currency['@code'], imgurl:tour.TicketInfo.ImageList.Image[0].Url};
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

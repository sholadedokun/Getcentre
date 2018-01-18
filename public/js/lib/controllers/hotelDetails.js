// JavaScript Document
var hotelDetails =  angular.module('hotelDetails', ['angular.filter', 'ui.bootstrap']);

 hotelDetails.directive('onFinishRender', function ($timeout) {
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
hotelDetails.controller('hotelDetails', ['$scope', 'searchDatas', 'hotelData', '$http', 'purchaseData', 'serviceAddRs','travelPackD', '$location','appRequest', function($scope, searchDatas, hotelData, $http, purchaseData, serviceAddRs, travelPackD, $location,appRequest) {
  $scope.load_note=true;

  $scope.search_c= searchDatas.data();
  $scope.getSelected= hotelData.data();
  // $scope.search_c= $scope.search_c.data
  console.log($scope.getSelected)
  $scope.curr_pic=1;
  $scope.disabled=false;
  $scope.contact;
  $scope.visT=['N','N','N','N','N','N','N','N','N']; //for payment information

  //update search
  if($scope.getSelected.length==0){
        console.log('here 2')
    	$scope.getSelected=checkCookie('hotel_details');
    	$scope.hot=$scope.getSelected[0];
    	$scope.search_c=checkCookie('Last_Search');
        console.log($scope.search_c, $scope.hot)
    	$scope.travelPD=checkCookie('travelPD');
	}
	else{
        console.log('here 1')
		$scope.search_c=checkCookie('Last_Search');
		$scope.hot=$scope.getSelected[0];
		setCookie("hotel_details", JSON.stringify($scope.getSelected), 30);

		//setCookie("travelPD", $scope.travelPD, 30);
	}

  function setCookie(cname, cvalue, exdays){
      var d = new Date();
      d.setTime(d.getTime() + (exdays*24*60*60*1000));
      var expires = "expires="+d.toUTCString();
      document.cookie = cname + "=" + cvalue + "; " + expires;
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
		if (lSsearch != ""){	return JSON.parse(lSsearch);	}
		else {}
	}

	f=$scope.search_c.moduleCurrType[1].value.short;
	t=$scope.search_c.moduleCurrType[2].value.short;
	var fdate = [f.slice(0, 4), f.slice(4,6), f.slice(6)].join(' ');
	$fday=moment(fdate).format('DD MMMM YYYY');
	console.log($fday)
	$t= $fday.split(' '); $scope.f_day = $t[0];    $scope.f_month = $t[1];     $scope.f_year = $t[2];

	var tdate = [t.slice(0, 4), t.slice(4,6), t.slice(6)].join(' ');
	$tday=moment(tdate).format('DD MMMM YYYY');
	console.log($tday);
	$dt= $tday.split(' ');	$scope.t_day = $dt[0];    $scope.t_month = $dt[1];     $scope.t_year = $dt[2];
	getDetails();
	function getDetails(){
		console.log($scope.hot)
		var url=''
		if($scope.hot.tag=='HotelBed'){	url='server/hotelDetailsRQ.php?hotelCode='+$scope.hot.hotelCode;}
		else{url='server/hotelDetailsRQ_juniper.php?hname='+$scope.hot.hotelName+'&lat='+$scope.hot.position[0]['0']+'&long='+$scope.hot.position[1]['0']}
		$http({method:'GET', url:url}).then(function successCallback(response) {
		 // $scope.hDetail = hotelDetailsRs.query({hotelCode:$scope.search_c.hcode}, function(hList) {
			$scope.load_note=false;
			console.log(response);
			$scope.hotel_Detail=response.data;
			console.log($scope.hotel_Detail);
			$scope.mainImageUrl = $scope.hotel_Detail.details[0].img_path;
			$scope.hotelcode= $scope.hotel_Detail.details[0].hotelCode;

            $scope.hotelE= new getHotelFacilities('server/hotelFacilityEntertainmentRQ.php');
            $scope.hotelF= new getHotelFacilities('server/hotelFacilityFactRQ.php');
            $scope.HotelG= new getHotelFacilities('server/hotelFacilityGreenProRQ.php');
			$scope.HotelH= new getHotelFacilities('server/hotelFacilityHealthRQ.php');
			$scope.HotelHo= new getHotelFacilities('server/hotelFacilityHotelRQ.php');
            $scope.HotelM= new getHotelFacilities('server/hotelFacilityMainRQ.php');
            $scope.HotelMe= new getHotelFacilities('server/hotelFacilityMealOptRQ.php');
            $scope.HotelN= new getHotelFacilities('server/hotelFacilityNearestRQ.php');
			$scope.HotelP= new getHotelFacilities('server/hotelFacilityPaymentReceivedRQ.php');
            $scope.HotelPr= new getHotelFacilities('server/hotelFacilityProxRQ.php');
            $scope.HotelR= new getHotelFacilities('server/hotelFacilityRoomRQ.php');
            $scope.HotelS= new getHotelFacilities('server/hotelFacilitySportOptRQ.php');
			$scope.HotelIs= new getHotelFacilities('server/hotelIssuesRQ.php');
            $scope.HotelTerm= new getHotelFacilities('server/hotelTerminalRQ.php');
            $scope.Contact= new getHotelFacilities('server/hotelContactstRQ.php');
			$scope.HotelRE=  new getHotelFacilities('server/hotelFacilityRoomEquipRQ.php');
            console.log($scope.hotelE)
		   }, function errorCallback(response) {
			alert('error Occured')
			console.log(response);
});
    function getHotelFacilities(url){
        var result=appRequest.sendRequest(url).query({hotelCode:$scope.hot.hotelCode});
        result.$promise.then(function(data){
            console.log(data[0])
            return data;
        },
        function(err){
            console.log(err);
        })
    }
	$scope.setvis=function(ind){
		$scope.visT[ind]='S';
	}
  console.log($scope.search_c);
  $scope.board='';
  $scope.roomtype='';
  $scope.setImage = function(imageUrl, ind) {      $scope.mainImageUrl = imageUrl;  $scope.curr_pic=ind+1  };
	$scope.roomTotalPrice=[0,0,0,0,0,0,0]
	$scope.room_all=$scope.getSelected[0].availRoom
	console.log($scope.room_all)
	roomboard($scope.room_all)
	function roomboard(room_all){
		$scope.room_allo=[];
		$scope.guestBreak=[];
		while( $scope.room_allo.push([]) < $scope.search_c.hTotalroom);
		while( $scope.guestBreak.push([]) < $scope.search_c.hTotalroom);
		for($i=0; $i<$scope.search_c.hTotalroom; $i++){ // this loop create different array according to Occupancy in each room
        var ind=0;
		  for (property in room_all){//loop through the room_avail to get all room occupancies for this room
			  if(room_all.hasOwnProperty(property)){
				  if(room_all instanceof Array){var properti=room_all[property];}
				  else{var properti=room_all;}
				  var occupants=properti.HotelOccupancy.Occupancy;
				  if((occupants.AdultCount== $scope.search_c.hRoomBreak[$i][1])&&(occupants.ChildCount==$scope.search_c.hRoomBreak[$i][2].length)){
					$scope.room_allo[$i].push(properti);
					ind++;
					if(ind==1){
						$scope.roomTotalPrice[$i+1]=properti.HotelRoom.Price.Amount;
						$scope.guestBreak[$i]=properti
						console.log($scope.guestBreak[$i])
					}
				  }
				}
			}
		}
		addtotal();
	}
	}
	function addtotal(){
		$scope.totalPrice=0;
		for($i=1; $i<$scope.roomTotalPrice.length; $i++){
			$scope.totalPrice=(parseFloat($scope.totalPrice) + parseFloat($scope.roomTotalPrice[$i]));
		}
		$scope.roomTotalPrice[0]=($scope.totalPrice).toFixed(2);
		//$scope.$apply($scope.totalPrice);
	}
	function getObjects(obj,  bval,  rval, index) {
	objects = [];
	for (var i in obj) {
	if (!obj.hasOwnProperty(i)) continue;
	if (typeof obj[i] == 'object') {
	try{
		if(obj[i].Board.$==bval && obj[i].RoomType.$==rval ){
			console.log(obj[i]);
			if(obj.HotelOccupancy.Occupancy.AdultCount==$scope.search_c.hRoomBreak[index][1] && obj.HotelOccupancy.Occupancy.ChildCount==$scope.search_c.hRoomBreak[index][2].length){
			objects.push(obj);
			}
			else{objects = objects.concat(getObjects(obj[i], bval, rval, index))}
			//return obj;
		}
		else{objects = objects.concat(getObjects(obj[i], bval, rval, index));}
	}
	catch(e){ objects = objects.concat(getObjects(obj[i], bval, rval, index));}
	}
	/*else if (i == board && obj[board] == bval) {
	objects.push(obj);
	}*/
	}
	return objects;
	}
	$scope.get_room_type=function(type, boad, index){
		$scope.roomtype=type;
		$scope.board=boad;
		console.log($scope.guestBreak);
		$scope.att=getObjects($scope.room_allo, $scope.board, $scope.roomtype, index);
		$scope.guestBreak[index]=$scope.att[0]
		console.log($scope.guestBreak);
		console.log($scope.att)
		$scope.roomTotalPrice[index+1]=$scope.att[0].HotelRoom.Price.Amount;
		addtotal();
	}
	$scope.get_room_board=function(type, boad, index){
		$scope.roomtype=type;
		$scope.board=boad;
		$scope.att=getObjects($scope.room_allo,  $scope.board, $scope.roomtype, index);
		$scope.guestBreak[index]=$scope.att[0]
		console.log($scope.guestBreak)
		console.log($scope.att)
		$scope.roomTotalPrice[index+1]=$scope.att[0].HotelRoom.Price.Amount
		addtotal();
	}
	function getcustomer(room_break, tag){
		console.log(room_break);
		$scope.cust=[];
		if(tag=='HotelBed'){
			var room_guests=room_break.HotelOccupancy.Occupancy.GuestList.Customer;
			if(Array.isArray(room_guests)){
				var all_guest_det=[]
				total_guest=room_guests.length;
				for(c=0; c<total_guest; c++){
					guest_det={cust_id:room_guests[c].CustomerId, cust_type:room_guests[c]['@type'], cust_age:room_guests[c].Age}
					all_guest_det.push(guest_det);
				}
				$scope.cust=all_guest_det;
				return $scope.cust;
			}
			else{
				guest_det={cust_id:room_guests.CustomerId, cust_type:room_guests['@type'], cust_age:room_guests.Age}
				$scope.cust.push(guest_det);
				return $scope.cust;
			}
		}
		else{
			var ad_guests=room_break.HotelOccupancy.Occupancy.AdultCount;
			var ch_guests=room_break.HotelOccupancy.Occupancy.ChildCount;
			all_guest_det=[]
			for (g=0; g<(ad_guests+ch_guests); g++){
				if(g<ad_guests){ guest_det={cust_id:g, cust_type:'Adult', cust_age:''}}
				else{ guest_det={cust_id:g, cust_type:'Child', cust_age:'6'}}
				all_guest_det.push(guest_det);
			}
			return all_guest_det
		}
	}
	$scope.book_room=function(code_token, room_index){
	 $scope.load_note=true;
	  $selected_rooms=[];
	  if(Array.isArray($scope.hot.availRoom)){
		  if(room_index==0){
			  if($scope.search_c.hTotalroom<2){	  $selected_rooms.push($scope.hot.availRoom[room_index])}
			  else{
			  	for($i=0; $i<$scope.search_c.hTotalroom; $i++){
					for (property in $scope.hot.availRoom){//loop through the room_avail to get all room occupancies for this room
					  if($scope.hot.availRoom.hasOwnProperty(property)){
						  var properti=$scope.hot.availRoom[property];
						  var occupants=properti.HotelOccupancy.Occupancy;
						  if((occupants.AdultCount== $scope.search_c.hRoomBreak[$i][1])&&(occupants.ChildCount==$scope.search_c.hRoomBreak[$i][2].length)){
						  	$selected_rooms.push(properti); break;
						  }
						}
					}
				}

			 }

		}
	      else{$selected_rooms=room_index }//because the available room is set to room index in this case
	  }
	  else{$selected_rooms.push($scope.hot.availRoom)}
	  console.log($selected_rooms);
	  $scope.purchaseD=purchaseData.data();
	  $scope.purchaseT='none';
	//  console.log($scope.hot)

		if($scope.hot.tag=='HotelBed'){
			if($scope.purchaseD[0]!=null){ $scope.purchaseT=$scope.purchaseD[0]['@purchaseToken']}
			$bookurl='server/serviceAdd_httpRQ.php';
			hdata={pToken:$scope.purchaseT,
				Availtoken:$scope.hot.availToken,
				contractName: $scope.hot.contractName,
				contractCode: $scope.hot.contractCode,
				'Guest':JSON.stringify($scope.search_c.hRoomBreak),
				'bookData':JSON.stringify($selected_rooms),
				DateFrom:$scope.search_c.hcheckin,
				Troom:$scope.search_c.hTotalroom,
				ServiceType:'ServiceHotel',
				DateTo:$scope.search_c.hcheckout,
				hotelcode: $scope.hot.hotelCode,
				destcode:$scope.search_c.hdescode
			}

		}
		else{
			$bookurl='server/hotel_book_rule_juniper.php';
			hdata= { h_code:$scope.hot.hotelCode, c_in : $scope.hot.dateFrom, c_out:$scope.hot.dateTo, s_num: $scope.hot.S_num, selected_room:$selected_rooms
				}
		}
		$http({method:'Post', url:$bookurl, data:hdata}).then(function successCallback(response) {

				console.log(response);
				console.log($scope.hot);
				$scope.roomz=[]
				$scope.services=[]
				$scope.serv=[]
				if($scope.hot.tag=='HotelBed'){
					$scope.services=response.data.ServiceAddRS.Purchase.ServiceList.Service;
					if(Array.isArray($scope.services)){
						for($r=0; $r<$scope.services.length; $r++)	{
							if($scope.services[$r]['@xsi:type']=='ServiceHotel'){
								$scope.services[$r].availRoom= $scope.services[$r].AvailableRoom;
								$scope.serv.push($scope.services[$r]);
							}
						}
					}
					else{$scope.services.availRoom= $scope.services.AvailableRoom; $scope.serv.push($scope.services)}
					hotelData.setData($scope.serv);
					//lazy work
					/*$scope.serv.availRoom=$scope.serv.AvailableRoom;
					if(Array.isArray($scope.serv)){
						console.log('here at if');
						for(var i=0; i<$scope.services.length; i++){$scope.services.push($scope.serv[i]);}
					}
					else{ console.log('here at else');	 $scope.services.push($scope.serv) }*/
				}
				else{ $scope.services={}; $scope.hot.availRoom[0].HotelRoom.CancellationPolicies=response.data;
						$scope.services.availRoom= $scope.hot.availRoom[0];
						$scope.services.TotalAmount= $scope.hot.availRoom[0].HotelRoom.Price.Amount;
						$scope.services.Currency= $scope.hot.currency;
						$scope.services.HotelInfo= {};
						$scope.services.HotelInfo.Code=$scope.hot.hotelCode;
						scope.serv.push($scope.services)
					}
				for($a=0; $a<$scope.serv.length; $a++){
					console.log( $scope.serv);
					if($scope.serv[$a].HotelInfo.Code==$scope.hot.hotelCode){
						 console.log( $scope.serv[$a]);
						if(Array.isArray($scope.serv[$a].availRoom)){
							for($b=0; $b<$scope.serv[$a].availRoom.length; $b++){
								$scope.cust=getcustomer($scope.serv[$a].availRoom[$b], $scope.hot.tag)
								roomz={
									board:$scope.serv[$a].availRoom[$b].HotelRoom.Board.$, roomtype:$scope.serv[$a].availRoom[$b].HotelRoom.RoomType.$,
									cancel:$scope.serv[$a].availRoom[$b].HotelRoom.CancellationPolicies,
									adultCount:$scope.serv[$a].availRoom[$b].HotelOccupancy.Occupancy.AdultCount,
									childCount:$scope.serv[$a].availRoom[$b].HotelOccupancy.Occupancy.ChildCount,
									roomCount:$scope.serv[$a].availRoom[$b].HotelOccupancy.RoomCount,
									price:$scope.serv[$a].availRoom[$b].HotelRoom.Price.Amount,	guest_details:null, cust_det:$scope.cust
								}
								$scope.roomz.push(roomz);

							}
						}
						else{
							$scope.cust=getcustomer($scope.serv[$a].availRoom, $scope.hot.tag);
							roomz={
								board:$scope.serv[$a].availRoom.HotelRoom.Board.$, roomtype:$scope.serv[$a].availRoom.HotelRoom.RoomType.$,
								cancel:$scope.serv[$a].availRoom.HotelRoom.CancellationPolicies, guest_details:null,cust_det:$scope.cust,
								adultCount:$scope.serv[$a].availRoom.HotelOccupancy.Occupancy.AdultCount,
								childCount:$scope.serv[$a].availRoom.HotelOccupancy.Occupancy.ChildCount,
								roomCount:$scope.serv[$a].availRoom.HotelOccupancy.RoomCount,
								}
							if($scope.hot.tag=='Juniper'){roomz.price=$scope.serv[$a].availRoom[0].HotelRoom.Price.Amount}
							else{roomz.price=$scope.serv[$a].availRoom.HotelRoom.Price.Amount}
							$scope.roomz.push(roomz);

						}
						travel_pack={ product:$scope.hot.tag, productType:'Hotel', Adult:$scope.search_c.hAdult, Child:$scope.search_c.hChild,
				hdesdesc:$scope.search_c.hdesdesc,	hcheckin:$scope.hot.dateFrom, hcheckout:$scope.hot.dateTo, hcheckinL:$scope.search_c.hcheckinL, hcheckoutL:$scope.search_c.hcheckoutL, imgurl:$scope.hot.hotelImages[0], Name:$scope.hot.hotelName,  hRoom:$scope.search_c.hTotalroom,  Price:$scope.serv[$a].TotalAmount,  guestBreak:$scope.roomz,  total_nights:$scope.search_c.htotalnight, hroomdist:$scope.search_c.hRoomBreak,  ref:null, serviceRef:null, supplier:null};
					}
					if($scope.hot.tag=='HotelBed'){
						travel_pack.hStar=$scope.hot.hotelCat.$;
						travel_pack.contractComment=$scope.serv[$a].ContractList.Contract.CommentList;
						travel_pack.Spui=$scope.serv[$a]['@SPUI'];
						travel_pack.purchaseToken=response.data.ServiceAddRS.Purchase['@purchaseToken'];
						travel_pack.currency=$scope.serv[$a].Currency['@code'];
						$scope.getC=hotelContact.query({hotelCode:$scope.serv[$a].HotelInfo.Code}, function(getC){
							travel_pack.hotelContact=getC[0];
							travelPackD.setData(travel_pack)
							setCookie('travelPD',travelPackD.data(), 30)
							$location.path('/travel_pack');
						})

					}
					else{
						travel_pack.hStar=$scope.hot.hotelCat['@attributes'].Code;
						travel_pack.currency=$scope.serv[$a].Currency;
						travel_pack.rateplan=$selected_rooms[0].HotelRoom.RateCode;
						travel_pack.Snum=$scope.hot.S_num;
						travel_pack.hcode=$scope.hot.hotelCode;
						travel_pack.destination=$scope.hot.destination;
						travel_pack.position=$scope.hot.position;
						travelPackD.setData(travel_pack)
						setCookie('travelPD',travelPackD.data(), 30)
						$location.path('/travel_pack');
					}
				}
			}
		)
	}
}]);

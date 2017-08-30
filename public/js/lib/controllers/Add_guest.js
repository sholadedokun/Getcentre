// JavaScript Document
var AddGuest =  angular.module('AddGuest', ['angular.filter', 'ui.bootstrap']);
AddGuest.controller('AddGuest', ['$scope', 'searchDatas',  'sendmailRS', 'flightBookRs', 'sendmailFlight', 'userData', 'travelPackD',   '$modal', '$log', '$location', '$http','purchaseConfirmRs','purchaseRemoveRs','updateB', 'currencyData', function($scope, searchDatas, sendmailRS, flightBookRs, sendmailFlight, userData, travelPackD, $modal, $log, $location, $http,purchaseConfirmRs, purchaseRemoveRs, updateB, currencyData) {
$scope.$on('logged-in', function(event, args) {add_guest($scope.travelPD)});
$scope.guest=[]
$scope.disabled=false;
$scope.payoption='';
$scope.rate=currencyData.data();
$scope.pricing={pricelist:[], curCur:'', totalPrice:''}
function setCookie(cname, cvalue, exmins) {
    var d = new Date();
    d.setTime(d.getTime() + (exmins*60*1000));
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
}
	$scope.travelPD=travelPackD.data();
    console.log($scope.travelPD)
	if((travelPackD.data().length<1)){
        $scope.travelPD=getCookie('travelPD');

        if(typeof $scope.travelPD != 'undefined'){
            $scope.travelPD=JSON.parse($scope.travelPD);
            travelPackD.saveData($scope.travelPD);
            add_guest($scope.travelPD)
        }
        else{
            $location.path('/');
        }

     }
	else{ console.log($scope.travelPD); add_guest($scope.travelPD)}

	function getlead(gService, user){
		gService.title=user.title; gService.fname=user.fname; gService.lname=user.lname; gService.email=user.email;
		gService.phone=user.phone; gService.dbirth=user.dob;  gService.caddress=user.caddress; gService.city=user.city;
		gService.state=user.state; gService.pcode=user.pcode; gService.country=user.country; gService.nationality=user.nationality
	}
	function add_guest(data){
		console.log(data)
		$scope.user=userData.data();
		console.log($scope.user);
		if($scope.user[0].status=='Logged_in'){	$scope.def=$scope.user[1];	}
		$scope.totalPrice=0;
		for($i=0; $i<data.length; $i++){
			$scope.flight_g=[]
			$scope.hotel_g=[];
			$scope.tour_g=[];
			$scope.transfer_g=[];
			$scope.docuIssuCoun=[{"code":"", "name":"Issuing Country"}];
			$scope.AddService=[{"code":"", "name":"Special Needs"}];
			$scope.docuType=[{"code":"", "name":"Document Type"}];
			$scope.country=[{"code":"", "name":"Country"}];
			$scope.gender=[{"code":"", "name":"Title"}];
			$scope.Pmeal=[{"code":"", "name":"Prefered Meal"}];
			$scope.SeatinP=[{"code":"", "name":"Plane Seat"}];
			$scope.nationality=["Nationality"];
		 	if((data[$i].product=='Sabre')&&(data[$i].productType=='Flight')){
				$http.get("js/lib/addSer.json").success(function(response) {$scope.AddService = response;});//get additional service Json
				$http.get("js/lib/document_type.json").success(function(response) {$scope.docuType = response;});//get document types Json
				$http.get("js/lib/country.json").success(function(response) {$scope.country = response;});//get country Json
				$http.get("js/lib/country_of_issue.json").success(function(response) {$scope.docuIssuCoun = response;});//get country Json
				$http.get("js/lib/planeGender.json").success(function(response) {$scope.gender = response;});//get gender Json
				$http.get("js/lib/planeMeal.json").success(function(response) {$scope.Pmeal = response;});//get gender Json
				$http.get("js/lib/planeSeat.json").success(function(response) {$scope.SeatinP = response;});//get gender Json*/
				$http.get("js/lib/nationality.json").success(function(response) {$scope.nationality = response;});//get nationality Json

				$scope.flight_p={adult:[], child:[], seniors:[], infant:[]};

				for($a=0; $a<data[$i].Adult; $a++){
					guest={title:"", fname:"", lname:"", email:"", phone:"", dbirth:"", caddress:"", city:"", state:"", pcode:"", country:"", nationality:"", docuType:'', docuNumber:'', docuExp:'', docuIssuCoun:'', Home_no:'', Pmeal:'', SeatinP:'', AddService:'', FreqFprog:'' }
					$scope.flight_p.adult.push(guest)
					if($a==0 && $scope.user[0].status=='Logged_in'){getlead($scope.flight_p.adult[0],$scope.def)}
				}
				for($a=0; $a<data[$i].Child; $a++){
					dbirth=data[$i].Child_ages.split(',')[$a];
					guest={title:"", fname:"", lname:"", email:"", phone:"", dbirth:dbirth, caddress:"", city:"", state:"", pcode:"", country:"", nationality:"", docuType:'', docuNumber:'', docuExp:'', docuIssuCoun:'', Home_no:'', Pmeal:'', SeatinP:'', AddService:'', FreqFprog:'' }
					$scope.flight_p.child.push(guest)
				}
				for($a=0; $a<data[$i].Seniors; $a++){
					guest={title:"", fname:"", lname:"", email:"", phone:"", dbirth:"", caddress:"", city:"", state:"", pcode:"", country:"", nationality:"", docuType:'', docuNumber:'', docuExp:'', docuIssuCoun:'', Home_no:'', Pmeal:'', SeatinP:'', AddService:'', FreqFprog:'' }
					$scope.flight_p.seniors.push(guest)
					if(($a==0 && $scope.user[0].status=='Logged_in') && ($scope.flight_p.adult.length<1)){getlead($scope.flight_p.seniors[0],$scope.def)}
				}
				for($a=0; $a<data[$i].Infant; $a++){
					dbirth=data[$i].infant_ages.split(',')[$a];
					guest={title:"", fname:"", lname:"", email:"", phone:"", dbirth:dbirth, caddress:"", city:"", state:"", pcode:"", country:"", nationality:"", docuType:'', docuNumber:'', docuExp:'', docuIssuCoun:'', Home_no:'', Pmeal:'', SeatinP:'', AddService:'', FreqFprog:'' }
					$scope.flight_p.infant.push(guest);
				}
				console.log($scope.flight_p)
				data[$i].guest_details=$scope.flight_p;
				$scope.pricing.pricelist.push({cur:data[$i].cur,  price:data[$i].Price})
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].Price);
			}
			if(((data[$i].product=='HotelBed') || (data[$i].product=='Juniper'))&&(data[$i].productType=='Hotel')){ //find and declares all hotel guest with room comments
				//$scope.hotel_d={hname:data[$i].hName, hcheckin:data[$i].hcheckin, hcheckout:data[$i].hcheckout, roomz:[]};
				for($b=0; $b<data[$i].guestBreak.length; $b++){ // loop through the number of rooms booked
					console.log(data[$i])
					$roo=data[$i].hroomdist; // get the current guest distrubution in a room.
					$scope.room={comment:'', guest:[]} //declares an object to hold the comment and guest details
					for($a=0; $a<$roo[$b][0].value; $a++){ // loops through the number of adults
						guest={title:"", fname:"", lname:"", dbirth:""} //declares the default values for the adult
						$scope.room.guest.push(guest) //push empty guest details to the declared guest object.
						if($b==0 && $scope.user[0].status=='Logged_in'){ // if first room, asign the user details to the first adult name
							$scope.room.guest[0]={title:$scope.def.title, fname:$scope.def.fname, lname:$scope.def.lname, dbirth:$scope.def.dbirth}
						}
					}
					for($a=0; $a<$roo[$b][1].value; $a++){ //loop through the children in that room
						guest={title:"Child", fname:"", lname:"", dbirth:""}
						$scope.room.guest.push(guest);
					}
					data[$i].guestBreak[$b].guest_details=$scope.room;
				}
				$scope.hotel_g.push($scope.hotel_d) // push the whole array into the hotel_g
				data[$i].guest_details=$scope.hotel_d;
				$scope.pricing.pricelist.push({cur:data[$i].currency_sy, price:data[$i].Price})
				console.log(data[$i])
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].convertedPrice);
			}
			if((data[$i].product=='HotelBed')&&((data[$i].productType=='Tour')||(data[$i].productType=='Transfer'))){ //find and declares all hotel guest with room comments
				if(data[$i].productType=='Tour'){$roo=data[$i].hroomdist;} // get the current guest distrubution.
				else{$roo=data[$i].hroomdist;}
				$scope.t_guest={comment:'', guest:[]} //declares an object to hold the comment and guest details
				for($a=0; $a<$roo[0][1]; $a++){ // loops through the number of adults
					guest={title:"", fname:"", lname:"", dbirth:""} //declares the default values for the adult
					$scope.t_guest.guest.push(guest) //push empty guest details to the declared guest object.
					if($a==0 && $scope.user[0].status=='Logged_in'){ // if first room asign the user details to the first adult name
						$scope.t_guest.guest[0]={title:$scope.def.title, fname:$scope.def.fname, lname:$scope.def.lname, dbirth:$scope.def.dbirth}
					}
				}
				for($a=0; $a<$roo[0][2].length; $a++){ //loop through the children in that room
					guest={title:"Child", fname:"", lname:"", dbirth:""}
					$scope.t_guest.guest.push(guest);
				}
				data[$i].guestBreak[0]={};
				data[$i].guestBreak[0].cust_det=data[$i].cust_det
				data[$i].guestBreak[0].guest_details=$scope.t_guest;
				$scope.pricing.pricelist.push({cur:data[$i].currency_sy, price:data[$i].Price})
				$scope.totalPrice=parseFloat($scope.totalPrice)+parseFloat(data[$i].convertedPrice);
			}
		}
	}
    // $scope.$watch('travelPD', function (newValue, oldValue, $scope) {
    // if(newValue) {
    //     console.log('fer')
    //      $scope.newAgentPrice()
    //     }
    // });
    $scope.processAgentDiscountFlight=function(service){
        $tot_price=0;
        $tot_pDiscount=0;
        for (property in service.priceB){ //loop through each person
            cprice=service.priceB[property];
            pvalue=0
            newprice=0;
            //check if this flight has been markup_down by checking the the margin object
            if(cprice['@mark_perc'] !=0){
                pvalue=cprice['@nuc'] * ($scope.user[1].flightDiscount/100);
            }
            else{
                pvalue=user[1].flightDiscount;
            }
            $tot_pDiscount=$tot_pDiscount+pvalue;
            //if there is no markup or markdown on the flight
            if(cprice['@margin']==0 || typeof cprice['@margin']=='undefined'){
                $tot_price=$tot_price+parseInt(cprice['@price']);
            }
            else{
                if(cprice['@markType']=='down'){
                    newprice= (parseInt(cprice['@nuc']) - pvalue)+parseInt(cprice['@totalTaxes']);
                }
                else{
                    newprice= (parseInt(cprice['@nuc']) + pvalue)+parseInt(cprice['@totalTaxes']);
                }
                cprice['@agentPrice']=newprice;
                // cprice['@agentDiscount']=cprice['@agentDiscount']+$tot_pDiscount;
                $tot_price=$tot_price+newprice;
            }
        }
        service.discount=$tot_pDiscount;
        service.soldPrice= $tot_price;
    }
    $scope.newAgentPrice=function(){
        $scope.user[1].totalAgentPrice=0
        for(service in $scope.travelPD){
            $scope.user[1].totalAgentPrice=parseInt($scope.user[1].totalAgentPrice) + parseInt($scope.travelPD[service].soldPrice);
        }
    }
	$scope.makeReserv=function(poption){
        $scope.disabled=true;
		var trans=$scope.travelPD;
		console.log(trans);
		var bookref=[];
		//add all transaction to the database
		trandata={trans:trans, userE:$scope.def, payopt:poption}
		$http({method:'Post', url:'server/addtransac.php', data:trandata}).then(function successCallback(response) {
			bookref = response.data;
			//$scope.paynow(bookref)
			//trans={};
			for(t=0; t<trans.length; t++){
				if(trans[t].productType=='Flight'){
					//$scope.flight_guest= JSON.stringify($scope.all_guests[$i]);
					$scope.flight_details= trans[t];
					$scope.main=trans[t];
					//book transaction with our supplier
					$scope.fBook =flightBookRs.save({details:$scope.flight_details}, function(fCheck) {
						$scope.f_booker=$scope.fBook.response;
                        //check if there is error in booking.
                        if($scope.f_booker.ERROR || $scope.f_booker.status=='ERROR' ){
                            $scope.load_note=false;
                            scope.disabled=false;
                            console.log($scope.f_booker.ERRORMSG, $scope.f_booker.ERRORFIELDS.fields[0].msg.$ )
                            var modalInstance = $modal.open({
                			  templateUrl: 'template/booking_error.html',
                			  controller: 'bookErrorModalInstanceCtrl',
                			  //size: 'sm',
                			  windowClass: 'register-modal-window',
                			  resolve: {
                				errorObject: function () {
                				  return $scope.f_booker;
                				}
                			  }
                			})
                        }
						//update transaction with the booking number
						else{
							$scope.sendbook=sendmailFlight.save({
								flightDetails:$scope.flight_details,
								userE:$scope.user[1],
								bookingCode:$scope.f_booker.booking_number,
								bookingRef:bookref[0].basketId},
								function(sendbook){$scope.user=$scope.sendbook;
                                $scope.afterBook($scope.f_booker);
							})
						}
					})
				}
				if(trans[t].product=='HotelBed'){
					console.log(trans[t])
					if(trans[t].productType=='Hotel'){$scope.all_guests= trans[t].guestBreak}
					else{$scope.all_guests= trans[t].guestBreak}
					$scope.hotel_guest= JSON.stringify( $scope.all_guests );
					$scope.product_details= JSON.stringify(trans[t]);
					$scope.main=trans[t];
					$scope.lead=JSON.stringify($scope.def)
					//$scope.main_det=JSON.stringify(trans[t]);
					hdata={lead:$scope.def, details:$scope.product_details}
					$http({method:'Post', url:'server/PurchaseConfirmRQ.php', data:hdata}).then(function successCallback(response) {
						console.log(response);
						$scope.f_booker=response.data.PurchaseConfirmRS.Purchase;
						$scope.p_token=$scope.f_booker['@purchaseToken'];
						$scope.holder=$scope.f_booker.Holder
						$scope.ref=$scope.f_booker.Reference
						$scope.pservices=$scope.f_booker.ServiceList
						$scope.main.ref=$scope.ref;
						console.log($scope.f_booker);
						console.log($scope.user)
						if($scope.pservices instanceof Array){
							for($g=0; $g<$scope.pservices.length; $g++){
								$scope.main.serviceRef=$scope.pservices[$g].Reference
								$scope.main.supplier=$scope.pservices[$g].Supplier
								$scope.sendbook=sendmailRS.get({
									userE:$scope.user[1],
									//hotelDetails:JSON.stringify($scope.pservices[$g]),
									GuestDetails:$scope.lead_guest,
									searchD:$scope.main_det,
									//bookingCode:$scope.f_booker.booking_number
									},
									function(sendbook){$scope.user=$scope.sendbook;}
								)
							}
							$scope.afterBook(bookref);
						}
						else{
							$scope.main.serviceRef=$scope.pservices.Service.Reference
							$scope.main.supplier=$scope.pservices.Service.Supplier
							console.log($scope.main);
							$scope.main_det=$scope.main;
							console.log($scope.main_det)
							sendmailRS.sendmail($scope.user[1], $scope.def, $scope.main_det).then(function(response) {
								$scope.user=response; $scope.afterBook(bookref);
								}, function(err) {
									console.log('error')
								}
							);
						}

					})
				}
				if(trans[t].product=='Juniper'){
					console.log(trans[t])
					if(trans[t].productType=='Hotel'){$scope.all_guests= trans[t].guestBreak}
					else{$scope.all_guests= trans[t].guestBreak}
					$scope.hotel_guest= JSON.stringify( $scope.all_guests );
					$scope.product_details= trans[t];
					$scope.main=trans[t]
					//$scope.main_det=JSON.stringify(trans[t]);

					hdata={lead:$scope.def, details:$scope.product_details}

					$http({method:'Post', url:'server/hotel_book_juniper.php', data:hdata}).then(function successCallback(response) {
						console.log(response.data)
						$scope.book=response.data;
						$scope.main.ref=$scope.book.UniqueId;
						$scope.main_det=$scope.main;

						sendmailRS.sendmail($scope.user[1], $scope.def, $scope.main_det).then(function(response) {
						$scope.user=response; $scope.afterBook();
						}, function(err) {
							console.log('error')
						});
					})
				}
			}

		})
	}
	$scope.afterBook=function(bookref){
		if($scope.payoption=='Paylater'){
			setCookie('travelPD', $scope.travelPD, 30)
			setCookie('lead_guest', $scope.def, 30)
			console.log( $scope.travelPD)
			$location.path('/voucher');
		}
		else{
            $scope.updateBook=updateB.get({trans:bookref[0].basketId, bookCode:$scope.f_booker.booking_number}, function(upres){
                $scope.paynow(bookref);
           })
        }
	}
	$scope.bookings=function(){
		$scope.load_note=true;
		var bookrefs=$scope.makeReserv($scope.payoption);
		//$scope.paynow('345354E234');
	}
	$scope.pay=function(pay){
		$scope.payoption=pay;
		angular.element('#validSUb').trigger('click');
	}
	$scope.paynow=function(refs){
		$scope.getData= searchDatas.data();
		$scope.txn_ref= refs[0].basketId;
		$scope.pay_item_id=101;
		$scope.pay_item_name='Flight Hotel Tours';
		$scope.Namount=0;
		for(var r=0; r<$scope.pricing.pricelist.length; r++){
			if($scope.rate[0].baseCurrency.currFrom !=$scope.rate[0].baseCurrency.currFrom){
				$scope.Namount=$scope.Namount+parseFloat($scope.rate[1].currencyList[$scope.pricing.pricelist[r].cur].rate*$scope.pricing.pricelist[r].price);
			}
			else{$scope.Namount=$scope.pricing.pricelist[r].price}
		}

        // $scope.Namount=50000;
		$scope.Namount=$scope.Namount*100;
		$scope.rcurrency=566;
		$scope.site_redirect_url='https://www.getcentre.com/#/payMentConfirm';
		$scope.site_name="https://www.getcentre.com";
		$scope.cust_id=123;
		$scope.cust_id_desc="Personal";
		$scope.cust_name=$scope.def.lname+' '+$scope.def.fname;
		$scope.cust_name_desc="Customer Name";
		$scope.local_date_time=moment().format('DD/MM/YYYY');

		$scope.payOnlineData={'product_id' : 6208, 'txn_ref' : $scope.txn_ref , 'pay_item_id' : 101, 'pay_item_name' : 'Flight|Hotel', 'amount' : $scope.Namount , 'currency' : $scope.currency , 'site_redirect_url' : $scope.site_redirect_url , 'site_name' : $scope.site_name , 'cust_id' : $scope.cust_id , 'cust_id_desc' : $scope.cust_id_desc , 'cust_name' : $scope.cust_name , 'cust_name_desc' : $scope.cust_name_desc , 'local_date_time' : $scope.local_date_time};
		setCookie('payData', $scope.payOnlineData, 30)
		$location.path('/payMentGateway');
	}
	$scope.cancel_all=function(){
		if($scope.hPtoken!=null){
			$scope.flushP=purchaseRemoveRs.get({pToken:$scope.hPtoken},function(flushP){
				alert('purchase Flushed');
			})
		}
		$scope.travelPD=null;
		$location.path('/home')
	}
//	else{setCookie('travelPD', travelPackD.data(), 30)}
	$scope.getData= searchDatas.data();
	$scope.txn_ref= Math.floor(Math.random()*10000000)+10000000;
	$scope.pay_item_id=101;
	$scope.pay_item_name="adedokun olushola";
	$scope.amount=20000000;
	$scope.currency=566;
	$scope.site_redirect_url='https://www.getcentre.com/test.php#voucher';
	$scope.site_name="http://www.getcentre.com";
	$scope.cust_id=123;
	$scope.cust_id_desc="Personal";
	$scope.cust_name="Adedokun Olushola";
	$scope.cust_name_desc="Regular";
	$scope.local_date_time=moment().format('DD/MM/YYYY');

	//$scope.payOnlineData={product_id:6208, txn_ref:$scope.txn_ref, pay_item_id:101, pay_item_name:'Flight|Hotel', amount:$scope.amount, currency:$scope.currency, site_redirect_url:$scope.site_redirect_url, site_name:$scope.site_name, cust_id:$scope.cust_id, cust_id_desc:$scope.cust_id_desc, cust_name:$scope.cust_name, cust_name_desc:$scope.cust_name_desc, local_date_time:$scope.local_date_time}

	$scope.payOnlineData='product_id=6208&txn_ref='+$scope.txn_ref+'&pay_item_id=101&pay_item_name=Flight|Hotel&amount='+$scope.amount+'&currency='+$scope.currency+'&site_redirect_url='+$scope.site_redirect_url+'&site_name='+$scope.site_name+'&cust_id='+$scope.cust_id+'&cust_id_desc='+$scope.cust_id_desc+'&cust_name='+$scope.cust_name+'&cust_name_desc='+$scope.cust_name_desc+'&local_date_time='+$scope.local_date_time;



	$scope.save_the_hash=function(){
		//$location.path('../server/PayMentGatewayRQRS.php'+$scope.payOnlineData);
		window.location = 'https://www.getcentre.com/server/PayMentGatewayRQRS.php?'+$scope.payOnlineData;
		//$scope.pGate = PayMentGatewayRQRS.get({params:$scope.payOnlineData}, function(pGate) {console.log($scope.pGate);});
		$scope.guest.push($scope.flight_Mguest);
		$scope.guest.push($scope.hotel_Mguest);
		$scope.guest.push($scope.tour_Mguest);
		$scope.guest.push($scope.transfer_Mguest);
		setCookie('Guest', $scope.guest, 30);
		web_auth={'txn_ref':$scope.txn_ref, 'amount':$scope.amount, 'hasher':jQuery('#hash_hid').val()}
		//var webret=JSON.stringify()
		setCookie('webPay', web_auth, 30)
	}
}]);
AddGuest.controller('bookErrorModalInstanceCtrl', ['$scope', '$rootScope', 'userData', '$modalInstance', 'errorObject','travelPackD',  function ($scope, $rootScope, userData, $modalInstance, errorObject, travelPackD){
	$scope.travelPD= travelPackD.data();
    $scope.errorOb=errorObject;
    console.log($scope.errorOb);
    $scope.ok = function (user) {
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);
AddGuest.controller('paymentModalInstanceCtrl', ['$scope', '$rootScope', 'userData', '$modalInstance', 'account',  'registerUser', 'loginUserRs', function ($scope, $rootScope, userData, $modalInstance, account, registerUser, loginUserRs){
	$scope.getData= searchDatas.data();
	$scope.txn_ref= Math.floor(Math.random()*10000000)+10000000;
	$scope.pay_item_id=101;
	$scope.pay_item_name="adedokun olushola";
	$scope.amount=20000000;
	$scope.currency=566;
	$scope.site_redirect_url='http://www.getcentre.com#voucher';
	$scope.site_name="http://www.getcentre.com";
	$scope.cust_id=123;
	$scope.cust_id_desc="Personal";
	$scope.cust_name="Adedokun Olushola";
	$scope.cust_name_desc="Regular";
	$scope.local_date_time=moment().format('DD/MM/YYYY');
	$scope.reset = function(){$scope.user = angular.copy($scope.master);}
    $scope.reset();
	$scope.account=account;
	$scope.payOnlineData='product_id=6208&txn_ref='+$scope.txn_ref+'&pay_item_id=101&pay_item_name=Flight|Hotel&amount='+$scope.amount+'&currency='+$scope.currency+'&site_redirect_url='+$scope.site_redirect_url+'&site_name='+$scope.site_name+'&cust_id='+$scope.cust_id+'&cust_id_desc='+$scope.cust_id_desc+'&cust_name='+$scope.cust_name+'&cust_name_desc='+$scope.cust_name_desc+'&local_date_time='+$scope.local_date_time;
	$scope.save_the_hash=function(){
		//$location.path('../server/PayMentGatewayRQRS.php'+$scope.payOnlineData);
		window.location = 'http://www.getcentre.com/server/PayMentGatewayRQRS.php?'+$scope.payOnlineData;
		//$scope.pGate = PayMentGatewayRQRS.get({params:$scope.payOnlineData}, function(pGate) {console.log($scope.pGate);});
		$scope.guest.push($scope.flight_Mguest);
		$scope.guest.push($scope.hotel_Mguest);
		$scope.guest.push($scope.tour_Mguest);
		$scope.guest.push($scope.transfer_Mguest);
		setCookie('Guest', $scope.guest, 30);
		web_auth={'txn_ref':$scope.txn_ref, 'amount':$scope.amount, 'hasher':jQuery('#hash_hid').val()}
		//var webret=JSON.stringify()
		setCookie('webPay', web_auth, 30)
	}
	$scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);

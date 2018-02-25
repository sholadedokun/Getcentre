// JavaScript Document
(function(){

	var app= angular.module('GetCentre',['ngRoute','ngSanitize','ngAnimate','getAnimations', 'appServices', 'flightList', 'hotelList', 'hotelDetails', 'tourList', 'tourDetail', 'transferList', 'TravelPack', 'AddGuest', 'voucher', 'otherPages','ltourDetails','paymentConfirm']);
	app.directive('a', function () {
    return {
			restrict: 'E',
			link: function (scope, elem, attrs) {
				if ( attrs.href == '' || attrs.href == '#') {
					elem.on('click', function (e) {
						e.preventDefault();
						return;
					});
				}
			}
		};
	})
	app.config(['$routeProvider',
	  function($routeProvider) {
	    $routeProvider.
	      when('/home', {
	        templateUrl: 'partials/home.php',
	        controller: 'GetCentre'
	      }).
	      when('/hotel', {
	        templateUrl: 'partials/hotel_search.php',
	        controller: 'hotelSearch'
	      }).
	      when('/about', {
	        templateUrl: 'partials/about_us.php',
	         controller: 'otherPages'
	      }).
	      when('/hotel/hotel_list', {
	        templateUrl: 'partials/hotel_list.php',
	        controller: 'hotelList'
	      }).
	      when('/hotel/hotel_details', {
	        templateUrl: 'partials/hotel_details.php',
	        controller: 'hotelDetails'
	      }).
	      when('/flight/flight_list', {
	        templateUrl: 'partials/flight_list.php',
	        controller: 'flightList'
	      }).
	      when('/flight/flight_details', {
	        templateUrl: 'partials/flight_details.php',
	        controller: 'flightCheck'
	      }).
	      when('/contact_us', {
	        templateUrl: 'partials/contact_us.php',
	        controller: 'otherPages'
	      }).
	      when('/account', {
	        templateUrl: 'partials/account.php',
	        controller: 'pageController'
	      }).
	      when('/tour/ltour/:id', {
	        templateUrl: 'partials/ltour_details.php',
	        controller: 'ltourDetails'
	      }).
	      when('/tour/tour_list', {
	        templateUrl: 'partials/tour_list.php',
	        controller: 'tourList'
	      }).
	      when('/tour/tour_detail', {
	        templateUrl: 'partials/tour_detail.php',
	        controller: 'tourDetail'
	      }).
	       when('/tours/transfer_list', {
	        templateUrl: 'partials/transfer_list.php',
	        controller: 'transferList'
	      }).
	       when('/visa', {
	        templateUrl: 'partials/visa.php',
	        controller: 'otherPages'
	      }).
	       when('/support', {
	        templateUrl: 'partials/support.php',
	        controller: 'otherPages'
	      }).
	      when('/travel_pack', {
	        templateUrl: 'partials/travel_pack.php',
	        controller: 'TravelPack'
	      }).
	      when('/Addguest', {
	        templateUrl: 'partials/Add_guest.php',
	        controller: 'AddGuest'
	      }).
	      when('/voucher', {
	        templateUrl: 'partials/voucher.php',
	        controller: 'voucher'
	      }).
	      when('/payMentGateway', {
	        templateUrl: 'template/webpay.php',
	        controller: 'webpay'
	      }).
	      when('/payMentConfirm', {
	        templateUrl: 'template/webpayConfirm.php',
	        controller: 'paymentConfirm'
	      }).
	      otherwise({
	        redirectTo: '/home'
	      });
	  }]);
	  app.run(['currencyData','$rootScope','apiProxy', function(currencyData, $rootScope,apiProxy){
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
	  app.controller('GetCentre', ['$scope', 'userData', '$modal', '$log', 'searchData','searchDatas', 'blogRS', '$location', 'currSearch', 'apiProxy','currencyData','blogImageRs', 'ltours','tourData','$http', function ($scope, userData, $modal, $log, searchData, searchDatas, blogRS, $location, currSearch, apiProxy, currencyData, blogImageRs, ltours,tourData, $http) {
	  $scope.paymentRef;
	  $scope.searchinit=false;
	  console.log($scope.paymentRef);



	$scope.setDates=function(){

		//todays transaction
		date={from:{}, to:{}}
		date.from.short=moment().format('YYYYMMDD');
		date.from.long=moment().format('ddd Do, MMM, YYYY');

		$tday=moment().format('DD MMMM YYYY');
		$t= $tday.split(' ');

		date.from.day=$t[0];
		date.from.month=$t[1];
		date.from.year=$t[2];

		//next day transaction
		$nextday=moment().add( 7, 'days').format('DD MMMM YYYY');
		$n= $nextday.split(' ');

		date.to.day=$n[0];
		date.to.month=$n[1];
		date.to.year=$n[2];

		date.to.short=moment($nextday).format('YYYYMMDD');
		date.to.long=moment($nextday).format('ddd Do, MMM, YYYY');
		return date;

	}
	$scope.appDates=$scope.setDates()


	  $scope.addMoreDes=function(multi){

		  $scope.date=$scope.setDates()
		  $scope.addtionalDes=[
			  {name:'From', value:{name:''}, type:'place'},
			  {name:'To', value:{name:''}, type:'place'},
			  {name:'Depture Date', value: $scope.date.from, type:'date'}
		  ];
		  multi.push( $scope.addtionalDes)
	  }
	  $scope.searchForm={
		  Flights:{
			name:'Flights',
			typeBreak:[
				{
					name:'One Way',
					value:'OW',
					ref:'oneWay'
				},
				{
					name:'Return Ticket',
					value:'NF',
					ref:'retTic'
				},
				{
					name:'Multiple Destinations',
					value:'MF',
					ref:'mulTi'
				}
			],
			types:{
			  	oneWay:{
					0:{name:'From', value:{name:''}, type:'place'},
					1:{name:'To', value:{name:''}, type:'place'},
					2:{name:'Depture Date', value:$scope.appDates.from, type:'date', subType:'fromdate'}
				},
				retTic:{
					0:{name:'From', value:{name:''}, type:'place'},
					1:{name:'To', value:{name:''}, type:'place'},
					2:{name:'Depture Date', value:$scope.appDates.from, type:'date', subType:'fromdate'},
					3:{name:'Return Date', value:$scope.appDates.to, type:'date', subType:'todate'}
				},
				mulTi:{
					multCities:[
						[
							{name:'From', value:{name:''}, type:'place'},
							{name:'To', value:{name:''}, type:'place'},
							{
								name:'Depture Date',
								type:'date',
								subType:'fromdate',
								value:$scope.appDates.from
							}
						]
					]
				}
			},
			guestBreak:[
				{name:'Adult', value:1, type:'guest'},
  				{name:'Child', value:0, type:'guest'}
			],
			others:{
				0:{
					name:'Ticket Class',
					value:'all',
					type:'select',
					options:[
						{name:'All Classes',value:'all'},
						{name:'First Class Premium',value:'P'},
						{name:'First',value:'F'},
						{name:'Business',value:'C'},
						{name:'Economy Premium',value:'S'},
						{name:'Economy',value:'Y'}
					]
				}
			},
			current:'retTic'
		  },
		  Hotels:{
			  name:'Hotels',
			  types:{
				  	regular:{
						to:{}, depDate:{}, retDate:{}, room:{}
					}
				},
				guestBreak:[{Adult:{},Child:{}}]
		  },
		  Tours:{
			  name:'Tours',
			  types:{
				  regular:{
					  to:{}, depDate:{}, retDate:{}
				  }
			  },
			  guestBreak:[{Adult:{},Child:{}}]
		  },
		  Transfers:{}
	  }
	  $scope.defaultSearch={
		  module:'Flights',
		  moduleType:'NF',
		  moduleRef:'retTic'
	  }
	  $scope.currentSearch= $scope.searchForm.Flights;
	  $scope.currentProSearch = $scope.searchForm.Flights.types.retTic;
	  $scope.currentProGuest = $scope.searchForm.Flights.guestBreak;
	  $scope.currentProOthers= $scope.searchForm.Flights.others;

	  //searchinit
	  $scope.initSearch=function(){
		$scope.searchObject=$scope.searchForm[$scope.defaultSearch.module];
		$scope.defaultSearch.moduleCurrType=$scope.searchForm[$scope.defaultSearch.module].types[$scope.defaultSearch.moduleRef];
	  }
	  $scope.moduleChangeType=function(type){
		$scope.defaultSearch.moduleType=type.value;
		$scope.defaultSearch.moduleRef=type.ref;
		$scope.defaultSearch.moduleCurrType=$scope.searchForm[$scope.defaultSearch.module].types[$scope.defaultSearch.moduleRef];
		$scope.setlocators()
	  }
	  $scope.getData= searchData.data(); //getting the global search data in app.js


	  // get currency conversion rate
	    $scope.account={action:'log_reg'};

	    // $scope.rate=currencyData.data();
		// $scope.convF=$scope.rate[0].baseCurrency.currFrom;
		// $scope.convS=$scope.rate[0].baseCurrency.symbol;
		// $scope.convL=$scope.rate[1].currencyList;
		// for ($a=0; $a<4; $a++){
		// 	if($scope.rate[0].baseCurrency.currTo !=$scope.convL[$a].curr){
		// 		$scope.currentcur= apiProxy.query(
		// 			{url:'http://www.google.com/finance/converter?a=1&from='+$scope.convL[$a].curr+'&to='+$scope.rate[0].baseCurrency.currTo, index:$a},
		// 			function(currenrcur){
		// 				$scope.conver_rate=currenrcur[0].rate;	$scope.convL[currenrcur[0].index].rate=$scope.conver_rate
		// 			}
		// 		)
		// 	}
		// }
	  $scope.curr_search= currSearch.getSearch();
	  $scope.pickupType='select';
	  $scope.fclass='all';
	  $scope.destinationType='select';
	  $scope.tourType='transferOnly';
	  $scope.touroptions='toursO';
	  $scope.returnType='Y'
	  $scope.d_hr='10'
	  $scope.d_min='45'
	  $scope.t_hr='12'
	  $scope.t_min='45'
	  $scope.r_hr='11'
	  $scope.r_min='45'
	  $scope.hp_city='';
	  $scope.hd_city='';
	  $scope.returntrans=[{ name: 'Yes', value: 'Y' },{ name: 'No', value: 'N'}]
	  $scope.am_pm=[{ name: 'AM', value: '0' },{ name: 'PM', value: '12' }]
	  $scope.locationtype=[
		{ name: 'Select Type', value: 'select' },
		{ name: 'Terminal(Airport, Bus Station etc.)', value: 'Terminal' },
		{ name: 'Hotel', value: 'Hotel' }
	];
		jQuery("#transfer_complete_2").autocomplete({
			source: function(request, response) {$.getJSON("server/transfer_autocomplete.php", {term: request.term, type: $scope.destinationType, dest_code:$scope.curr_search.des }, response);},
			minLength: 3,
			select: function(event, ui) {
				var url = ui.item.id; var pla=ui.item.value;
				if(url != '#') {
					$scope.getData[4].TdropCode=url;  //setting the destination code from global search data in app.js
					$scope.getData[4].TdropTairName=pla;  //setting the destination description from global search data in app.js
					$scope.getData[4].TdropTcityName=$scope.hd_city;  //setting the destination description from global search data in app.js
					$scope.getData[4].TdropType=$scope.destinationType
				}
			},
			html: true, // optional (jquery.ui.autocomplete.html.js required)

		  // optional (if other layers overlap autocomplete list)
			open: function(event, ui) {
				jQuery(".ui-autocomplete").css("z-index", 1000);
			}
		});
		jQuery("#transfer_complete").autocomplete({
		source: function(request, response) {$.getJSON("server/transfer_autocomplete.php", {term: request.term, type: $scope.pickupType, dest_code:$scope.curr_search.dep }, response);},
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.getData[4].TpickCode=url;  //setting the destination code from global search data in app.js
				$scope.getData[4].TpickTairName=pla;  //setting the destination description from global search data in app.js
				$scope.getData[4].TpickTcityName=$scope.hp_city;  //setting the destination description from global search data in app.js
				$scope.getData[4].TpickType=$scope.pickupType
			}
		},
		html: true, // optional (jquery.ui.autocomplete.html.js required)

	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});

	$scope.setlocators=function(){

		jQuery(".placeSearch").autocomplete({
			source: $scope.curr_search.url,
			minLength: 3,
			select: function(event, ui) {
				var url = ui.item.id; var pla=ui.item.value;
				console.log($scope.defaultSearch.moduleCurrType);
				obj={}
				data=$(this).attr('name');
				if(isNaN(data)){
					console.log(data)
					data=data.split('|');
					console.log(data[0],data[1])
					obj=$scope.defaultSearch.moduleCurrType.multCities[data[0]][data[1]].value
					console.log(obj)
				}
				else{
					obj=$scope.defaultSearch.moduleCurrType[data].value
				}


				if(url != '#') {
					if($scope.curr_search.service!='Flights'){
						obj.code=url;  //setting the destination code from global search data in app.js
						obj.value=pla;  //setting the destination description from global search data in app.js
						$sour=$(this).attr('name');
						if($sour=='des'){ currSearch.setDes(url); $scope.hd_city=url; }
						else if($sour=='dep'){currSearch.setDep(url); $scope.hp_city=url; }
					}
					else{
						$f_des_air='LHR';
						obj.code=url[0];  //setting the destination code from global search data in app.js
						obj.value=pla;  //setting the destination description from global search data in app.js
						$sour=$(this).attr('name');
						// if($sour=='dep'){
						// 	$scope.dep_airp_code= url;  $scope.dep_airp_name=pla;
						// 	$scope.getData[0].fDepAirpCode=url[0];
						// 	$scope.getData[0].fDepAirpName=pla;
						// }
						// else{
						// 	data.code=url[0];  //setting the destination code from global search data in app.js
						// 	data.desc=pla;
						// 	$scope.des_airp_code=url; $scope.des_airp_name=pla;
						// 	$scope.getData[0].fDesAirpCode=url[0];
						// 	$scope.getData[0].fDesAirpName=pla;
						// }
					}
					console.log($scope.defaultSearch.moduleCurrType.multCities)
					$scope.$apply();
				}
			},

			html: true, // optional (jquery.ui.autocomplete.html.js required)

		  // optional (if other layers overlap autocomplete list)
			open: function(event, ui) {
				jQuery(".ui-autocomplete").css("z-index", 1000);
			}
		});
	}
	checkCookie();
	$scope.setlocators();
	function checkCookie() {
		var lSsearch=getCookie("getCentreUser");
		if (lSsearch != "") {
			userData.setData(JSON.parse(lSsearch))
			$scope.getUdata=userData.data();
			$scope.getUdata[0].status="Logged_in";
		}
		else{
			$scope.getUdata=userData.data();
		}
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

		//$scope.curr_search='Flights';
		$scope.updateSearch=function(newS, newU){
			if(newS!='Visa'){
				$scope.curr_search.service=newS;
				currSearch.setSearch(newS, newU);
				$location.path('/home');
				setlocators();
				$scope.currentProSearch=$scope.searchForm[newS];
				$scope.currentProGuest=$scope.currentProSearch.guestBreak
				if($scope.currentProSearch.current)$scope.currentProSearch=$scope.currentProSearch.types[$scope.currentProSearch.current]
				else{$scope.currentProSearch=$scope.currentProSearch.types.regular}
				console.log($scope.currentProSearch)
			}
			else{
				$scope.curr_search.service=newS; $location.path('/visa');
			}
		}

		//Get Bolg Feed
		 $scope.getBlog = blogRS.query({Burl:'http://blog.getcentre.com/?feed=json'},
		function(getB){
			//getB=JSON.parse(getB)
			$scope.blogs=getB;
			/*		 jQuery(getB).each(function () { // or "item" or whatever suits your feed
				var el = $(this);

				console.log("------------------------");
				console.log("title      : " + el.find("title").text());
				console.log("author     : " + el.find("author").text());
				console.log("description: " + el.find("description").text());
			});*/
			//console.log(getB)
		})
		$scope.getBimage=function(e, a){
			$scope.hsdet= blogImageRs.get({blog_code:a}, function(hsdet){ e.context.src=hsdet.det})
    	}


		//getLocaltour
		$scope.localTours=function(){
			$scope.getlt=ltours.query({limit:6}, function(getlt){
				console.log(getlt)
				$scope.localTs=getlt;
			})
		}
		$scope.subscribe=function(data){
			$scope.sub_message="Please wait...";
			console.log(data);
			$http({method:'GET', url:'server/subscriber.php?sub_email='+data}).then(function successCallback(response) {
			console.log(response);$scope.sub_message=response.data},
			function errorCallback(response){
			$scope.sub_message=response;
			})
		}

		//processes class for the tour section
		$scope.tourClasses=function(indexes){
			tClass = "tourPflow ";
			if(indexes < 5) tClass=tClass+"col-xs-9";
			if(indexes != 0) tClass=tClass+" col-md-6";
			else tClass=tClass+" col-md-12  pull-right"
			if(indexes== 1 || indexes==4) tClass=tClass+" tourPadLeft";
			else tClass=tClass+" tourPadRight";
			return tClass
		}
		//processes class for the search type section
		$scope.typeClasses=function(indexes, typeValue, allType, moduleType){
			tclass='';
			if(indexes == 0) tclass=tclass+"fonw";
			if(indexes == allType) tclass=tclass+" fret";
			if(moduleType == typeValue) tclass=tclass+" ftactive";
			return tclass
		}




		$scope.openRegister = function (accountA) {
			$scope.account.action=accountA;
			console.log($scope.account);
			var modalInstance = $modal.open({
			  templateUrl: 'template/register_user.html',
			  controller: 'registerModalInstanceCtrl',
			  //size: 'sm',
			  windowClass: 'register-modal-window',
			  resolve: {
				account: function () {
				  return $scope.account;
				}
			  }
			})
		}

		$scope.room=[[1,1,[]],[0,0,[]],[0,0,[]],[0,0,[]],[0,0,[]],[0,0,[]]];//gets the breakdown of each rooms
		$scope.rooms=[];
		$scope.t_num_days='01';
		$scope.nights='night';
		$scope.room_num=0;
		$scope.hotelSearchf={destination:''};

		$scope.fsearch_param={'adult':1, 'child':0, 'elder':0, 'infant':0}

		$scope.setfromdate=function(){ $( ".fromdate" ).focus();};
		$scope.settodate=function(){  $( ".todate" ).focus();};
		$scope.get_days=function(d_checkin, d_checkout){
			console.log(d_checkin+' '+d_checkout)
			var start = moment(d_checkin);
			var end = moment(d_checkout);
			var num= end.diff(start, "days");
			$scope.getData[1].htotalnight=num;
			if(num<10&&num>=1){num='0'+num;}
			if(num>1){$scope.nights='nights';}else{$scope.nights='night'}
			$scope.d_nights=num;
			return(num);
		}

		$scope.room_plus=function(){
		//$('.scroller_container').css({'height':'260px'});
		$scope.room_no = $scope.rooms.length+2;
		$scope.room_num++;
		$scope.getData[1].hTotalroom++
  		$scope.rooms.push({'adultid': 'adult'+$scope.room_no, 'childid':'child'+$scope.room_no,'label':'Room '+$scope.room_no, 'room_no':$scope.room_no-1});

	}
	$scope.class_change=function(fclass){
		$scope.getData[0].fClass=fclass;
	}

	$scope.room_minus=function(){
		if($scope.rooms.length!=0){
			$index= $scope.rooms.length-1;
			$scope.rooms.splice($index,1);
			$scope.room_num--;
			$scope.getData[1].hTotalroom--;
		}
	}

	$scope.setSearch=function(){
		$scope.getData[0].fsearch='Yes';
		$scope.defaultSearch.guest=$scope.currentProGuest;
		console.log($scope.currentProOthers);
		$scope.defaultSearch.others=$scope.currentProOthers;
		$scope.search=searchDatas.data();
		$scope.search.data=$scope.defaultSearch;
		if($scope.curr_search.service=='Hotels'){
			$scope.getData[1].hRoomBreak=$scope.room;
			$scope.getData[1].hsearch='Yes';
			// console.log($scope.getData[1])
			$location.path('/hotel/hotel_list');
		}
		else if($scope.curr_search.service=='Flights'){
			// $scope.getData[0].fPassBreak=$scope.room;
			// $scope.getData[0].fAdult=$scope.room[0][1];
			// $scope.getData[0].fChild=$scope.room[0][2].length;
			// $scope.getData[0].fSenior=$scope.fsearch_param.elder;
			// $scope.getData[0].fInfant=$scope.fsearch_param.infant;
			// $location.path('/flight/flight_list');
			console.log($scope.defaultSearch);
			$location.path('/flight/flight_list');
		}
		else if($scope.curr_search.service=='Tours'){
			$scope.getData[1].hsearch='Yes';
			$scope.getData[1].hRoomBreak=$scope.room;
			$location.path('tour/tour_list')
		}
		else{
			$scope.getData[1].hsearch='Yes';
			$scope.getData[1].hRoomBreak=$scope.room;
			$scope.getData[4].transfer_return=$scope.returnType;
			$scope.getData[4].TpickTime= $scope.t_hr+$scope.t_min; //setting default departing date
			$scope.getData[4].TdropTime= $scope.d_hr+$scope.d_min; //setting default departing date
			$location.path('/tours/transfer_list');
		}
	}
	}]);

app.controller('registerModalInstanceCtrl', ['$scope', '$rootScope', 'userData', '$modalInstance', 'account',  'registerUser', 'loginUserRs', function ($scope, $rootScope, userData, $modalInstance, account, registerUser, loginUserRs){
	$scope.reset = function(){$scope.user = angular.copy($scope.master);}
    $scope.reset();
	$scope.account=account;
	console.log($scope.account)
	$scope.login= function (login){
		$scope.loginD=loginUserRs.query({pass:login.password, email:login.email}, function(loginD){
			if(loginD[0].info!='error'){
				userData.setData(loginD[0]);
				//setCookie('AskMeUser',loginD[0], 30 )
				$scope.getUdata=userData.data();
				$scope.getUdata[0].status="Logged_in";
				$modalInstance.dismiss('cancel');
				$rootScope.$broadcast('logged-in');
				console.log($scope.getUdata)
			}
			else{
				$scope.login_error=loginD[0].error_message
			}

		})
	}
    $scope.ok = function (user) {
    $scope.regUser = registerUser.get({title:user.title, fname:user.fname, lname:user.lname, email:user.email, pass:user.password, phone:user.phone, date_birth:user.dbirth, con_add:user.caddress, city:user.city, state:user.state, postal_c:user.pcode, country:user.country, national:user.nationality, agent:user.agent },	function(regUser) {
	if($scope.regUser[0]=='o'){
		userData.setData(user);
		setCookie('getCentreUser',user, 30 )
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
	$scope.getUdata=userData.data();
	$scope.getUdata[0].status="Logged_in";
	$rootScope.$broadcast('logged-in');
	$modalInstance.dismiss('cancel');
	}
	})
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);
app.directive('dateFrom', function() {
	return function ($scope, element, attrs) {
		d=attrs.name
		element.datepicker({
			defaultDate: "",
			dateFormat:'dd MM yy',
			minDate:0,
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {

				console.log(d)
				if(isNaN(d)){
					dateObjectF=$scope.defaultSearch.moduleCurrType['2'].value
					console.log('NAN', $scope.defaultSearch.moduleCurrType['2'].value)
				}
				else{
					dateObjectF=$scope.defaultSearch.moduleCurrType.multCities[d][2].value;
				}
				console.log(dateObjectF)

				var minDate = $(this).datepicker('getDate');
				if(minDate) {minDate.setDate(minDate.getDate())}
				$(".todate").datepicker( "option", "minDate", minDate|| 1 );
				var dt=selectedDate.split(' ');
				dateObjectF.day = dt[0];  dateObjectF.month = dt[1];  dateObjectF.year = dt[2];
				dateObjectF.short= moment(selectedDate).format('YYYYMMDD');
				dateObjectF.long=moment(selectedDate).format('ddd Do, MMM, YYYY');
				$scope.d_checkin= moment(selectedDate).format('YYYY-MM-DD');//to calculate number of days
				if($scope.defaultSearch.moduleType=='NF'){
					$num=$scope.get_days($scope.d_checkin,$scope.d_checkout);
					dateObjectT.fTravelDays=$num;
				}
				$scope.$apply();
				$('.todate').focus()
			}
		});
	}
})

app.directive('dateTo', function() {
	return function ($scope, element, attrs) {

		element.datepicker({
			dateFormat:'dd MM yy',
			changeMonth: true,
			changeYear: false,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				dateObjectT=$scope.defaultSearch.moduleCurrType['3'].value
				$(".fromdate").datepicker( "option", "maxDate", selectedDate );
				var dt=selectedDate.split(' ');
				dateObjectT.day = dt[0]; dateObjectT.month = dt[1]; dateObjectT.year = dt[2];
				dateObjectT.short= moment(selectedDate).format('YYYYMMDD');
				dateObjectT.long=moment(selectedDate).format('ddd Do, MMM, YYYY');
				$scope.d_checkout= moment(selectedDate).format('YYYY-MM-DD'); //to calculate number of days
				if($scope.defaultSearch.moduleType=='NF'){
					$num=$scope.get_days($scope.d_checkin,$scope.d_checkout);
					dateObjectT.fTravelDays=$num;
				}
				$scope.$apply();
			}
      	});
	}
})

app.directive('tripBag', function() {
  return {
  	restrict:'E',
    templateUrl: 'template/trip_bag.html',
	controller: function($scope, $attrs, $element) {

	},
	replace:true
  };
});

app.directive('loading', function() {
  return {
    templateUrl: 'template/loading.html',
	controller: function($scope, $attrs, $element) {

	},
	replace:true
  };
});

app.directive('birthDate', function() {
	return function ($scope, element, attrs) {
		element.datepicker({
			dateFormat:'dd MM yy',
			changeMonth: true,
			changeYear: true,
			yearRange:"-140:-18",
			defaultDate:"-140y-m-d",
			numberOfMonths: 1,
			onClose: function( selectedDate ) {	 element.context.value=selectedDate; $scope.$apply(); }
     	});
	}
})
app.directive('birthDchild', function() {
	return function ($scope, element, attrs) {
		element.datepicker({
			dateFormat:'dd.mm.yy',
			changeMonth: true,
			changeYear: true,
			yearRange:"-12:-1",
			defaultDate:"-12y-m-d",
			numberOfMonths: 1,
			onClose: function( selectedDate ) {  element.context.value=selectedDate;
			 $scope.$apply();	}
     	});
	}
})
app.directive('blogImg', function($compile){
	return function (scope, element, attrs){
		scope.getBimage(element, attrs.blogcode)
	}
})
app.directive('revealer', function() {
    return {
        link: function(scope, element, attrs) {
            element.bind('click', function() {
               // element.parent().children().removeClass('clicked');
                element.siblings(".hideme").toggleClass("showme");
				element.children(".minus_ic").toggleClass("showme");
				element.children(".plus_ic").toggleClass("hideme");
            })
        },
    }
});



})
(window.angular);

// JavaScript Document
// last edited 01/08/2015
var flightList =  angular.module('flightList',  ['ui.bootstrap']);
flightList.controller('flightList', ['$scope', '$http', '$rootScope', 'fpriceFilter', 'searchDatas', 'flightListRs','flightListNextRs','$location', 'flightCheckRs', 'travelPackD','currencyData','$modal', '$route', '$filter', function($scope, $http, $rootScope, fpriceFilter, searchDatas, flightListRs, flightListNextRs, $location, flightCheckRs, travelPackD, currencyData, $modal, $route, $filter) {



	$scope.load_note=true;
	$scope.disabled=false;
	$rootScope.search=false;
	$scope.nullcounter=0;
	$scope.more=true;// controlls the display while more flight are being fetched.
	$scope.more_message="Loading Flights... Please wait";
	$scope.getData= searchDatas.data();
	$scope.filter={lp:null, hp:null};
	$scope.minP=null; $scope.maxP=null;
	$scope.minPrice=0; $scope.maxPrice=5000000000;
	$scope.airlineName=null
	$scope.sort="offerPrice";
	$scope.currData= currencyData.data();
	$scope.currData[0].baseCurrency.currFrom='NGN';
	$scope.fairline='All Airlines';
	$scope.fcabin='All Cabin';
	$scope.fstop='All';
	$scope.allFlights=[]
	$scope.foundAirports=[]
	$scope.allAirports=[]

	$scope.fduration='All Flight Duration';
	$scope.sidefilt={'stopover':{'depart':['All'], 'return':['All']}, 'airname':{'depart':['All Airlines'], 'return':['All Airlines']}, 'cabin':{'depart':['All Cabin'], 'return':['All Cabin']}, 'duration':{'depart':['All Flight Duration'], 'return':['All Flight Duration']}};
	$scope.sorting=	[{name:'Lowest Price', value:"offerPrice"},{name:'Highest Price', value:"-offerPrice"},{name:'Lowest Switch/Stopover', value:'flightList[0][0].details|stopover'},{name:'Higest Switch/Stopover', value:'-flightList[0][0].details|stopover'},{name:'Airline Name Asc.', value:'flightList[0][0].details.leg0["@carrierCodeDesc"]'},{name:'Airline Name Desc.', value:'-flightList[0][0].details.leg0["@carrierCodeDesc"]'}];
	$scope.priceMin = function (flight) { return parseFloat(flight.offerPrice) >= $scope.minPrice;  };
	$scope.priceMax = function (flight) { return parseFloat(flight.offerPrice) <= $scope.maxPrice;};
	//$scope.aName = function (flight) { return flight.aName.flightList[0][0].details.leg0['@carrierCodeDesc'] <= $scope.maxPrice;};
    $scope.applyfilter=function() {
        $scope.minPrice = $scope.minP;	if(($scope.maxP>0)&&($scope.maxP>$scope.minP)){$scope.maxPrice = $scope.maxP;}//filter for Price
		//if($scope.airlineName!=null){ $scope.aName.flightList[0][0].details.leg0['@carrierCodeDesc']=$scope.airlineName}
    };
	$scope.search_c = searchDatas.data();
	console.log($scope.search_c)


	if($scope.search_c.data==null)
	{
		console.log($scope.search_c)
		checkCookie();
	}
	else{
		$scope.search_c= $scope.search_c.data;
		// $scope.search_c=$scope.getData[0];

	//	console.log($scope.search_c, $scope.search_c.guest[0], $scope.search_c.guest[0].value)
		setCookie("Last_Search", JSON.stringify($scope.search_c), 30);
		setPassengers();
		getfirst();
	}
	function findAirport(code){
		var airPortDescription = $scope.foundAirports.filter((item)=> item.code==code)
		//if airport Bucket is empty and it's Airport's json hasn't be retrieved...
		if(airPortDescription.length == 0 && $scope.allAirports.lenght ==0){
			$http.get("js/lib/airports.json").success(function(response) {
				$scope.allAirports = response;

			});//get Airports Json
		}
		else if(airPortDescription.length == 0){
			airPortDescription = $scope.allAirports.filter(item=>{
				item.code==code;
			})
			$scope.foundAirports.push(airPortDescription)
			return airPortDescription;
		}
		return airPortDescription;


    }
	function setPassengers(){
		passDist=$scope.search_c.moduleCurrType[5];
		if($scope.search_c.moduleType=='MF'){
			passDist=$scope.search_c.moduleCurrType.q1;
		}
		$scope.passKids=passDist.subtypes[1];
		$scope.search_c.Adult=passDist.subtypes[0].value;
		$scope.search_c.Child=0;
		$scope.search_c.Infant=0;
		$scope.search_c.Child_ageDist='';
		$scope.c_a_d='';
		$scope.search_c.Infant_ageDist='';
		$scope.i_a_d='';
		if($scope.passKids.ages.length>0){
			$scope.search_c.Child=$scope.passKids.ages.length;
			$scope.search_c.Infant=0;
			for($a=0; $a<$scope.passKids.ages.length; $a++){
				age=$scope.passKids.ages[$a].value;
				var dif = moment().diff(moment(age, "DD.MM.YYYY"), "months");
				console.log(age,dif);
				if(dif>=24){
					if($scope.search_c.Child_ageDist!=''){
						$scope.search_c.Child_ageDist=$scope.search_c.Child_ageDist+','+age.substr(6)+ age.substr(3,2)+ age.substr(0,2);
						$scope.c_a_d=$scope.c_a_d +','+age;
					}
					else{
						$scope.search_c.Child_ageDist=age.substr(6)+ age.substr(3,2)+ age.substr(0,2);
						$scope.c_a_d=age;

					}
				}
				else{
					$scope.search_c.Child--;
					$scope.search_c.Infant++;
					if($scope.search_c.Infant_ageDist!=''){
						$scope.search_c.Infant_ageDist=$scope.search_c.Infant_ageDist+','+age.substr(6)+ age.substr(3,2)+ age.substr(0,2);
						$scope.i_a_d=$scope.i_a_d+age
					}
					else{$scope.search_c.Infant_ageDist=age.substr(6)+ age.substr(3,2)+ age.substr(0,2); $scope.i_a_d=age;}
				}
			}
		}
	}

	function refineflight(list){
		//for all the flights get thier details... flight legs etc.
		for(flight in list){
			flightDetails={flightList:[[]]}

			//get the type of flights
			flightInfo=list[flight].extra.adtFlightInfo;
			//I would've used outbound here to select for Oneway but P is before O
			if(flightInfo.inbound){
				flightDetails.type='RT'
				flightDetails.typeName="Return";

			}
			else {
				if(flightInfo.outbound){
					flightDetails.type='OW';
					flightDetails.typeName="One Way";
					//initialize the index
				}
				else{
					flightDetails.type='MT';
					flightDetails.typeName="Multiple Destinations";
					//initialize the index

				}
			}
			currentIndex=0
			index=0
			//particular to sabre... we need to re-organise the flight details object so as to match the flight legs and gap
			for(fdetails in flightInfo){
				//we won't be needing the person object and the lastTicketDate
				if(fdetails!='persons' && fdetails!='lastTicketDate'){
					//create a array everytime there is the search finds a 'leg0';
					//if(flightInfo[fdetails].leg0){
					if(flightDetails.type=='MT')
					{	//trying to get the flight index
						fdetailsRep=fdetails.replace('flight', '')
						index=fdetailsRep[0]; // the first letter after 'flight' has been removed i.e 'flight0', 'flight0TotalTime'
					}
					else{
						if(fdetails.indexOf('in')==0){	index=1;}
						else{	index=0;}
					}
					if((flightDetails.type=='MT' && index>currentIndex) || (flightDetails.type=='RT' && fdetails.indexOf('out')> -1 && flightDetails.flightList.length < 2)){
						flightDetails.flightList.push([]);
						//get the value of the current Index that was just created...
						currentIndex++;
					}
					//set up objects to be pushed to the new array created above
					flightContent={type:fdetails, details:flightInfo[fdetails]}
					//push the new object to the created array
					//console.log(flightContent, flightDetails);
					flightDetails.flightList[index].push(flightContent);
				}
			}
			//now lets add other important details to our flight objects.
			flightDetails.persons=flightInfo.persons;
			flightDetails.id=list[flight]['@id'];
			flightDetails.offerPrice=list[flight].brands.item.price
			flightDetails.tourOp=list[flight]['@tourOp']

			//lets push all this flight into the main render scope.
			$scope.allFlights.push(flightDetails);
		}
		console.log($scope.allFlights)
	}

	$scope.f_airline = function (list) {
		return(processfilter('All Airlines', list.flightList[0][0].details.leg0['@carrierCodeDesc'], $scope.fairline ))
	};
	$scope.f_cabin= function (list) {
		return(processfilter('All Cabin', list.flightList[0][0].details.leg0['@flightClassDesc'], $scope.fcabin ));
	};
	$scope.f_stop= function (list) {
		$stops=$filter('stopover')(list.flightList[0][0].details);
		return(processfilter('All', $stops, $scope.fstop ))
	}
	$scope.f_duration= function (list) {
		if( $scope.fduration=='All Flight Duration'){ return true}
		else{
			$fd=$scope.fduration.split(' ')[2];
			var durat=$filter('hrtomin')(list.flightList[0][1].details['@minutes']);
			durat=durat.split('hrs ')[0];
			if ($scope.fduration.split(' ')[0]=='Less'){
				if(parseInt(durat)< parseInt($fd)){return true}
			}
			else{
				if(parseInt(durat)> parseInt($fd)){return true}
			}
		}

	}
	function processfilter(defaultv, sobject, curscope){
		if( curscope==defaultv){ return true}
		else{	if(sobject==curscope){return true}	}
	}

	$scope.reloadRoute = function() {
		console.log($scope.getData[0]);
	    console.log($scope.search_c);
	    $scope.getData[0].fPassBreak=$scope.search_c.fPassBreak;
		var str = JSON.stringify($scope.getData[0]);
		setCookie("Last_Search", str, 30);
		$route.reload();
	}
	function setCookie(cname, cvalue, exdays) {
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
	           if (c.indexOf(name)==0){
				   return c.substring(name.length,c.length);
			   }
	    }
	    return "";
	}

	function checkCookie(){
		var lSsearch=getCookie("Last_Search");
	    if (lSsearch!=""){
	    	$scope.search_c = JSON.parse(lSsearch);
			console.log($scope.search_c.moduleCurrType[5])
			setPassengers();
			getfirst($scope.search_c);
	    }
	}
	//update Search
	function update(){
		$scope.Dest=$scope.search_c.fDesAirpName;
		f=$scope.search_c.fDepDate;
		t= $scope.search_c.fDesDate;
		var fdate = [f.slice(0, 4), f.slice(4,6), f.slice(6)].join(' ');
		$fday=moment(fdate).format('DD MMMM YYYY');
		$t= $fday.split(' '); $scope.f_day = $t[0];    $scope.f_month = $t[1];     $scope.f_year = $t[2];

		var tdate = [t.slice(0, 4), t.slice(4,6), t.slice(6)].join(' ');
		$tday=moment(tdate).format('DD MMMM YYYY');
		$dt= $tday.split(' ');	$scope.t_day = $dt[0];    $scope.t_month = $dt[1];     $scope.t_year = $dt[2];
	}
	function getfirst(){

	//	flidetails=JSON.stringify($scope.search_c);
		$scope.fList = flightListRs.save({f_det:$scope.search_c, c_dist:$scope.search_c.Child_ageDist, i_dist:$scope.search_c.Infant_ageDist},
		function(fList) {
			var top = $('#appLoader').position().top;
			console.log(top);
			window.scrollTo(0, top);
			$scope.list=[]; //where all the flight list will be added.
			$scope.total_flight=$scope.fList.response.count; //total number of all the flights found
			$scope.search_c.searchId=$scope.fList.searchID;
			console.log($scope.fList.response.ofr);
			//optimization code to populate the flight list, incase the internet is poor ...
			if($scope.total_flight<=10){
				//nullcounter helps to keep track of how many trials of optimization so we dont go into infinite loop...
				if($scope.total_flight==0 && $scope.nullcounter<5){ $scope.nullcounter++; getfirst(); }
				if($scope.total_flight==1){ $scope.list.push($scope.fList.response.ofr); $scope.load_note=false; }
				else{
					$scope.list=$scope.fList.response.ofr;
					$scope.load_note=false; $scope.nullcounter=0;
				}
				refineflight($scope.list)
			}
			else{$scope.list=$scope.fList.response.ofr;
				refineflight($scope.list)
				$scope.search_c.limit_count= $scope.list.length;
				$scope.load_note=false;
				retrieveAll();
			}
			//at this point all the filghts should have been retrieved

			//now lets find the lowest price
			$scope.flightcurr=$scope.list[0]['@operCurr'];
			//make the first flight the lowest price... fpriceFilter is an angular filter
			$scope.lowest_price=fpriceFilter($scope.allFlights[0].persons);
			//looping through all the flights again...
			for (property in $scope.allFlights){
				properti=$scope.allFlights[property];
				// send this particular flight for filtering.
				sidefilter(properti.flightList);
				var curr_price=fpriceFilter(properti.persons);
				if(curr_price<$scope.lowest_price){
					$scope.lowest_price=curr_price
				}
			}
		});
	}
	function fiternotpresent(arrayofcontent, newcontent){
		if(arrayofcontent.indexOf(newcontent)<0){
			arrayofcontent.push(newcontent);
		}
	}

	//sets up the filter search options
	function sidefilter(prop){
		var stops= $filter('stopover')(prop[0][0].details)// uses filter to cal the total values of stops for departure.
		var airname=prop[0][0].details.leg0['@carrierCodeDesc']
		var cclass=prop[0][0].details.leg0['@flightClassDesc']
		var durat=$filter('hrtomin')(prop[0][1].details['@minutes'])
		durat=durat.replace("hrs ", "."); durat=durat.replace("mins", "");
		var hd='';
		durat=Math.floor(durat);
		if(durat<3){hd='Less than 3 hours';}
		else if(durat<6){hd='Less than 6 hours';}
		else if(durat<9){hd='Less than 9 hours';}
		else if(durat<12){hd='Less than 12 hours';}
		else {hd='More than 12 hours';}
		fiternotpresent($scope.sidefilt.stopover.depart, stops)
		fiternotpresent($scope.sidefilt.airname.depart, airname)
		fiternotpresent($scope.sidefilt.cabin.depart, cclass)
		fiternotpresent($scope.sidefilt.duration.depart, hd)
		try{
			if(typeof(prop[1][0].details)=='object' && prop[1][0].type=='inbound'){
				var stops=$filter('stopover')(prop[1][0].details)
				var airname=prop[1][0].details.leg0['@carrierCodeDesc']
				var cclass=prop[1][0].details.leg0['@flightClassDesc']
				var durat=$filter('hrtomin')(prop[1][1].details['@minutes'])
				durat=durat.replace("hrs ", "."); durat=durat.replace("mins", "");
				fiternotpresent($scope.sidefilt.stopover.return, stops)
				fiternotpresent($scope.sidefilt.airname.return, airname)
				fiternotpresent($scope.sidefilt.cabin.return, cclass)
				fiternotpresent($scope.sidefilt.duration.return, hd)
			}
		}
		catch(e){

		}

	}
	function retrieveAll(){
	//   flidetails=JSON.stringify($scope.search_c);
		// $scope.search_c.searchId=$scope.search_id
		if($scope.more){
			$scope.fnList = flightListNextRs.save({f_det:$scope.search_c}, function(fnList) {
	  			try{
	  				$scope.total_flightn=$scope.fnList.response.ofr.length;
	  				$scope.search_c.limit_count=$scope.search_c.limit_count+parseInt($scope.total_flightn);

	  				$scope.list_next=$scope.fnList.response.ofr;
					if($scope.more){
						refineflight($scope.list_next)
		  				for (property in $scope.allFlights){
		  					properti=$scope.allFlights[property];
		  					// send this particular flight for filtering.
		  					sidefilter(properti.flightList);
		  					var curr_price=fpriceFilter(properti.persons);
		  					if(curr_price<$scope.lowest_price){
		  						$scope.lowest_price=curr_price
		  					}
		  				}
		  				console.log($scope.search_c.limit_count, $scope.total_flight)
		  				if($scope.search_c.limit_count < parseInt($scope.total_flight)){retrieveAll()}
		  				else{$scope.more=false;}
					}

	  			}
	  			catch(e){
	  				$scope.nullcounter++;
	  	            if($scope.nullcounter>6 ){
	  	                $scope.nullcounter=0;
	  	                $scope.more_message="Error fetching more flights...Please check your internet connection and try again.";
	  	                if($scope.list.length==0){
	  	                    getfirst();
	  	                }
	  	            }
	  	            else{retrieveAll()}}
	  			//$scope.height=$(document).find('.list_holder').innerHeight();
	  		})
		}


	}
  $scope.getCond=function(ofrcode, tourOp){

  	var code=ofrcode;
	console.log(code);
	$scope.search_c.tourOp=tourOp;
	var modalInstance = $modal.open({
		templateUrl: 'template/flight_condition.html',
		controller: 'conditionModalInstanceCtrl',
		size: 'lg',
		windowClass: 'condition-modal-window',
		resolve: {
			offer: function () {
			  return code;
			},
			search_c:function () {return $scope.search_c}
		}
	})
	}
	$scope.getStopovers=function(fleg, allstopovers){
		stopovers=[];
		gaps=fleg[2].details;
		for(a=0; a<allstopovers; a++){
			stops={}
			stp='leg'+a;
			gap='gap'+a;
			stops.airport=	'('+fleg[0].details[stp]['@desCode']+')'+fleg[0].details[stp]['@desDesc']+' '+(fleg[0].details[stp]['@desDescExt'] || '');
			stops.desTime=fleg[0].details[stp]['@desTime'];
			stops.desDate=fleg[0].details[stp]['@desDate'];
			stops.fclass=fleg[0].details[stp]['@flightClassDesc'];
			stops.fnumb=fleg[0].details[stp]['@flightNumber'];
			stops.fcarrier=fleg[0].details[stp]['@carrierCodeDesc'];
			stops.totaltime=fleg[2].details[gap]['@duration'];
			stops.flighttime=fleg[0].details[stp]['@durationTime'];
			console.log(stops)
			stopovers.push(stops);
		}
		return stopovers;
	}
  	$scope.setcode=function(ofrcode, ind){
		$scope.more=false;
		$scope.load_note=true;
		var offercode= ofrcode.target.attributes.id.value;
		var index= ofrcode.target.attributes.name.value;
		tourOp=$scope.allFlights[index].tourOp;
		console.log($scope.allFlights[index])
		fdetails={}
		flightTypeName=$scope.allFlights[index].typeName;
		flightType=$scope.allFlights[index].type;
		operPrice=$scope.allFlights[index].offerPrice;
		if($scope.allFlights[index].type=="OW"){
			fleg=$scope.allFlights[index].flightList[0];
			gaps=fleg[2].details;
			stopover=0;
			for (property in gaps){if(gaps.hasOwnProperty(property)){stopover++;}}
			outBg='leg'+stopover;
			fdetails.fstop=$scope.getStopovers(fleg, stopover);
			fdetails.carrier=fleg[0].details.leg0['@carrierCodeDesc'];
			fdetails.fnumber=fleg[0].details.leg0['@flightNumber']
			fdetails.depAirport='('+fleg[0].details.leg0['@depCode']+')'+fleg[0].details.leg0['@depDesc']+' '+(fleg[0].details.leg0['@depDescExt'] || '');
			fdetails.desAirport='('+fleg[0].details[outBg]['@desCode']+')'+fleg[0].details[outBg]['@desDesc']+' '+(fleg[0].details[outBg]['@desDescExt'] || '');
			fdetails.depTime=fleg[0].details.leg0['@depTime'];
			fdetails.desTime=fleg[0].details[outBg]['@desTime'];
			fdetails.fclass=fleg[0].details[outBg]['@flightClassDesc'];
			fdetails.ftotaltime=fleg[1].details['@minutes'];
			fdetails.flighttime=fleg[0].details[outBg]['@durationTime'];
			fdetails.depDate=fleg[0].details.leg0['@depDate'];
			fdetails.desDate=fleg[0].details[outBg]['@desDate'];
			fdetails.fname=fdetails.carrier+'('+fleg[0].details.leg0['@depDesc']+'->'+fleg[0].details[outBg]['@desDesc']+')';
			fdetails=[fdetails];
		}
		else{
			fdetails=[];
			for(des in $scope.allFlights[index].flightList){
				flight={};
				fleg=$scope.allFlights[index].flightList[des];
				gaps=fleg[2].details;
				stopover=0;
				for (property in gaps){if(gaps.hasOwnProperty(property)){stopover++;}}
				outBg='leg'+stopover;
				flight.fstop=$scope.getStopovers(fleg, stopover);
				flight.carrier=fleg[0].details.leg0['@carrierCodeDesc'];
				flight.fnumber=fleg[0].details.leg0['@flightNumber']
				flight.depAirport='('+fleg[0].details.leg0['@depCode']+')'+fleg[0].details.leg0['@depDesc']+' '+(fleg[0].details.leg0['@depDescExt'] || '');
				flight.desAirport='('+fleg[0].details[outBg]['@desCode']+')'+fleg[0].details[outBg]['@desDesc']+' '+(fleg[0].details[outBg]['@desDescExt'] || '');
				flight.depTime=fleg[0].details.leg0['@depTime'];
				flight.desTime=fleg[0].details[outBg]['@desTime'];
				flight.fclass=fleg[0].details[outBg]['@flightClassDesc'];
				flight.ftotaltime=fleg[1].details['@minutes'];
				flight.flighttime=fleg[0].details[outBg]['@durationTime'];
				flight.depDate=fleg[0].details.leg0['@depDate'];
				flight.desDate=fleg[0].details[outBg]['@desDate'];
				flight.fname=flight.carrier+'('+fleg[0].details.leg0['@depDesc']+'->'+fleg[0].details[outBg]['@desDesc']+')';
				fdetails.push(flight);
			}
		}

		priceBreakdown=$scope.allFlights[index].persons;
		// var findex= ofrcode.target.attributes.name.value;
		$scope.search_c.fOfferCode=offercode;
		console.log($scope.search_c)
		$guest= $scope.search_c.guest;
		if($scope.search_c.moduleType=='MF'){
			$guest=$scope.search_c.moduleCurrType.q1
		}
		$scope.fCheck = flightCheckRs.get({Adult:$guest.subtypes[0].value,Child:$scope.search_c.Child, Infant:$scope.search_c.Infant, operPrice:operPrice, fOfferCode:$scope.search_c.fOfferCode, inf_age:$scope.search_c.Infant_ageDist, chd_age:$scope.search_c.Child_ageDist, tourop:tourOp}, function(fCheck) {
		$scope.check=$scope.fCheck.response;
		$scope.search_c.lastOfferDate=$scope.check.forminfo.LastTicketDate.value;
		travel_pack={ product:'Sabre', productType:'Flight', flightType:flightType, flightTypeName:flightTypeName, Adult:$guest.subtypes[0].value, Child:$scope.search_c.Child, Child_ages:$scope.c_a_d,
			Infant:$scope.search_c.Infant, infant_ages:$scope.i_a_d, flightDetails:fdetails, fDepCode:$scope.search_c.fDepAirpCode, fDesCode:$scope.search_c.fDesAirpCode, fTravelDays:$scope.search_c.fTravelDays,
			fOfferCode:$scope.search_c.fOfferCode, Price:$scope.check.pricetotal['@price'], tourOp:tourOp, lastTicketDate:$scope.search_c.lastOfferDate, guest_details:null,  priceB:priceBreakdown, curr:$scope.flightcurr};
			console.log(travel_pack);
		travelPackD.setData(travel_pack)
		setCookie('travelPD', JSON.stringify(travelPackD.data()), 30)
		$location.path('/travel_pack');
	  });
  }

}]);

flightList.controller('conditionModalInstanceCtrl', ['$scope', '$modalInstance', 'offer','search_c', 'flightCondRs', function ($scope,  $modalInstance, offer,search_c, flightCondRs) {
	search_c.fOfferCode=offer;
	$scope.currentIndex=0;
	$scope.load_note=true;
	$scope.fnCond=flightCondRs.save({f_det:search_c}, function(fnCond){
		$scope.load_note=false;
		$scope.condition=$scope.fnCond.response;
		$scope.conditionz=$scope.condition.segments1;
		$scope.paragraph=$scope.conditionz.paragraphs.paragraph[0];
	});
	$scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
	    $('.scroller_container').jScrollPane();

	});
	$scope.activeClass=function(index){
		 var activeClass=( index===$scope.currentIndex)?'modal_h_active': '';
		 return activeClass;
	}
	$scope.change_flight=function(flight, index){
		$scope.currentIndex = index;
		$scope.conditionz=flight;
		$scope.paragraph=$scope.conditionz.paragraphs.paragraph[0];
	}
	$scope.change_rule=function(rule){
		$scope.paragraph=rule;

	}
	$scope.cancel = function () {  $modalInstance.dismiss('cancel');  };
}]);

flightList.directive('updateSearch', function() {
  return {
  	restrict:'E',
    templateUrl: 'template/update_search.html',
	controller: function($scope, $attrs, $element) {
		$scope.Dest=$scope.search_c.fDesAirpName;
		f=$scope.search_c.fDepDate;
		t= $scope.search_c.fDesDate;
		var fdate = [f.slice(0, 4), f.slice(4,6), f.slice(6)].join('/');
		$fday=moment(fdate).format('DD/MMMM/YYYY');
		$t= $fday.split('/'); $scope.f_day = $t[0];    $scope.f_month = $t[1];     $scope.f_year = $t[2];

		var tdate = [t.slice(0, 4), t.slice(4,6), t.slice(6)].join('/');
		$tday=moment(tdate).format('DD/MMMM/YYYY');
		$dt= $tday.split('/');	$scope.t_day = $dt[0];    $scope.t_month = $dt[1];     $scope.t_year = $dt[2];
	},
	replace:true
  };
});

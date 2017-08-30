// JavaScript Document

	getcentre.controller('otherPages', ['$scope','$rootScope','sendMailCRs', 'sendMailVRs', 'searchObject', 'travelPackD', '$location', function($scope, $rootScope, sendMailCRs, sendMailVRs, searchObject, travelPackD, $location) {
	//	$scope.curr_search.service='Others';
		//$scope.searchForm=searchObject.data();
		// $scope.defaultSearch.moduleCurrType=$scope.searchForm[$scope.defaultSearch.module].types.regular;
		console.log( $scope.defaultSearch);
		$scope.disabled=false;
		$rootScope.search=false;
		$scope.visa={title:'', office:'', travelingP:'', Dcountry:''}
		$scope.insurance={gender:'', status:'', purpose:'', group:''}
		$scope.titles=[
			{ name:'Choose an option', value:''},
			{ name:'Mr.', value:'Mr.'},
			{ name:'Mrs.', value:'Mrs.'},
			{ name:'Miss.', value:'Miss.'},
			{ name:'Dr.', value:'Dr.'},
			{ name:'Prof.', value:'Prof.'},
			{ name:'Engr.', value:'Engr.'}
		];
		$scope.offices=[
			{ name:'Select Preferable Office', value:''},
			{ name:'Ilorin', value:'Ilorin'},
			{ name:'Lagos', value:'Lagos'}
		];
		$scope.purpose=[
			{ name:'Select Purpose Of traveling', value:''},
			{ name:'Visiting', value:'Visiting'},
			{ name:'Tourism', value:'Tourism'},
			{ name:'Business', value:'Business'},
			{ name:'Education', value:'Education'},
			{ name:'Medical', value:'Medical'},
			{ name:'Others', value:'Others'}
		]
		$scope.countries=[
			{ name:'Select Destination Country', value:''},
			{ name:'United Arab Emirate (Dubai)', value:'United Arab Emirate (Dubai)'},
			{ name:'South Africa', value:'South Africa'},
			{ name:'United Kingdom', value:'United Kingdom'},
			{ name:'Turkey', value:'Turkey'},
			{ name:'United States', value:'United States'},
			{ name:'France', value:'France'},
			{ name:'Others', value:'Others'},
		]
		$scope.Gender=[
			{ name:'Select Your Gender', value:''},
			{ name:'Male', value:'Male'},
			{ name:'Female', value:'Female'}
		];
		$scope.Status=[
			{ name:'Select Your Status', value:''},
			{ name:'Married', value:'Married'},
			{ name:'Single', value:'Single'}
		];
		$scope.travelGroup=[
			{ name:'Select travel group', value:''},
			{ name:'Family', value:'Married'},
			{ name:'Companion', value:'Companion'},
			{ name:'Team', value:'Team'}
		];
		$scope.tPurpose=[
			{ name:'Select purpose of travel', value:''},
			{ name:'Vacation', value:'Vacation'},
			{ name:'Medical Treatment', value:'Medical Treatment'},
			{ name:'Training', value:'Training'},
			{ name:'Others', value:'Others'}
		];
		jQuery(".l_ele, ._ele").click(function(){
			$ele_name=jQuery(this).attr('name');
			$ele_dim=parseInt(jQuery('.content_abt').find("."+$ele_name).position().top);
			console.log($ele_dim)
			jQuery('.content_abt').animate({'top':'-'+$ele_dim},{duration:500})
		})
	$scope.getEstimate=function(){
		$scope.totalDays=$scope.defaultSearch.moduleCurrType[5].value.fTravelDays;
		rates =$scope.defaultSearch.moduleCurrType['days']
		for(rate in rates){
			if($scope.totalDays <= rate){
				console.log(rates[rate]);
				insurStart=$scope.defaultSearch.moduleCurrType[4].value;
				d1=new Date($scope.insurance.dbirth)
				d2= new Date(insurStart.day+ ' '+insurStart.month+' '+insurStart.year)
				$scope.insurance.age=d2.getFullYear() - d1.getFullYear();

				if($scope.insurance.age<72){
					$scope.insurance.cost=rates[rate].rate1.range
				}
				else if($scope.insurance.age <=75){
					$scope.insurance.cost=rates[rate].rate1.range2
				}
				else{
					$scope.insurance.cost=rates[rate].rate1.range3
				}
				return
			}
		}
	}
	$scope.sendInsurance=function(){

		travel_pack={ product:'Aiico', productType:'Insurance', insuranceDetails:$scope.insurance, Price:$scope.insurance.cost};
		travelPackD.setData(travel_pack)
		setCookie('travelPD', JSON.stringify(travelPackD.data()), 30)
		$location.path('/travel_pack');
	}
	$scope.sendC=function(contact){
		console.log(contact)
		$scope.notmessage='Sending Mail, Please wait...'
		$scope.sendM=sendMailCRs.get({fname:contact.fullname, email:contact.email, subject:contact.subject, message:contact.message},function(sendM){
			if(sendM[0]=='o'){$scope.notmessage='Your Message has been sent, we will get back to you soon.'	}
			else{$scope.notmessage='Error sending your Message, Please try again later.';}
		})
	}
	$scope.sendV=function(visa){
		$scope.notmessageV='Submitting Schedule, Please wait...'
		$scope.sendMc=sendMailVRs.get({title:visa.title, fname:visa.fname, lname:visa.lname, phone:visa.phone, email:visa.email, country:visa.Rcountry, schDate:visa.date, office:visa.office, purpose:visa.travelingP, destination:visa.Dcountry},function(sendMc){
			if(sendMc[0]=='o'){$scope.notmessageV='Your Schedule has been submitted, we will get back to you soon.'; $scope.visa={};	}
			else{$scope.notmessageV='Error Scheduling , Please try again later.';}
		})
	}
	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + cvalue + "; " + expires;
	}
}]);

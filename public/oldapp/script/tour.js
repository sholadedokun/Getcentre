// JavaScript Document
var tour =  angular.module('tour', ['ui.bootstrap']);
 tour.directive('onFinishRender', function ($timeout) {
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
tour.controller('tour', ['$scope', 'searchData', 'toursRs','$location', function($scope, searchData, toursRs, $location) {
  $scope.getData= searchData.data();
  $scope.tour=[];
  $scope.offer="";
  $scope.tour_atten=[1,[]];//gets the breakdown of each rooms
  $scope.adult_no= $scope.tour_atten[0];
  $scope.child_no= $scope.tour_atten[1].length;
  $scope.pickupType='select';
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
  $scope.returntrans=[{ name: 'Yes, Please', value: 'Y' },{ name: 'Don\'t Bother', value: 'N'}]
  $scope.am_pm=[{ name: 'AM', value: '0' },{ name: 'PM', value: '12' }]
  $scope.locationtype=[
    { name: 'Select Type', value: 'select' }, 
    { name: 'Terminal(Airport, Bus Station etc.)', value: 'Terminal' }, 
    { name: 'Hotel', value: 'Hotel' }
];

  $scope.setfromdate=function(){ $( "#s_date" ).focus();};
  $scope.settodate=function(){  $( "#e_date" ).focus();};
  
  
  //calculating the next 3 days
	$scope.f_tday=moment().add( 3, 'days').format('YYYYMMDD');
	$fday=moment().add( 3, 'days').format('DD/MMMM/YYYY');
	$scope.getData[22].valueData= $scope.f_tday; //setting default departing date
	$f= $fday.split('/');
	$scope.f_day = $f[0];    $scope.f_month = $f[1];     $scope.f_year = $f[2];
	$scope.fl_tday=moment().add( 3, 'days').format('ddd Do, MMM, YYYY');
	
	
	//calculating the next 4 days
	$scope.t_tday=moment().add( 4, 'days').format('YYYYMMDD');
	$nextday=moment().add( 4, 'days').format('DD/MMMM/YYYY');
	$scope.getData[23].valueData= $scope.f_tday; //setting default leaving date
	$t= $nextday.split('/');
	$scope.t_day = $t[0]; $scope.t_month = $t[1]; $scope.t_year = $t[2];
	$scope.tl_tday=moment().add( 4, 'days').format('ddd Do, MMM, YYYY');
  	
	$scope.setTourTransfer=function(touroptions){
		if(touroptions=='toursO'){$scope.getData[28]=$scope.tour_atten;  $location.path('/tours/globalTours');}
		if(touroptions=='transferO'){
			$scope.getData[28]=$scope.tour_atten; 
			$scope.getData[9].valueName=$scope.returnType; 
			$scope.getData[22].valueName= $scope.t_hr+$scope.t_min; //setting default departing date
			$scope.getData[23].valueName= $scope.d_hr+$scope.d_min; //setting default departing date
			$location.path('/tours/globalTransfer');}
	}
	
   $("#tour_complete").autocomplete({
		source: "server/hotel_autocomplete.php",
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.getData[20].valueData=url;  //setting the destination code from global search data in app.js
				$scope.getData[21].valueData=pla;  //setting the destination description from global search data in app.js
			}
		},	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
	$("#transfer_hd_complete").autocomplete({
		source: "server/hotel_autocomplete.php",
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.hd_city=url;
			}
		},	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
	$("#transfer_hp_complete").autocomplete({
		source: "server/hotel_autocomplete.php",
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.hp_city=url;
			}
		},	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
	
	$("#transfer_complete_2").autocomplete({
		source: function(request, response) {$.getJSON("server/transfer_autocomplete.php", {term: request.term, type: $scope.destinationType, dest_code:$scope.hd_city }, response);},
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.getData[8].valueData=url;  //setting the destination code from global search data in app.js
				$scope.getData[9].valueAirport=pla;  //setting the destination description from global search data in app.js
				$scope.getData[9].valueTown=$scope.hd_city;  //setting the destination description from global search data in app.js
				$scope.getData[9].valueCountry=$scope.destinationType;
			}
		},	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
   $("#transfer_complete").autocomplete({
		source: function(request, response) {$.getJSON("server/transfer_autocomplete.php", {term: request.term, type: $scope.pickupType, dest_code:$scope.hp_city }, response);},
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.getData[5].valueData=url;  //setting the destination code from global search data in app.js
				$scope.getData[6].valueAirport=pla;  //setting the destination description from global search data in app.js
				$scope.getData[6].valueTown=$scope.hp_city;  //setting the destination description from global search data in app.js
				$scope.getData[6].valueCountry=$scope.pickupType
			}
		},	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
  
}]);
tour.directive('tdateFrom', function() {
	return function (scope, element, attrs) {
		element.datepicker({
			defaultDate: "+1w",
			dateFormat:'dd/MM/yy',
			minDate:0,
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {  
				var minDate = $(this).datepicker('getDate');
				if(minDate) {minDate.setDate(minDate.getDate() + 1)}
				$( "#r_date" ).datepicker( "option", "minDate", minDate|| 1 );
				var dt=selectedDate.split('/');
				scope.f_day = dt[0];    scope.f_month = dt[1];     scope.f_year = dt[2];
				scope.getData[7].valueData= moment(selectedDate).format('YYYYMMDD');
				scope.getData[12].valueData=moment().format('ddd Do, MMM, YYYY');
				scope.d_checkin= moment(selectedDate).format('YYYY-MM-DD');
				$num=scope.get_days();
				scope.getData[11].valueData=$num;
				scope.$apply();
				$('#r_date').focus()
			}
		});
	}
})

tour.directive('tdateTo', function() {
	return function (scope, element, attrs) {
		element.datepicker({
			dateFormat:'dd/MM/yy',
			changeMonth: true,
			numberOfMonths: 3,
			onClose: function( selectedDate ) {
				$( "#d_date" ).datepicker( "option", "maxDate", selectedDate );
				var dt=selectedDate.split('/');
				scope.t_day = dt[0]; scope.t_month = dt[1]; scope.t_year = dt[2];
				scope.getData[10].valueData= moment(selectedDate).format('YYYYMMDD');
				scope.getData[13].valueData=moment().format('ddd Do, MMM, YYYY');
				scope.d_checkout= moment(selectedDate).format('YYYY-MM-DD');
				$num=scope.get_days();
				scope.getData[11].valueData=$num;
				scope.$apply();
			}			
      	});
	}
})
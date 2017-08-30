getcentre.config(function($routeProvider) {
	$routeProvider
		.when('/', {
			 templateUrl: 'views/home.html',
			 controller: 'mainController'
		 })
		.when('/about', {
			templateUrl: 'views/about.html',
			controller: 'otherPages'
		})
		.when('/support', {
			templateUrl: 'views/support.html',
			controller: 'otherPages'
		}).
		when('/flight/flight_list', {
			templateUrl: 'views/flight_list.html',
			controller: 'flightList'
		}).
		when('/hotel/hotel_list', {
			templateUrl: 'views/hotel_list.html',
			controller: 'hotelList'
		}).
		when('/hotel/hotel_details', {
			templateUrl: 'views/hotel_details.html',
			controller: 'hotelDetails'
		}).
		when('/Addguest', {
	        templateUrl: 'views/Add_guest.html',
	        controller: 'AddGuest'
      	}).
		when('/travel_pack', {
			templateUrl: 'views/travel_pack.html',
			controller: 'TravelPack'
		}).
		when('/tour/ltour/:id', {
		   templateUrl: 'views/ltour_details.html',
		   controller: 'ltourDetails'
		 }).
		when('/voucher', {
			templateUrl: 'views/voucher.html',
			controller: 'voucher'
		})
		.when('/contact', {
			templateUrl: 'views/contact.html',
			controller: 'otherPages'
		})
		.when('/payMentGateway', {
	        templateUrl: 'template/webpay.php',
	        controller: 'webpay'
	    })
		.when('/payMentConfirm', {
	        templateUrl: 'template/webpayConfirm.php',
	        controller: 'paymentConfirm'
	    });

});

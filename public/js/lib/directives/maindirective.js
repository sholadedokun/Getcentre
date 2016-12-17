getcentre.directive('footerBelow',function(){
	return {

		restric: 'E',
		templateUrl: 'views/footer.html',
		
	};
});

getcentre.directive('bookingEngine', function(){
	// Runs during compile
	return {
		restrict: 'E',
		templateUrl: 'views/booking.html',
		replace: true
	};
});
getcentre.config(function($routeProvider) {
	
	$routeProvider
			.when('/', { templateUrl: '../../views/home.html',controller: 'mainController'})
			.when('/about', {templateUrl: 'views/about.html', controller: ''})
			.when('/contact', {templateUrl: 'views/contact.html', controller: ''});
			
});
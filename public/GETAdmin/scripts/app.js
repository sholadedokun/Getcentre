angular.module('getcentreAdmin', [
    'ngResource', //used for the API requests
    'ngRoute', //used to route our app within pages
    'ngSanitize', //used in binding html codes to our view
    'ui.bootstrap' //used for the modals and tooltips
])

.config(function ($routeProvider,$locationProvider, $httpProvider) {
    //removes the hash in urls
    $locationProvider.hashPrefix('');
    //intercepts every API response
    $httpProvider.interceptors.push(function($q, $location) {
        return {
          response: function(response) {
            //continue if there is no error
            return response;
          },
          responseError: function(response) {
            // the error status is 401 'unauthorised' send the user to login page
            if (response.status === 401)
                $location.path('/login');
            return $q.reject(response);
          }
        };
    });
    $routeProvider
    .when('/', { //default view
      templateUrl: 'pages/home.html'
    })
    .when('/login', {
        templateUrl: 'pages/login.html',
        controller: 'loginController', //controller to use for the login view

    })
    .when('/users/:id', {
        templateUrl: 'pages/users.html',
        controller: 'userController', //controller to use for the login view

    })
    .when('/table', {
        templateUrl: 'pages/tables.html',
        controller: 'userController', //controller to use for the login view

    })
    .when('/userEdit/:id', {
        templateUrl: 'pages/userEdit.html',
        controller: 'userController', //controller to use for the login view

    })
    .when('/addAdmin/:id', {
      templateUrl: 'pages/dashboard.html',
      controller: 'dashboardController', //controller to use for the dashboard view
      controllerAs: 'dashboardCt',

      //resolve will take some action before actually routing the app to the desired page
      resolve: {
            //if resolved, 'data' is injected into the controller
            //userData and $route is injected into the resolve;
            data: function (userData, $route) {
                //$route will expose the sessionId we sent to the route through $route.current.params.id;
                return userData.checkLogin($route.current.params.id);
            }
        }
    })
    .otherwise({
        redirectTo: '/',
		access: { isFree: true}
      });
})
.run(function($rootScope, $location, userData, appActions) {
    $rootScope.user=userData.getData();
    var checkCookie=getCookie("getcentre_admin");

    if (checkCookie!=""){
	    $rootScope.user=JSON.parse(checkCookie);
        if($rootScope.user.sessionId){
            userData.saveData($rootScope.user);
        }

    }
    else{
       $location.path('/login');
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
    $rootScope.setCookie=function(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+d.toUTCString();
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }
    $rootScope.signOut=function(){
        //calls the API to Authenticate the user through the injected appActions factory
        var signOut=appActions.apiRequest('user/logout').get({sessionId:$rootScope.user.sessionId});

        //retrieves the promise for the API request with a success response
            signOut.$promise.then(function(data){

            //check if the response gotten is successful
            if(data.status=='success'){
                // expire the cokkie
                $rootScope.user={};
                $rootScope.setCookie("saved_cookie", '', 0);
                $location.path('/login')
            }
        },
        //if something goes wrong, this will handles it;
        function(err){
            alert('error occured!! please try again')

        }
        )
    }
})

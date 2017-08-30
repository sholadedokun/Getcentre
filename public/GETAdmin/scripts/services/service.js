angular.module('getcentreAdmin')
.service('userData', ['$rootScope', '$q', '$location', function($rootScope, $q, $location){
 var savedData =  {sessionId:'', email:'', password:''}
 return{
    //to verify if a user has been logged in or not using sessionId
    checkLogin:function(sessionId) {
        var authStatus = $q.defer();
        //if userData has been saved/logged in and the sessionId is same
        if(savedData.sessionId==sessionId){
            //resolve will set the saved userData to the $promise
            authStatus.resolve(savedData);
        }
        //if a user data as not been saved to the service before;
        else if(angular.equals(savedData, {})){
            //resolve will set the empty userData to the $promise
            authStatus.resolve(savedData);
        }
        // will reject the user, seems the user is trying to get the dashboard without being Authenticated;
        else{
            authStatus.reject();
            $location.path('/login')
        }
        return authStatus.promise;
    },
    //retrieves the saved userData
    getData:function() { return savedData; },
    // updates the userData and returns the saved data
    saveData:function(data){savedData=data; return savedData }
 }
}]);

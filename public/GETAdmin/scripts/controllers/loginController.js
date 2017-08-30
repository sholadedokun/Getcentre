angular.module('getcentreAdmin')
  .controller('loginController', ['$scope', '$rootScope', 'appActions', 'userData', '$location', function ($scope, $rootScope, appActions, userData, $location) {
    $scope.user=userData.getData();

    //function that logs Authenticates the user
    $scope.login=function(user){
        // cfpLoadingBar.start()
        console.log(user)
        $scope.user.email=user.email;
        $scope.user.password=user.password;
        // //using CryptoJS to hash the password so that it won't be readable when sniffed;
        $scope.user.password=CryptoJS.MD5($scope.user.password).toString();

        //revels and set notification for the user to wait.
        $scope.infoRev=true;
        $scope.info='Please wait...';

        //calls the API to Authenticate the user through the injected appActions factory
        $scope.getUser=appActions.apiRequest('GETAdmin/server/login.php').save($scope.user);

        //retrieves the promise for the API request with a success response
        $scope.getUser.$promise.then(function(data){
            // cfpLoadingBar.complete()

            //check if the response gotten is successful
            if(data.status=='success'){
                // save the user data into the userData service injected into the controller,
                // so we can retrieve it from any other controller.
                data.sessionId='wews';
                userData.saveData(data);
                $rootScope.user=data;

                $rootScope.setCookie("getcentre_admin", JSON.stringify(data), 1);
                //route the application to the Dashboard with the session attach as routeParameter
                //the session ID attached is used to gain access into the Dashboard page
                $location.path('/dashboard/'+data.sessionId)
            }
            else{
                $scope.info=data.error
            }

            user.userInfo=false;
        },
        //if something goes wrong, this will handles it;
        function(err){
            // cfpLoadingBar.complete()
            if(err.status=='401'){
                $scope.info="Wrong Username or Password... Please try again";
            }
        }
        )
    }
  }])

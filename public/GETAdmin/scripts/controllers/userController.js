angular.module('getcentreAdmin')
  .controller('userController', ['$scope', '$rootScope', 'appActions', 'userData', '$location', '$uibModal', function ($scope, $rootScope, appActions, userData, $location, $uibModal) {
    $scope.user=userData.getData();


    //calls the API to retrieve all the users
    $scope.getAllUsers=appActions.apiRequest('GETAdmin/server/getAllUser.php').query();

    //retrieves the promise for the API request with a success response
    $scope.getAllUsers.$promise.then(function(data){
        // cfpLoadingBar.complete()
        console.log(data)
        $scope.allUsersData=data;
    },
    //if something goes wrong, this will handles it;
    function(err){
        // cfpLoadingBar.complete()
        if(err.status=='401'){
            $scope.info="hoopss!!! something went wrong.";
        }
    }
    )

    //function that retrives all registered user

    $scope.editUser=function(index){
        userToEdit=$scope.allUsersData[index]
        var modalInstance = $uibModal.open({
          templateUrl: 'template/editUser.html',
          controller: 'editUserModalInstanceCtrl',
          size: 'lg',
          windowClass: 'modal-window',
          resolve:{
            userToEdit:userToEdit
          }
        })
        modalInstance.result.then(function (data) {
            $scope.userToEdit=data;
            //calls the API to update the user through the injected appActions factory
            $scope.getUser=appActions.apiRequest('GETAdmin/server/editUser.php').save($scope.userToEdit);

            //retrieves the promise for the API request with a success response
            $scope.getUser.$promise.then(function(data){
                // cfpLoadingBar.complete()
                //check if the response gotten is successful
                if(data[0]=='s'){
                    alert('User successfully update')
                }
                else{
                    alert('Error occured, user was not update')
                }

                user.userInfo=false;
            },
            //if something goes wrong, this will handles it;
            function(err){
                // cfpLoadingBar.complete()
                if(err.status=='401'){
                    alert('You do not have permission, user was not update')
                    return;
                }
                alert('Error occured, user was not update');
            }
            )
        }, function () {

        });
    }

  }])
  .controller('editUserModalInstanceCtrl', ['$scope', '$rootScope', '$uibModalInstance', 'userToEdit', function ($scope, $rootScope,  $uibModalInstance, userToEdit){
      $scope.user=userToEdit;
      $scope.sendEdit=function(){
          $uibModalInstance.close($scope.user);
      }
      $scope.cancel = function () {
          $uibModalInstance.dismiss('cancel');
      };
  }])

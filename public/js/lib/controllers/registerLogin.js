getcentre.controller('registerModalInstanceCtrl', ['$scope', '$rootScope', 'userData', '$modalInstance', 'account',  'registerUser', 'loginUserRs', function ($scope, $rootScope, userData, $modalInstance, account, registerUser, loginUserRs){
	$scope.reset = function(){$scope.user = angular.copy($scope.master);}
    $scope.reset();
	$scope.account=account;
	$scope.disabled=false;

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays*24*60*60*1000));
		var expires = "expires="+d.toUTCString();
		document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
	}

	$scope.login= function (login){
		$scope.disabled=true;
		$scope.login_error="Please wait...";
		$scope.loginD=loginUserRs.query({pass:login.password, email:login.email}, function(loginD){
			if(loginD[0].info=='Your account is not active... Please contact info@getcentre.com'){
				$scope.login_error=loginD[0].info;
			}
			else if(loginD[0].info!='error'){
				userData.setData(loginD[0]);
				$scope.getUdata=userData.data();
				$scope.getUdata[0].status="Logged_in";
				setCookie('getCentreUser',$scope.getUdata, 1 )
				$modalInstance.dismiss('cancel');
				$rootScope.$broadcast('logged-in');
				console.log($scope.getUdata)
			}
			else{
				$scope.login_error=loginD[0].error_message
				$scope.disabled=false;
			}

		})
	}
    $scope.register = function (user) {
	$scope.disabled=true;
	$scope.info="Please wait..."
	if(user.password != user.rpassword || user.password.length <6){
		if(user.password.length<6){
			$scope.info="Error: Your Password must be atleast six characters.";
		}
		else{
			$scope.info="Error: Your Password don't match!!";
		}
		$scope.disabled=false;
		return;
	}
    $scope.regUser = registerUser.get({title:user.title, fname:user.fname, lname:user.lname, email:user.email, pass:user.password, phone:user.phone, date_birth:user.dbirth, con_add:user.caddress, city:user.city, state:user.state, postal_c:user.pcode, country:user.country, national:user.nationality, agent:user.agent },	function(regUser) {
	if($scope.regUser.status=='success'){
		userData.setData(user);
		setCookie('getCentreUser',user, 1 )
		$scope.user=userData.data();
		$scope.user[0].status="Logged_in";
		$rootScope.$broadcast('logged-in');
		$modalInstance.dismiss('cancel');
	}
	else{
		if($scope.regUser.status=='User already exist'){
			$scope.info="Email already exist, please register with a new email.";
		}
		else{
			$scope.info="Error Registering, please try again.";
		}
		$scope.disabled=false;
	}
	})
  };
  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);

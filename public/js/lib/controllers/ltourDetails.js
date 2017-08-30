// JavaScript Document



getcentre.controller('ltourDetails', ['$scope', 'searchDatas', 'tourData', 'purchaseData', 'serviceAddRs','travelPackD', '$location', 'lptours','$modal', '$routeParams', 'ltours', '$route', function($scope, searchDatas, tourData,  purchaseData, serviceAddRs, travelPackD, $location, lptours, $modal, $routeParams, ltours, $route) {
	//$route.reload()
	$scope.disabled=false;
	$scope.id = $routeParams.id;
	$scope.getlt=ltours.query({limit:1, id:$scope.id}, function(getlt){
		$scope.eachtour=getlt[0];
		getPack()
	})

	function getPack(){
	  $scope.allpict= $scope.eachtour.all_pict.split(',');
	  $scope.alltour= $scope.eachtour.all_trips.split(',');
	  $scope.mainImageUrl = $scope.eachtour.pict;
	  $scope.setImage = function(imageUrl, ind) {      $scope.mainImageUrl = imageUrl;  $scope.curr_pic=ind+1  };
	  $scope.getalltour=function(){
		$scope.aptour=lptours.query({alltours:JSON.stringify($scope.alltour)}, function(getlpt){
			console.log(getlpt)
			$scope.all_l_tours=getlpt;
		})
	  }
	}
	$scope.openReserve = function (accountA) {
			$scope.reserve={};
			var modalInstance = $modal.open({
			  templateUrl: 'template/reserve_package.html',
			  controller: 'reserveModalInstanceCtrl',
			  //size: 'sm',
			  windowClass: 'register-modal-window',
			  resolve: {
				eachtour: function () {
				  return $scope.eachtour;
				}
			  }
			})
			}
}]);
getcentre.controller('reserveModalInstanceCtrl', ['$scope', '$modalInstance', 'eachtour', '$http', function ($scope, $modalInstance, eachtour, $http){
	$scope.eachtour=eachtour;
	$scope.res={};
    $scope.resP = function () {
	$scope.res.info='Please Wait, we are making your reservation.'
    $http({  url: '../server/reserve_tpack.php?user='+JSON.stringify($scope.res)+'&tour='+JSON.stringify(eachtour),   method: "GET" })
    .then(function(response) { $scope.eachtour.info="Tour Package is reserved."; $modalInstance.dismiss('cancel')
	},
    function(response) { // optional
    	$scope.res.info='Your reservation Failed... Please Try again Later.';
    });
  };

  $scope.cancel = function () {
    $modalInstance.dismiss('cancel');
  };
}]);

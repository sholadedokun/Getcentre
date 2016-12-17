getcentre.controller('mainController', ['$scope', function($scope){

	$scope.extra = "1";
	$scope.switch = "0";
	$scope.showtype = 0;

	$scope.flightClass = {};
	$scope.flights = {};

	$scope.flights.adultNum = 1;
	$scope.flights.kidNum = 0;

	$scope.increaseKid = [];

	$scope.kidYear = [];


	$scope.dropExtra = function(){
		console.log("Clicked me");
		console.log($scope.extra);
		console.log($scope.switch);
		$scope.extra = 0;
		$scope.switch = 0;
		console.log($scope.extra);
		console.log($scope.switch);
	}

	$scope.flightClass.flighttype = ['All Flight Classes','First Class','Busniess Class', 'Economy Class'];


	$scope.searchPress = function(){

		console.log($scope.flights);
		// console.log($scope.flights.kidYear);
	}

	$scope.addAdult = function(){
		$scope.flights.adultNum++;
	}
	

	$scope.sucstractAdult = function(){

		if ($scope.flights.adultNum > 1)
		$scope.flights.adultNum--;
	}

	$scope.addKid = function(){
		$scope.flights.kidNum++;

		$scope.increaseKid.push($scope.flights.kidNum);

		console.log($scope.increaseKid)
	}
	

	$scope.sucstractKid = function(){

		if ($scope.flights.kidNum > 0){
			$scope.flights.kidNum--;
			$scope.increaseKid.pop($scope.flights.kidNum);
		}
	}

	$scope.ways = function(){
		console.log("Show Time" + $scope.showtype)
		$scope.showtype = 1;
		console.log("Show Time" + $scope.showtype)
	}
}]);
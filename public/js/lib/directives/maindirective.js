getcentre.directive("footerBelow", function() {
	return {
		restrict: "E",
		templateUrl: "views/footer.html",
		controller: function($scope, $attrs, $element, $http) {
			$scope.subscribe = function(data) {
				console.log(data);
				$scope.sub_message = "Please wait...";
				$scope.subSubmit = true;
				$http({ method: "GET", url: "http://getcentre.com/apptest/server/subscriber.php?sub_email=" + data }).then(
					function successCallback(response) {
						$scope.subSubmit = false;
						console.log(response);
						$scope.sub_message = response.data;
					},
					function errorCallback(response) {
						$scope.subSubmit = false;
						$scope.sub_message = response;
					}
				);
			};
		}
	};
});

getcentre.directive("bookingEngine", function() {
	// Runs during compile
	return {
		restrict: "E",
		templateUrl: "views/booking.html",
		replace: true
	};
});
getcentre.directive("visaEngine", function() {
	// Runs during compile
	return {
		restrict: "E",
		templateUrl: "views/visa.html",
		controller: "otherPages"
	};
});
getcentre.directive("transferEngine", function() {
	return {
		restrict: "E",
		templateUrl: "views/transfer.html",
		controller: "otherPages"
	};
});
getcentre.directive("insuranceEngine", function() {
	// Runs during compile
	return {
		restrict: "E",
		templateUrl: "template/insurance.html",
		controller: "otherPages"
	};
});
getcentre.directive("a", function() {
	return {
		restrict: "E",
		link: function(scope, elem, attrs) {
			if (attrs.href == "" || attrs.href == "#") {
				elem.on("click", function(e) {
					e.preventDefault();
					return;
				});
			}
		}
	};
});
getcentre.directive("dateFrom", function() {
	return function($scope, element, attrs) {
		$scope.d = attrs.name;
		var monthsNum = parseInt(attrs.id.split("_")[1]);
		element.datepicker({
			defaultDate: "",
			dateFormat: "dd M yy",
			minDate: 0,
			changeMonth: true,
			numberOfMonths: monthsNum,
			onClose: function(selectedDate) {
				console.log($scope.d, selectedDate);
				if (isNaN($scope.d)) {
					d = $scope.d.split("|");
					d = d[0];
					dateObjectF = $scope.defaultSearch.moduleCurrType[d].value;
					console.log("NAN", d, $scope.d);
				} else {
					dateObjectF = $scope.defaultSearch.moduleCurrType.multCities[$scope.d][2].value;
				}

				var minDate = $(this).datepicker("getDate");
				if (minDate) {
					minDate.setDate(minDate.getDate());
				}
				$(".todate").datepicker("option", "minDate", minDate || 1);
				var dt = selectedDate.split(" ");
				dateObjectF.day = dt[0];
				dateObjectF.month = dt[1];
				dateObjectF.year = dt[2];
				dateObjectF.short = moment(selectedDate).format("YYYYMMDD");
				dateObjectF.long = moment(selectedDate).format("ddd Do, MMM, YYYY");
				$scope.d_checkin = moment(selectedDate).format("YYYY-MM-DD"); //to calculate number of days

				if ($scope.defaultSearch.moduleType == "NF" || $scope.defaultSearch.module == "Hotels") {
					d++;
					dateObjectT = $scope.defaultSearch.moduleCurrType[d].value;
					$scope.d_checkout = dateObjectT.year + "-" + dateObjectT.month + "-" + dateObjectT.day;
					//$scope.d_checkout=moment(dateObjectT.long).format('YYYY-MM-DD');
					$num = $scope.get_days($scope.d_checkin, $scope.d_checkout);
					dateObjectT.fTravelDays = $num;
				}
				$scope.$apply();
				if ($scope.defaultSearch.moduleType == "Insurance") $scope.getEstimate();
				$(".todate").focus();
			}
		});
	};
});

getcentre.directive("dateTo", function() {
	return function($scope, element, attrs) {
		$scope.d = attrs.name;
		var monthsNum = parseInt(attrs.id.split("_")[1]);
		console.log(attrs.id, attrs.id.split("_"));
		element.datepicker({
			dateFormat: "dd M yy",
			changeMonth: true,
			changeYear: false,
			numberOfMonths: monthsNum,
			onClose: function(selectedDate) {
				d = $scope.d.split("|");
				d = d[0];
				dateObjectT = $scope.defaultSearch.moduleCurrType[d].value;
				$(".fromdate").datepicker("option", "maxDate", selectedDate);
				var dt = selectedDate.split(" ");
				dateObjectT.day = dt[0];
				dateObjectT.month = dt[1];
				dateObjectT.year = dt[2];
				dateObjectT.short = moment(selectedDate).format("YYYYMMDD");
				dateObjectT.long = moment(selectedDate).format("ddd Do, MMM, YYYY");
				$scope.d_checkout = moment(selectedDate).format("YYYY-MM-DD"); //to calculate number of days
				if ($scope.defaultSearch.moduleType == "NF" || $scope.defaultSearch.module == "Hotels") {
					d--;
					dateObjectF = $scope.defaultSearch.moduleCurrType[d].value;
					$scope.d_checkin = dateObjectF.year + "-" + dateObjectF.month + "-" + dateObjectF.day;
					$num = $scope.get_days($scope.d_checkin, $scope.d_checkout);
					dateObjectT.fTravelDays = $num;
				}
				if ($scope.defaultSearch.moduleType == "Insurance") $scope.getEstimate();
				$scope.$apply();
			}
		});
	};
});

getcentre.directive("tripBag", function() {
	return {
		restrict: "E",
		templateUrl: "template/trip_bag.html",
		controller: function($scope, $attrs, $element) {},
		replace: true
	};
});

getcentre.directive("loading", function() {
	return {
		templateUrl: "template/loading.html",
		controller: function($scope, $attrs, $element) {},
		replace: true
	};
});

getcentre.directive("birthDate", function() {
	return function($scope, element, attrs) {
		element.datepicker({
			dateFormat: "dd MM yy",
			changeMonth: true,
			changeYear: true,
			yearRange: "-140:-18",
			defaultDate: "-140y-m-d",
			numberOfMonths: 1,
			onClose: function(selectedDate) {
				element.context.value = selectedDate;
				$scope.$apply();
			}
		});
	};
});
getcentre.directive("birthDchild", function() {
	return function($scope, element, attrs) {
		element.datepicker({
			dateFormat: "dd.mm.yy",
			changeMonth: true,
			changeYear: true,
			yearRange: "-12:-1",
			defaultDate: "-12y-m-d",
			numberOfMonths: 1,
			onClose: function(selectedDate) {
				element.context.value = selectedDate;
				$scope.$apply();
			}
		});
	};
});
getcentre.directive("blogImg", function($compile) {
	return function(scope, element, attrs) {
		scope.getBimage(element, attrs.blogcode);
	};
});
getcentre.directive("revealer", function() {
	return {
		link: function(scope, element, attrs) {
			element.bind("click", function() {
				// element.parent().children().removeClass('clicked');
				element.siblings(".hideme").toggleClass("showme");
				element.children(".minus_ic").toggleClass("showme");
				element.children(".plus_ic").toggleClass("hideme");
			});
		}
	};
});

getcentre.directive("runAfterRepeat", function(travelPackD) {
	return {
		link: function($scope, element, attrs) {
			if ($scope.$last) {
				// iteration is complete, do whatever post-processing
				// is necessary
				$scope.newAgentPrice();
			}
		}
	};
});

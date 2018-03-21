getcentre.controller("searchModalInstanceCtrl", [
	"$scope",
	"$rootScope",
	"$modalInstance",
	"defaultSearch",
	"currSearch",
	"searchDatas",
	"$location",
	"$route",
	function($scope, $rootScope, $modalInstance, defaultSearch, currSearch, searchDatas, $location, $route) {
		$scope.defaultSearch = defaultSearch;
		$scope.curr_search = currSearch.getSearch();
		$scope.setFromDate = function(eIndex) {
			jQuery(".fromdate")
				.get(eIndex)
				.focus();
		};
		$scope.setToDate = function(eIndex) {
			jQuery(".todate")
				.get(eIndex)
				.focus();
		};
		$scope.searchRevel = function() {
			$scope.searchInit = true;
		};
		$scope.get_days = function(d_checkin, d_checkout) {
			console.log("sadasd " + d_checkin + " " + d_checkout);
			var start = moment(d_checkin);
			var end = moment(d_checkout);
			var num = end.diff(start, "days");
			if (num < 10 && num >= 1) {
				num = "0" + num;
			}
			if (num > 1) {
				$scope.nights = "nights";
			} else {
				$scope.nights = "night";
			}
			$scope.d_nights = num;
			return num;
		};
		$scope.setlocators = function() {
			jQuery(".placeSearch").autocomplete({
				source: $scope.curr_search.url,
				minLength: 3,
				select: function(event, ui) {
					var url = ui.item.id;
					var pla = ui.item.value;
					obj = {};
					data = jQuery(this).attr("name");
					console.log($scope.defaultSearch, data);
					if (isNaN(data) && $scope.defaultSearch.module != "Transfers") {
						data = data.split("|");
						obj = $scope.defaultSearch.moduleCurrType.multCities[data[0]][data[1]].value;
					} else {
						obj = $scope.defaultSearch.moduleCurrType[data].value;
					}
					if (url != "#") {
						if ($scope.defaultSearch.module != "Flights") {
							obj.code = url; //setting the destination code from global search data in app.js
							obj.value = pla; //setting the destination description from global search data in app.js
							$sour = jQuery(this).attr("name");
							if ($sour == "to") {
								currSearch.setDes(url);
								$scope.hd_city = url;
							} else if ($sour == "from") {
								currSearch.setDep(url);
								$scope.hp_city = url;
							}
						} else {
							$f_des_air = "LHR";
							obj.code = url[0]; //setting the destination code from global search data
							obj.value = pla; //setting the destination description from global search data
							$sour = jQuery(this).attr("name");
						}
						$scope.$apply();
					}
				},

				html: true, // optional (jquery.ui.autocomplete.html.js required)

				// optional (if other layers overlap autocomplete list)
				open: function(event, ui) {
					jQuery(".ui-autocomplete").css("z-index", 1200);
				}
			});
		};
		$scope.setlocators();
		$scope.setSearch = function() {
			// $scope.disabled=true;
			$scope.search = searchDatas.data();
			$scope.search.data = $scope.defaultSearch;
			if ($scope.defaultSearch.module == "Hotels") {
				$scope.search.data.hsearch = true;
				if ($route.current.originalPath == "/hotel/hotel_list") {
					$route.reload();
				} else {
					$location.path("/hotel/hotel_list");
				}
			} else if ($scope.defaultSearch.module == "Flights") {
				$scope.defaultSearch.guest = $scope.defaultSearch.moduleCurrType["5"];
				$scope.search.data.fsearch = true;
				if ($route.current.originalPath == "/flight/flight_list") {
					$route.reload();
				} else {
					$location.path("/flight/flight_list");
				}
			} else if ($scope.defaultSearch.module == "Tours") {
				$scope.search.data.hsearch = true;
				if ($route.current.originalPath == "/tour/tour_list") {
					$route.reload();
				} else {
					$location.path("/tour/tour_list");
				}
			} else {
				console.log($scope.defaultSearch);
				$scope.search.data.tranferSearch = true;

				$location.path("/tours/transfer_list");
			}
		};
		$scope.cancel = function() {
			$modalInstance.dismiss("cancel");
		};
	}
]);

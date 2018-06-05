getcentre.controller("mainController", [
	"$scope",
	"$rootScope",
	"currSearch",
	"searchObject",
	"$modal",
	"isArrayFilter",
	"blogRS",
	"blogImageRs",
	"ltours",
	"$http",
	"searchDatas",
	"$location",
	"$route",
	"userData",
	function($scope, $rootScope, currSearch, searchObject, $modal, isArrayFilter, blogRS, blogImageRs, ltours, $http, searchDatas, $location, $route, userData) {
		$scope.searchForm = searchObject.data();
		$scope.user = userData.data();
		$rootScope.search = true;
		$scope.defaultSearch = { module: "Flights", moduleType: "NF", moduleRef: "retTic" };
		$scope.account = { action: "log_reg" };
		$scope.d_checkin;
		$scope.d_checkout;
		$scope.disabled = false;
		$scope.childAgeOptions = [{ value: 0, name: "0-11 Months" }, { value: 1, name: "1 Year" }];
		$scope.d_hr = "10";
		$scope.d_min = "45";
		$scope.t_hr = "12";
		$scope.t_min = "45";
		$scope.r_hr = "11";
		$scope.r_min = "45";
		$scope.hp_city = "";
		$scope.hd_city = "";
		$scope.returntrans = [{ name: "Yes", value: "Y" }, { name: "No", value: "N" }];
		$scope.am_pm = [{ name: "AM", value: "0" }, { name: "PM", value: "12" }];
		$scope.locationtype = [{ name: "Select Type", value: "" }, { name: "Terminal(Airport, Bus Station etc.)", value: "Terminal" }, { name: "Hotel", value: "Hotel" }];
		$scope.pickupType = "";
		$scope.airportList = [];
		$http.get("js/lib/allAirports.json").success(function(response) {
			$scope.allAirports = response;
		}); //get additional service Json
		for (var i = 2; i <= 17; i++) {
			$options = { value: i, name: i + " Years" };
			$scope.childAgeOptions.push($options);
		}
		$scope.setTransferlocators = function(transType) {
			console.log(transType);
			jQuery("#transfer_complete").autocomplete({
				source: "server/transfer_autocomplete.php?type=" + transType + "&dest_code=" + $scope.defaultSearch.moduleCurrType["0"].value.code,
				minLength: 3,
				select: function(event, ui) {
					data = jQuery(this).attr("name");
					var url = ui.item.id;
					var pla = ui.item.value;
					if (url != "#") {
						$scope.defaultSearch.moduleCurrType["0"][data].TCode = url; //setting the destination code from global search data in app.js
						$scope.defaultSearch.moduleCurrType["0"][data].TairName = pla; //setting the destination description from global search data in app.js
						// $scope.getData[4].TpickTcityName=$scope.hp_city;  //setting the destination description from global search data in app.js
						$scope.defaultSearch.moduleCurrType["0"][data].Type = transType;
					}
					$scope.$apply();
				},
				html: true, // optional (jquery.ui.autocomplete.html.js required)

				// optional (if other layers overlap autocomplete list)
				open: function(event, ui) {
					jQuery(".ui-autocomplete").css("z-index", 1500);
				}
			});
			jQuery("#transfer_complete_2").autocomplete({
				source: "server/transfer_autocomplete.php?type=" + transType + "&dest_code=" + $scope.defaultSearch.moduleCurrType["0"].value.code,
				minLength: 3,
				select: function(event, ui) {
					data = jQuery(this).attr("name");
					var url = ui.item.id;
					var pla = ui.item.value;
					if (url != "#") {
						$scope.defaultSearch.moduleCurrType["0"][data].TCode = url; //setting the destination code from global search data in app.js
						$scope.defaultSearch.moduleCurrType["0"][data].TairName = pla; //setting the destination description from global search data in app.js
						// $scope.getData[4].TpickTcityName=$scope.hp_city;  //setting the destination description from global search data in app.js
						$scope.defaultSearch.moduleCurrType["0"][data].Type = transType;
					}
					$scope.$apply();
				},
				html: true, // optional (jquery.ui.autocomplete.html.js required)

				// optional (if other layers overlap autocomplete list)
				open: function(event, ui) {
					jQuery(".ui-autocomplete").css("z-index", 1000);
				}
			});
		};
		$scope.searchAirports = function(index) {
			var searchTerm = $scope.defaultSearch.moduleCurrType[index].name.value;
			$scope.airportList[index] = $scope.allAirports.filter(function(item) {
				if (item.c.indexOf(searchTerm) >= 0 || item.n.indexOf(searchTerm) >= 0) {
					return { c: item.c, n: "(" + item.c + ") " + item.n };
				}
			});
		};
		$scope.searchRevel = function() {
			$scope.searchInit = true;
		};
		$scope.initSearch = function() {
			searchMac = document.getElementById("searchMachine");
			searchMac.style.display = "inline-block";
			$scope.searchObject = $scope.searchForm[$scope.defaultSearch.module];

			if ($scope.defaultSearch.moduleRef != "regular") {
				$scope.defaultSearch.moduleCurrType = $scope.searchForm[$scope.defaultSearch.module].types[$scope.defaultSearch.moduleRef];
				$scope.defaultSearch.others = $scope.searchForm[$scope.defaultSearch.module].others;
				console.log($scope.defaultSearch);
			} else {
				if ($scope.defaultSearch.module != "Visa") {
					$scope.defaultSearch.moduleCurrType = $scope.searchForm[$scope.defaultSearch.module].types.regular;
					$scope.defaultSearch.others = $scope.searchForm[$scope.defaultSearch.module].others;
				}
			}
		};
		$scope.typeClasses = function(typeValue, moduleType) {
			tclass = "btn";
			if (moduleType == typeValue) tclass = tclass + " selected";
			return tclass;
		};
		$scope.formPosition = function(input, inp) {
			var type;
			if (isArrayFilter(input)) type = "array";
			else type = input.type;
			dclass = "no-padding col-xs-18 col-md-6";
			if (!$scope.searchInit && input.name == "To") {
				dclass = "";
			}

			if (type === "date") {
				dclass = "no-padding col-xs-18 col-md-3 dateInput";
			} else if (type === "room") {
				dclass = "col-xs-18 no-padding col-md-5 clear";
			} else if (type === "guest") {
				dclass = "col-xs-18 col-md-3 guestCla";
				if (isArrayFilter(inp)) dclass = "col-md-7 col-xs-18 no-padidng guestCla";
			} else if (type === "array") {
				dclass = "col-md-18 no-padding";
				if (input[0][0].type == "guest") {
					dclass = "col-xs-18 col-md-9 no-padding";
				}
			} else if (input.name === "Destination") dclass = "col-xs-18 col-md-9 no-padding";

			return dclass;
		};
		$scope.tourClass = function(row, index) {
			classB = "col-md-9 small";
			if ((row == 1 && index == 0) || (row == 2 && index == 2)) {
				classB = "col-md-18 big";
			}
			return classB;
		};
		$scope.blogClass = function(row, index) {
			classB = "col-xs-18 col-sm-7 small post-small";
			if ((row == 1 && index == 0) || (row == 2 && index == 1)) {
				classB = "col-xs-18 col-sm-11 big_blog";
			}
			if (row == 2 && index == 2) {
				classB = classB + " nagMargin";
			}
			return classB;
		};

		$scope.addOccupancy = function(input) {
			if (input.name == "Child") {
				input.ages.push({ value: "" });
			}
			input.value++;
		};
		$scope.takeOccupancy = function(input) {
			if (input.value > 0) {
				if (input.name == "Adult" && input.value == 1) return;
				if (input.name == "Child" && input.ages.length > 0) input.ages.pop();
				input.value--;
			}
		};
		$scope.addRoom = function(input) {
			input.value++;
			roomObject = [{ name: "Adult", value: 1, type: "guest" }, { name: "Child", value: 0, type: "guest", ages: [] }];
			$scope.defaultSearch.moduleCurrType.occupancy.push(roomObject);
		};
		$scope.takeRoom = function(input) {
			if ($scope.defaultSearch.moduleCurrType.occupancy.length > 1) {
				input.value--;
				$scope.defaultSearch.moduleCurrType.occupancy.pop();
			}
		};
		$scope.menuClass = function(name) {
			if (name == $scope.defaultSearch.module) {
				return "selected";
			}
		};
		$scope.moduleChangeType = function(type) {
			$scope.defaultSearch.moduleType = type.value;
			$scope.defaultSearch.moduleRef = type.ref;
			$scope.defaultSearch.moduleCurrType = $scope.searchForm[$scope.defaultSearch.module].types[$scope.defaultSearch.moduleRef];
			$scope.setlocators();
		};
		$scope.removeDestination = function(ind, multi) {
			multi.splice(ind, 1);
		};
		$scope.updateSearch = function(newS, moduleType, moduleRef, newU) {
			$rootScope.search = true;
			$scope.defaultSearch = { module: newS, moduleType: moduleType, moduleRef: moduleRef };
			if (newS != "Visa") {
				currSearch.setSearch(newS, newU);
				$scope.setlocators();
			}
			$scope.initSearch();
		};

		$scope.setFromDate = function(eIndex) {
			console.log(eIndex, jQuery(".fromdate"));
			jQuery(".fromdate")
				.get(eIndex)
				.focus();
		};
		$scope.setToDate = function(eIndex) {
			jQuery(".todate")
				.get(eIndex)
				.focus();
		};

		$scope.addMoreDes = function(multi) {
			$scope.addtionalDes = [
				{ name: "From", value: { name: "" }, type: "place" },
				{ name: "To", value: { name: "" }, type: "place" },
				{ name: "Depture Date", value: {}, type: "date", subType: "fromdate" }
			];
			multi.push($scope.addtionalDes);
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

		//this function helps to get current dates from the front end
		$scope.setDates = function(type) {
			//todays transaction
			if (type.subType == "fromdate") {
				type.value.short = moment().format("YYYYMMDD");
				type.value.long = moment().format("ddd Do, MMM, YYYY");
				$tday = moment().format("DD MMM YYYY");
				$t = $tday.split(" ");
				type.value.day = $t[0];
				type.value.month = $t[1];
				type.value.year = $t[2];
			} else {
				//next day transaction
				$nextday = moment()
					.add(7, "days")
					.format("DD MMM YYYY");
				$n = $nextday.split(" ");
				type.value.day = $n[0];
				type.value.month = $n[1];
				type.value.year = $n[2];
				type.value.short = moment($nextday).format("YYYYMMDD");
				type.value.long = moment($nextday).format("ddd Do, MMM, YYYY");
			}
		};
		//retrieve the current Search url
		$scope.curr_search = currSearch.getSearch();

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
					jQuery(".ui-autocomplete").css("z-index", 1000);
				}
			});
		};
		$scope.setlocators();
		//retrieve Blogs
		$scope.getBlog = blogRS.query({ Burl: "http://blog.getcentre.com/?feed=json" }, function(getB) {
			$scope.blogs = getB;
		});
		//retrieve all localtours
		//getLocaltour
		$scope.localTours = function() {
			$scope.getlt = ltours.query({ limit: 6 }, function(getlt) {
				console.log(getlt);
				$scope.localTs = getlt;
			});
		};
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
				// $scope.getData[1].hsearch='Yes';
				// $scope.getData[1].hRoomBreak=$scope.room;
				// $scope.getData[4].transfer_return=$scope.returnType;
				// $scope.getData[4].TpickTime= $scope.t_hr+$scope.t_min; //setting default departing date
				// $scope.getData[4].TdropTime= $scope.d_hr+$scope.d_min; //setting default departing date
				$location.path("/tours/transfer_list");
			}
		};
		$scope.getBimage = function(e, a) {
			$scope.hsdet = blogImageRs.get({ blog_code: a }, function(hsdet) {
				e.context.src = hsdet.det;
			});
		};
		//account Actions
		$scope.openRegister = function(accountA) {
			$scope.account.action = accountA;
			var modalInstance = $modal.open({
				templateUrl: "template/register_user.html",
				controller: "registerModalInstanceCtrl",
				//size: 'sm',
				windowClass: "register-modal-window",
				resolve: {
					account: function() {
						return $scope.account;
					}
				}
			});
		};
		$scope.openSearch = function(type, mode, modeCode, url) {
			$scope.updateSearch(type, mode, modeCode, url);
			var modalInstance = $modal.open({
				templateUrl: "template/book_engine.html",
				controller: "searchModalInstanceCtrl",
				//size: 'sm',
				windowClass: "register-modal-window",
				resolve: {
					defaultSearch: function() {
						return $scope.defaultSearch;
					}
				}
			});
		};
		//animationClass
		$scope.mouseTB = function(state) {
			if (state == "in") {
				this.hoverState = true;
				console.log(angular.element(this).find(".black-out"));
			} else {
				this.hoverState = false;
			}
		};
	}
]);

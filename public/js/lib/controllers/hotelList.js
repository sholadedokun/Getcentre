// JavaScript Document
var hotelList = angular.module("hotelList", []);
hotelList.factory("hotel_room_allo", function($rootScope) {
	var room_allot = {};
	room_allot.data = [];
	room_allot.raw = []; //
	room_allot.prepForBroadcast = function(msg) {
		this.data = msg;
		this.broadcastItem();
	};
	room_allot.broadcastItem = function() {
		$rootScope.$broadcast("handleBroadcast");
	};
	return room_allot;
});
hotelList.directive("hotelDetail", function($compile) {
	return function(scope, element, attrs) {
		scope.getHdetails(element, attrs.hotelcode, attrs.hotelcat);
	};
});
hotelList.directive("hotelStarJuniper", function($compile) {
	return function(scope, element, attrs) {
		$stars = parseInt(attrs.rate) || 0;
		$ratehtml = "";
		for ($r = 0; $r < $stars; $r++) {
			$ratehtml = $ratehtml + ' <span class="icon-star"></span>';
		}
		element.context.innerHTML = $ratehtml;
	};
});
hotelList.directive("hotelStar", function($compile) {
	return function(scope, element, attrs) {
		$rateExe = "";
		if (attrs.rateex.indexOf("STAR") != -1 || attrs.rateex.indexOf("*") != -1) {
			$rate = attrs.rateex;
			$stars = parseInt($rate.substring(0, 1));
			var x = $rate.split(" ");
			$rateSup = x[x.length - 1];
			if (isNaN($stars)) {
				$stars = parseInt($rateSup.substring(0, 1));
				$rateExe = $rate.replace($rateSup, "");
			}
			//var n = $rateEx.split(" "); $rateE= n[n.length - 1];
			if ($rateSup.indexOf("STAR") == -1 && $rateSup.indexOf("*") == -1) {
				$rateExe = $rateSup;
			}
		} else {
			$stars = 0;
			$rateExe = attrs.rateex;
		}
		$ratehtml = "";
		for ($r = 0; $r < $stars; $r++) {
			$ratehtml = $ratehtml + ' <span class="icon-star"></span>';
		}
		$ratehtml = $ratehtml + "<span> " + $rateExe + "</span>";
		element.context.innerHTML = $ratehtml;
	};
});
hotelList.controller("hotelList", [
	"$scope",
	"$route",
	"searchDatas",
	"hotelData",
	"purchaseData",
	"travelPackD",
	"hotel_room_allo",
	"hotelShortDetailsRs",
	"currencyData",
	"$location",
	"hotelFprox",
	"hotelChain",
	"hotelContact",
	"$http",
	function($scope, $route, searchDatas, hotelData, purchaseData, travelPackD, hotel_room_allo, hotelShortDetailsRs, currencyData, $location, hotelFprox, hotelChain, hotelContact, $http) {
		$scope.load_note = true;
		$scope.search_c = searchDatas.data();
		$scope.search_c = $scope.search_c.data;
		$scope.currData = currencyData.data();
		$scope.travelPD = travelPackD.data();
		$scope.offer = "";
		$scope.filter = { lp: null, hp: null };
		$scope.minP = null;
		$scope.maxP = null;
		$scope.minPrice = 0;
		$scope.maxPrice = 5000000000;
		$scope.sort = "lowP";
		$scope.pInt = "All";
		$scope.pChain = "All";
		$scope.hClist = [];
		$scope.hotels = [];
		$scope.hotelList = [];
		$scope.hotels_total = 0;
		$scope.hotel_name = "";
		$scope.disabled = false;
		$scope.sessionId = moment().unix();
		travel_pack = {};
		$scope.sorting = [
			{ name: "Lowest Price", value: "lowP" },
			{ name: "Highest Price", value: "highP" },
			{ name: "Lowest Star Rating", value: "hotelCat['@shortname']" },
			{ name: "Higest Star Rating", value: "-hotelCat['@shortname']" },
			{ name: "Hotel Name Asc.", value: "hotelName" },
			{ name: "Hotel Name Desc.", value: "-hotelName" }
		];
		$scope.priceMin = function(hotel) {
			if (hotel.availRoom instanceof Array) {
				return parseFloat(hotel.availRoom[0].HotelRoom.Price.Amount) >= $scope.minPrice;
			} else {
				return parseFloat(hotel.availRoom.HotelRoom.Price.Amount) >= $scope.minPrice;
			}
		};
		$scope.priceMax = function(hotel) {
			if (hotel.availRoom instanceof Array) {
				return parseFloat(hotel.availRoom[0].HotelRoom.Price.Amount) <= $scope.maxPrice;
			} else {
				return parseFloat(hotel.availRoom.HotelRoom.Price.Amount) <= $scope.maxPrice;
			}
		};
		$scope.pOfInt = function(hotel) {
			if ($scope.pInt == "All") {
				return true;
			} else {
				for ($i = 0; $i < hotel.filter[0].length; $i++) {
					if (hotel.filter[0][$i] == $scope.pInt) {
						return true;
					}
				}
			}
		};
		$scope.pChainName = function(hotel) {
			if ($scope.pChain == "All") {
				return true;
			} else {
				for ($i = 0; $i < hotel.filter[1].length; $i++) {
					if (hotel.filter[1][$i] == $scope.pChain) {
						return true;
					}
				}
			}
		};
		$scope.hotelName = function(hotel) {
			if ($scope.hotel_name == "") {
				return true;
			} else {
				return hotel.HotelInfo.Name.toLowerCase().search($scope.hotel_name.toLowerCase()) > -1;
				//else{return false}
			}
		};
		$scope.reloadRoute = function() {
			setCookie("Last_Search", $scope.search_c, 30);
			$route.reload();
		};
		$scope.sortHotel = function(hotel) {
			if ($scope.sort == "lowP") {
				if (hotel.availRoom instanceof Array) {
					return parseFloat(hotel.availRoom[0].HotelRoom.Price.Amount);
				} else {
					return parseFloat(hotel.availRoom.HotelRoom.Price.Amount);
				}
			} else if ($scope.sort == "highP") {
				if (hotel.availRoom instanceof Array) {
					return -parseFloat(hotel.availRoom[0].HotelRoom.Price.Amount);
				} else {
					return -parseFloat(hotel.availRoom.HotelRoom.Price.Amount);
				}
			} else if ($scope.sort == "lowR") {
				return hotel.HotelInfo.Category["@shortname"];
			} else if ($scope.sort == "highR") {
				return "-" + hotel.HotelInfo.Category["@shortname"];
			} else if ($scope.sort == "lowN") {
				return hotel.HotelInfo.Name;
			} else if ($scope.sort == "highN") {
				return "-" + hotel.HotelInfo.Name;
			}
		};

		$scope.applyfilter = function() {
			$scope.minPrice = $scope.minP;
			if ($scope.maxP > 0 && $scope.maxP > $scope.minP) {
				$scope.maxPrice = $scope.maxP;
			}
		};

		if ($scope.search_c) {
			setCookie("Last_Search", $scope.search_c, 30);
			setCookie("travelPD", $scope.travelPD, 30);
		} else {
			$scope.search_c = checkCookie("Last_Search");
			$scope.travelPD = checkCookie("travelPD");
		}

		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
			var expires = "expires=" + d.toUTCString();
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(";");

			for (var i = 0; i < ca.length; i++) {
				var c = ca[i].trim();
				if (c.indexOf(name) == 0) {
					return c.substring(name.length, c.length);
				}
			}
			return "";
		}
		function checkCookie(cattype) {
			var lSsearch = getCookie(cattype);
			if (lSsearch != "") {
				return JSON.parse(lSsearch);
			} else {
			}
		}
		//update search
		$scope.Dest = $scope.search_c.moduleCurrType[0].value;
		f = $scope.search_c.moduleCurrType[1].value;
		t = $scope.search_c.moduleCurrType[2].value;

		$scope.f_day = f.day;
		$scope.f_month = f.month;
		$scope.f_year = f.year;
		$scope.t_day = t.day;
		$scope.t_month = t.month;
		$scope.t_year = t.year;

		//resolve Child's age to years
		for (room in $scope.search_c.moduleCurrType["occupancy"]) {
			for (guest in $scope.search_c.moduleCurrType["occupancy"][room]) {
				if ($scope.search_c.moduleCurrType["occupancy"][room][guest].name == "Child") {
					console.log($scope.search_c.moduleCurrType["occupancy"][room][guest].ages);
					for (age in $scope.search_c.moduleCurrType["occupancy"][room][guest].ages) {
						$scope.search_c.moduleCurrType["occupancy"][room][guest].ages[age].valueYear = moment().diff(
							moment($scope.search_c.moduleCurrType["occupancy"][room][guest].ages[age].value, "DD.MM.YYYY"),
							"years"
						);
					}
				}
			}
		}
		jQuery("#to_complete, #from_complete, #transfer_hp_complete, #transfer_hd_complete").autocomplete({
			source: "server/hotel_autocomplete.php",
			minLength: 3,
			select: function(event, ui) {
				var url = ui.item.id;
				var pla = ui.item.value;
				if (url != "#") {
					if ($scope.curr_search.service != "Flights") {
						$scope.Dest.code = url; //setting the destination code from global search data in app.js
						$scope.Dest.value = pla; //setting the destination description from global search data in app.js
						$sour = $(this).attr("name");
						if ($sour == "des") {
							currSearch.setDes(url);
							$scope.hd_city = url;
						} else if ($sour == "dep") {
							currSearch.setDep(url);
							$scope.hp_city = url;
						}
					} else {
						$f_des_air = "LHR";
						$sour = $(this).attr("name");
						if ($sour == "dep") {
							$scope.dep_airp_code = url;
							$scope.dep_airp_name = pla;
							$scope.getData[0].fDepAirpCode = url[0];
							$scope.getData[0].fDepAirpName = pla;
						} else {
							$scope.des_airp_code = url;
							$scope.des_airp_name = pla;
							$scope.getData[0].fDesAirpCode = url[0];
							$scope.getData[0].fDesAirpName = pla;
						}
					}
				}
			},

			html: true, // optional (jquery.ui.autocomplete.html.js required)

			// optional (if other layers overlap autocomplete list)
			open: function(event, ui) {
				jQuery(".ui-autocomplete").css("z-index", 1000);
			}
		});
		// $hotelSupplier=[{url:'server/hotelAvail_httpRQ.php?', suppler:'hotelbeds'}, {url:'server/hotelAvail_juniper_RQ.php?', supplier:'juniper'}];
		// $hotelSupplier = [{ url: "server/hotelAvail_httpRQ.php?", suppler: "hotelbeds" }];
		$hotelSupplier = [{ url: "server/hotelAvail_juniper_RQ.php?", supplier: "juniper" }];
		for (x = 0; x < $hotelSupplier.length; x++) {
			$http({
				method: "GET",
				url:
					$hotelSupplier[x].url +
					"hdescode=" +
					$scope.search_c.moduleCurrType[0].value.code +
					"&hcheckin=" +
					$scope.search_c.moduleCurrType[1].value.short +
					"&hcheckout=" +
					$scope.search_c.moduleCurrType[2].value.short +
					"&hRoomBreak=" +
					JSON.stringify($scope.search_c.moduleCurrType["occupancy"]) +
					"&sessionId=" +
					$scope.sessionId
			}).then(
				function successCallback(response) {
					$scope.hotelList = response.data.hotelList;
					if (response.data.total > 1) {
						$scope.hotels_total = $scope.hotels_total + parseInt(response.data.total);
						$scope.load_note = false;
						$scope.pagination($scope.hotelList);
					}
					$scope.currData[0].baseCurrency.currFrom = response.data.currency;
					try {
						room_count = $scope.hotels[0].availRoom[0].HotelOccupancy.RoomCount;
						$scope.lowest_price = $scope.hotels[0].availRoom[0].HotelRoom.Price.Amount;
					} catch (e) {
						room_count = $scope.hotels[0].availRoom.HotelOccupancy.RoomCount;
						$scope.lowest_price = $scope.hotels[0].availRoom.HotelRoom.Price.Amount;
					}
					var curr_price = 0;
					for (property in $scope.hotels) {
						//loop through the room_avail to get all room occupancies for this room
						if ($scope.hotels.hasOwnProperty(property)) {
							if ($scope.hotels instanceof Array) {
								var properti = $scope.hotels[property];
							} else {
								var properti = $scope.hotels;
							}
							var price = properti.availRoom;
							$scope.hClist.push(properti.hotelCode);
							// var pointOI={'pOI':[]};
							properti.filter = [[], [], []];
							if (price instanceof Array) {
								room_count = price[0].HotelOccupancy.RoomCount;
								//add 15% to the price of the hotel
								price[0].HotelRoom.Price.Amount = parseFloat(price[0].HotelRoom.Price.Amount) + parseFloat(price[0].HotelRoom.Price.Amount) * 0.15;
								curr_price = room_count * price[0].HotelRoom.Price.Amount;
							} else {
								room_count = price.HotelOccupancy.RoomCount;
								//add 15% to the original price
								price.HotelRoom.Price.Amount = parseFloat(price.HotelRoom.Price.Amount) + parseFloat(price.HotelRoom.Price.Amount) * 0.15;
								curr_price = room_count * price.HotelRoom.Price.Amount;
							}

							if (curr_price < $scope.lowest_price) {
								$scope.lowest_price = curr_price;
							}
						}
					}
					//hotelData.setData($scope.hotels);
					$scope.getProximity();
					$scope.getChain();
				},
				function errorCallback(response) {
					alert("error Occured");
				}
			);
		}
		$scope.pagination = function(data) {
			for (var s = 0; s < 40; s++) {
				if (data.length != 0) {
					var hotl = data.shift(); //removes the first in element in data and resets the head to index 0
					$scope.hotels.push(hotl);
				}
			}
		};
		//autoloading at the bottom of each Call.
		$(window).scroll(function() {
			if ($(window).scrollTop() + 10 >= $(document).height() - ($(window).height() + 2500)) {
				$scope.pagination($scope.hotelList);
				$scope.$apply();
			}
		});
		$scope.pushprophotels = function(index, hcode, value) {
			for (property in $scope.hotels) {
				if ($scope.hotels.hasOwnProperty(property)) {
					if ($scope.hotels instanceof Array) {
						var properti = $scope.hotels[property];
					} else {
						var properti = $scope.hotels;
					}
					if (properti.hotelCode == hcode) {
						properti.filter[index].push(value);
					}
				}
			}
		};
		$scope.getProximity = function() {
			$scope.hprox = hotelFprox.query({ hotelCodes: JSON.stringify($scope.hClist) }, function(hprox) {
				for (property in hprox) {
					//loop through the room_avail to get all room occupancies for this room
					if (hprox.hasOwnProperty(property)) {
						if (hprox instanceof Array) {
							var properti = hprox[property];
						} else {
							var properti = hprox;
						}
						$scope.pushprophotels(0, properti.hcode, properti.pofinterest);
					}
				}
			});
		};
		$scope.getChain = function() {
			$scope.hchain = hotelChain.query({ hotelCodes: JSON.stringify($scope.hClist) }, function(hchain) {
				for (property in hchain) {
					//loop through the room_avail to get all room occupancies for this room
					if (hchain.hasOwnProperty(property)) {
						if (hchain instanceof Array) {
							var properti = hchain[property];
						} else {
							var properti = hchain;
						}
						$scope.pushprophotels(1, properti.hcode, properti.hchainname);
					}
				}
			});
		};
		$scope.roomnum = 0;
		$scope.search_c.hAdult = 0;
		$scope.search_c.hChild = 0;
		for (property in $scope.search_c.moduleCurrType["occupancy"]) {
			if ($scope.search_c.moduleCurrType["occupancy"].hasOwnProperty(property)) {
				$scope.search_c.hAdult = $scope.search_c.moduleCurrType["occupancy"][property][0].value + $scope.search_c.hAdult;
				$scope.search_c.hChild = $scope.search_c.moduleCurrType["occupancy"][property][1].value + $scope.search_c.hChild;
			}
		}
		$scope.getHdetails = function(e, a, b) {
			$scope.hsdet = hotelShortDetailsRs.get({ hotel_code: a, cat_code: b }, function(hsdet) {
				e.context.innerHTML = hsdet.det;
				if (e.parent().find(".h_rate")[0].innerHTML == "") {
					e.parent().find(".h_rate")[0].innerHTML = hsdet.cat;
				}
			});
		};
		$scope.get_list = function(e, hcodes) {
			$scope.hClists = hcodes;
			$scope.hprox = hotelFprox.get({ hotelCodes: $scope.hClists }, function(hprox) {});
		};
		$scope.sethotels_details = function(code_token, index_num) {
			var json_str = JSON.parse($("#new_list").val());
			$hot = json_str[index_num];

			$hot.hotelCode = code_token.target.attributes.name.value;
			$hot.hotelName = code_token.target.attributes.hname.value;
			hotelData.setData($hot);
			$location.path("/hotel/hotel_details");
		};

		function getcustomer(room_break, tag) {
			$scope.cust = [];
			if (tag == "HotelBed") {
				var room_guests = room_break.HotelOccupancy.Occupancy.GuestList.Customer;
				if (Array.isArray(room_guests)) {
					var all_guest_det = [];
					total_guest = room_guests.length;
					for (c = 0; c < total_guest; c++) {
						guest_det = { cust_id: room_guests[c].CustomerId, cust_type: room_guests[c]["@type"], cust_age: room_guests[c].Age };
						all_guest_det.push(guest_det);
					}
					$scope.cust = all_guest_det;
					return $scope.cust;
				} else {
					guest_det = { cust_id: room_guests.CustomerId, cust_type: room_guests["@type"], cust_age: room_guests.Age };
					$scope.cust.push(guest_det);
					return $scope.cust;
				}
			} else {
				var ad_guests = room_break.HotelOccupancy.Occupancy.AdultCount;
				var ch_guests = room_break.HotelOccupancy.Occupancy.ChildCount;
				all_guest_det = [];
				for (g = 0; g < ad_guests + ch_guests; g++) {
					if (g < ad_guests) {
						guest_det = { cust_id: g, cust_type: "Adult", cust_age: "" };
					} else {
						guest_det = { cust_id: g, cust_type: "Child", cust_age: "6" };
					}
					all_guest_det.push(guest_det);
				}
				return all_guest_det;
			}
		}
		$scope.book_room = function(code_token, index_num, room_index) {
			$scope.load_note = true;
			var json_str = JSON.parse($("#new_list").val());
			$hot = json_str[index_num];
			$selected_rooms = [];
			if (Array.isArray($hot.availRoom)) {
				if (room_index == 0) {
					if ($scope.search_c.moduleCurrType[3].value < 2) {
						$selected_rooms[0] = $hot.availRoom[room_index];
					} else {
						for ($i = 0; $i < $scope.search_c.moduleCurrType[3].value; $i++) {
							for (property in $hot.availRoom) {
								//loop through the room_avail to get all room occupancies for this room
								if ($hot.availRoom.hasOwnProperty(property)) {
									var properti = $hot.availRoom[property];
									var occupants = properti.HotelOccupancy.Occupancy;
									if (occupants.AdultCount == $scope.search_c.moduleCurrType["occupancy"][$i][0].value && occupants.ChildCount == $scope.search_c.moduleCurrType["occupancy"][$i][1].value) {
										$selected_rooms.push(properti);
										break;
									}
								}
							}
						}
					}
				} else {
					$selected_rooms = room_index;
				} //because the available room is set to room index in this case
			} else {
				$selected_rooms.push($hot.availRoom);
			}
			$scope.purchaseD = purchaseData.data();
			$scope.purchaseT = "none";

			if ($hot.tag == "HotelBed") {
				if ($scope.purchaseD[0] != null) {
					$scope.purchaseT = $scope.purchaseD[0]["@purchaseToken"];
				}
				$bookurl = "server/serviceAdd_httpRQ.php";
				$bookD = jQuery.extend(true, [], $selected_rooms);

				for (var i = 0; i < $bookD.length; i++) {
					del = i.toString();
					delete $bookD[del].HotelRoom.Price;
				}
				hdata = {
					pToken: $scope.purchaseT,
					Availtoken: $hot.availToken,
					contractName: $hot.contractName,
					contractCode: $hot.contractCode,
					Guest: $scope.search_c.moduleCurrType["occupancy"],
					bookData: $bookD,
					DateFrom: $scope.search_c.moduleCurrType[1].value.short,
					Troom: $scope.search_c.moduleCurrType[3].value,
					ServiceType: "ServiceHotel",
					DateTo: $scope.search_c.moduleCurrType[2].value.short,
					hotelcode: $hot.hotelCode,
					destcode: $scope.search_c.moduleCurrType[0].value.code,
					sessionId: $scope.sessionId
				};
			} else {
				$bookurl = "server/hotel_book_rule_juniper.php";
				hdata = {
					hotel_code: $hot.hotelCode,
					check_in: $hot.dateFrom,
					check_out: $hot.dateTo,
					sequence_num: $hot.S_num,
					selected_room: $selected_rooms
				};
			}
			$http({ method: "Post", url: $bookurl, data: hdata }).then(function successCallback(response) {
				$scope.roomz = [];
				$scope.services = [];
				$scope.serv = [];
				if ($hot.tag == "HotelBed") {
					$scope.services = response.data.ServiceAddRS.Purchase.ServiceList.Service;
					if (Array.isArray($scope.services)) {
						for ($r = 0; $r < $scope.services.length; $r++) {
							if ($scope.services[$r]["@xsi:type"] == "ServiceHotel") {
								$scope.services[$r].availRoom = $scope.services[$r].AvailableRoom;
								$scope.serv.push($scope.services[$r]);
							}
						}
					} else {
						$scope.services.availRoom = $scope.services.AvailableRoom;
						$scope.serv.push($scope.services);
					}
					hotelData.setData($scope.serv);
				} else {
					if (Array.isArray($hot.availRoom)) {
						$scope.services = [];
						for ($r = 0; $r < $hot.availRoom.length; $r++) {
							// $scope.services[$r].availRoom = $scope.services[$r].AvailableRoom;
							// $scope.serv.push($scope.services[$r]);
							$hot.availRoom[$r].HotelRoom.CancellationPolicies = response.data;
							$scope.services[$r].availRoom = $hot.availRoom[$r];
							$scope.services[$r].TotalAmount = $hot.availRoom[$r].HotelRoom.Price.Amount;
							$scope.services[$r].Currency = $hot.currency;
							$scope.services[$r].HotelInfo = {};
							$scope.services[$r].HotelInfo.Code = $hot.hotelCode;
							$scope.serv.push($scope.services[$r]);
						}
					} else {
						$scope.services = {};
						$hot.availRoom.HotelRoom.CancellationPolicies = response.data;
						$scope.services.availRoom = $hot.availRoom;
						$scope.services.TotalAmount = $hot.availRoom.HotelRoom.Price.Amount;
						$scope.services.Currency = $hot.currency;
						$scope.services.HotelInfo = {};
						$scope.services.HotelInfo.Code = $hot.hotelCode;
						$scope.serv.push($scope.services);
					}
				}
				for ($a = 0; $a < $scope.serv.length; $a++) {
					if ($scope.serv[$a].HotelInfo.Code == $hot.hotelCode) {
						if (Array.isArray($scope.serv[$a].availRoom)) {
							console.log("yes mauliptle");
							for ($b = 0; $b < $scope.serv[$a].availRoom.length; $b++) {
								for ($g = 0; $g < $scope.serv[$a].availRoom[$b].HotelOccupancy.RoomCount; $g++) {
									$scope.cust = getcustomer($scope.serv[$a].availRoom[$b], $hot.tag);
									roomz = {
										board: $scope.serv[$a].availRoom[$b].HotelRoom.Board.$,
										roomtype: $scope.serv[$a].availRoom[$b].HotelRoom.RoomType.$,
										cancel: $scope.serv[$a].availRoom[$b].HotelRoom.CancellationPolicies,
										adultCount: $scope.serv[$a].availRoom[$b].HotelOccupancy.Occupancy.AdultCount,
										childCount: $scope.serv[$a].availRoom[$b].HotelOccupancy.Occupancy.ChildCount,
										roomCount: $scope.serv[$a].availRoom[$b].HotelOccupancy.RoomCount,
										price: $scope.serv[$a].availRoom[$b].HotelRoom.Price.Amount,
										guest_details: null,
										cust_det: $scope.cust
									};
									if ($hot.tag == "Juniper") {
										roomz.price = $scope.serv[$a].availRoom.HotelRoom.Price.Amount;
										roomz.ratePlan = $scope.serv[$a].availRoom.HotelRoom.RateCode;
										console.log(roomz);
									}
									$scope.roomz.push(roomz);
								}
							}
						} else {
							console.log("single", $scope.serv[$a].availRoom);
							for ($g = 0; $g < $scope.serv[$a].availRoom.HotelOccupancy.RoomCount; $g++) {
								$scope.cust = getcustomer($scope.serv[$a].availRoom, $hot.tag);
								roomz = {
									board: $scope.serv[$a].availRoom.HotelRoom.Board.$,
									roomtype: $scope.serv[$a].availRoom.HotelRoom.RoomType.$,
									cancel: $scope.serv[$a].availRoom.HotelRoom.CancellationPolicies,
									guest_details: null,
									cust_det: $scope.cust,
									adultCount: $scope.serv[$a].availRoom.HotelOccupancy.Occupancy.AdultCount,
									childCount: $scope.serv[$a].availRoom.HotelOccupancy.Occupancy.ChildCount,
									roomCount: $scope.serv[$a].availRoom.HotelOccupancy.RoomCount
								};
								if ($hot.tag == "Juniper") {
									roomz.price = $scope.serv[$a].availRoom.HotelRoom.Price.Amount;
									roomz.ratePlan = $scope.serv[$a].availRoom.HotelRoom.RateCode;
									console.log(roomz);
								} else {
									roomz.price = $scope.serv[$a].availRoom.HotelRoom.Price.Amount;
								}
								$scope.roomz.push(roomz);
							}
						}
						travel_pack = {
							product: $hot.tag,
							productType: "Hotel",
							Adult: $scope.search_c.hAdult,
							Child: $scope.search_c.hChild,
							hdesdesc: $scope.search_c.hdesdesc,
							hcheckin: $hot.dateFrom,
							hcheckout: $hot.dateTo,
							hcheckinL: $scope.search_c.moduleCurrType[1].value.long,
							hcheckoutL: $scope.search_c.moduleCurrType[2].value.long,
							imgurl: $hot.hotelImages[0],
							Name: $hot.hotelName,
							hRoom: $scope.search_c.moduleCurrType[3].value,
							Price: $scope.serv[$a].TotalAmount,
							guestBreak: $scope.roomz,
							total_nights: $scope.search_c.moduleCurrType[2].value.fTravelDays,
							hroomdist: $scope.search_c.moduleCurrType["occupancy"],
							ref: null,
							serviceRef: null,
							supplier: null,
							hotelCat: $hot.hotelCat
						};
					}
					if ($hot.tag == "HotelBed") {
						travel_pack.hStar = $hot.hotelCat.$;
						travel_pack.contractComment = $scope.serv[$a].ContractList.Contract.CommentList;
						travel_pack.Spui = $scope.serv[$a]["@SPUI"];
						travel_pack.purchaseToken = response.data.ServiceAddRS.Purchase["@purchaseToken"];
						travel_pack.currency = $scope.serv[$a].Currency["@code"];
						$scope.getC = hotelContact.query({ hotelCode: $scope.serv[$a].HotelInfo.Code }, function(getC) {
							travel_pack.hotelContact = getC[0];
							travelPackD.setData(travel_pack);
							setCookie("travelPD", travelPackD.data(), 30);
							$location.path("/travel_pack");
						});
					} else {
						travel_pack.hStar = $hot.hotelCat["@attributes"].Code;
						travel_pack.currency = $scope.serv[$a].Currency;
						travel_pack.Snum = $hot.S_num;
						travel_pack.hcode = $hot.hotelCode;
						travel_pack.destination = $hot.destination;
						travel_pack.position = $hot.position;
						travelPackD.setData(travel_pack);
						setCookie("travelPD", travelPackD.data(), 30);
						$location.path("/travel_pack");
					}
				}
			});
		};
	}
]);
hotelList.directive("roomType", function(hotel_room_allo) {
	return {
		restrict: "E",
		templateUrl: "template/hotel_rate.html",
		controller: function($scope, $attrs, hotel_room_allo) {
			$scope.$on("handleBroadcast", function() {
				$scope.room_all = hotel_room_allo.data;
			});
			$scope.roomTotalPrice = [0, 0, 0, 0, 0, 0, 0];
			roomboard($scope.room_all);
			function roomboard(room_all) {
				$scope.room_allo = [];
				$scope.guestBreak = [];
				room_all = JSON.parse(room_all);
				while ($scope.room_allo.push([]) < $scope.search_c.moduleCurrType[3].value);
				while ($scope.guestBreak.push([]) < $scope.search_c.moduleCurrType[3].value);
				for ($i = 0; $i < $scope.search_c.moduleCurrType[3].value; $i++) {
					// this loop create different array according to Occupancy in each room
					var ind = 0;
					for (property in room_all) {
						//loop through the room_avail to get all room occupancies for this room
						if (room_all.hasOwnProperty(property)) {
							if (room_all instanceof Array) {
								var properti = room_all[property];
							} else {
								var properti = room_all;
							}
							var occupants = properti.HotelOccupancy.Occupancy;
							if (occupants.AdultCount == $scope.search_c.moduleCurrType["occupancy"][$i][0].value && occupants.ChildCount == $scope.search_c.moduleCurrType["occupancy"][$i][1].value) {
								$scope.room_allo[$i].push(properti);
								ind++;
								if (ind == 1) {
									$scope.roomTotalPrice[$i + 1] = properti.HotelRoom.Price.Amount;
									$scope.guestBreak[$i] = properti;
								}
							}
						}
					}
				}
			}
			addtotal();
			function addtotal() {
				$scope.totalPrice = 0;
				for ($i = 1; $i < $scope.roomTotalPrice.length; $i++) {
					$scope.totalPrice = parseFloat($scope.totalPrice) + parseFloat($scope.roomTotalPrice[$i]);
				}
				$scope.roomTotalPrice[0] = $scope.totalPrice.toFixed(2);
				//$scope.$apply($scope.totalPrice);
			}
			function getObjects(obj, bval, rval, index) {
				objects = [];
				for (var i in obj) {
					if (!obj.hasOwnProperty(i)) continue;
					if (typeof obj[i] == "object") {
						try {
							if (obj[i].Board.$ == bval && obj[i].RoomType.$ == rval) {
								if (
									obj.HotelOccupancy.Occupancy.AdultCount == $scope.search_c.moduleCurrType["occupancy"][index][0].value &&
									obj.HotelOccupancy.Occupancy.ChildCount == $scope.search_c.moduleCurrType["occupancy"][index][1].value
								) {
									objects.push(obj);
								} else {
									objects = objects.concat(getObjects(obj[i], bval, rval, index));
								}
								//return obj;
							} else {
								objects = objects.concat(getObjects(obj[i], bval, rval, index));
							}
						} catch (e) {
							objects = objects.concat(getObjects(obj[i], bval, rval, index));
						}
					}
				}
				return objects;
			}
			$scope.get_room_type = function(type, boad, index) {
				$scope.roomtype = type;
				$scope.board = boad;
				$scope.att = getObjects($scope.room_allo, $scope.board, $scope.roomtype, index);
				$scope.guestBreak[index] = $scope.att[0];

				$scope.roomTotalPrice[index + 1] = $scope.att[0].HotelRoom.Price.Amount;
				addtotal();
			};
			$scope.get_room_board = function(type, boad, index) {
				$scope.roomtype = type;
				$scope.board = boad;
				$scope.att = getObjects($scope.room_allo, $scope.board, $scope.roomtype, index);
				$scope.guestBreak[index] = $scope.att[0];

				$scope.roomTotalPrice[index + 1] = $scope.att[0].HotelRoom.Price.Amount;
				addtotal();
			};
		}
	};
});
hotelList.directive("hotelspecroom", function($compile, hotel_room_allo) {
	return {
		link: function link($scope, element, attrs) {
			element.bind("click", function() {
				if (
					element
						.parent()
						.parent()
						.parent()
						.children(".view_all_boards").length
				) {
					$(".view_all_boards").remove();
				} else {
					$scope.room_all = attrs.roomz;
					$scope.ind = attrs.name;
					hotel_room_allo.prepForBroadcast($scope.room_all);
					$scope.$on("handleBroadcast", function() {
						$scope.room_all = hotel_room_allo.data;
					});
					var newElement = $compile("<room-type class='col-md-18 nopadding'></room-type>")($scope);
					element
						.parent()
						.parent()
						.parent()
						.append(newElement);
				}
				element
					.parent()
					.parent()
					.siblings(".hideme")
					.toggleClass("showme");
				element.children(".minus_ic").toggleClass("showme");
				element.children(".plus_ic").toggleClass("hideme");
			});
		}
	};
});

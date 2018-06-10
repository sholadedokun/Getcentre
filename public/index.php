<!DOCTYPE html>
<html ng-app="getcentre">
	<head>
		<title>GETCentre | Welcome</title>
		<meta charset="utf-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta name="description" content="Online Flight, Hotel, Tours and Transfer booking portal.">
	    <meta name="keywords" content="Book Flights, Book Hotels, Tickets, Book Tours, Visa, Reservations, Vacations, Nigeria, Lagos, Africa, London, Dubai, Transfers, Airport, Airline, Car Rental, Online, Website, Cheap, Getaways, Affordable, get, centre, grand, express, tours">
	    <meta name="author" content="Olushola Adedokun">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="css/index.min.css">
		<link rel="stylesheet" type="text/css" href="css/style.min.css">
		<link rel="stylesheet" type="text/css" href="css/style2.css">
		<link rel="stylesheet" type="text/css" href="css/media_query.min.css">
		<link rel="stylesheet" href="css/icon.css" type="text/css" />
		<link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Playfair+Display" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="fonts/fontawesome-webfont.woff">
		<link type="text/css"  rel="stylesheet" href="css/autocomplete.css">
		<link type="text/css"  rel="stylesheet" href="bower_components/getcentre/jquery-ui.css">
		<link rel="stylesheet" href="css/animate_angular.css" type="text/css" />
	</head>
	<body>
		<div class="container-fluid">
			<div class="row booke-area" ng-controller="mainController">
				<div class="col-xs-18">
					<div class="row hidden-md hidden-xs">
					<div class="col-md-3 col-xs-18 socials cage">
						<a href="https://www.facebook.com/getcentreapp/" target="_blank" class="fa fa-facebook" aria-hidden="true"></a>
						<a href="https://twitter.com/getcentre1" target="_blank" class="fa fa-twitter" aria-hidden="true"></a>
						<a href="https://www.linkedin.com/company/get-centre" target="_blank" class="fa fa-linkedin" aria-hidden="true"></a>
						<a href="https://plus.google.com/u/0/118132775185913832007" target="_blank" class="fa fa-google-plus" aria-hidden="true"></a>
					</div>
					<div class="col-md-4 col-xs-18 cage reach">
						<p>+234 8188025444<img src="img/whatsapp.png" width="20px" height="20px"/></br>
						+234 8188009911</br>+234 012916333</p>
					</div>
					<div class="col-md-4 cage col-xs-18 identity">
						<a href="#/"><img src="img/Logo.png" /></a>
					</div>
					<div class="col-md-3 col-xs-18 cage user-bag">
						<div class="col-xs-18 userName">
							<div ng-if="user[0].status=='Logged_in'" ng-bind="user[1].lname | limitTo:20"></div>
						</div>
						<span  ng-if="user[0].status!='Logged_in'" ng-click="openRegister('login')"><img src="img/profile.png" /></span>
						<span><img src="img/cart.png" /></span>
						<span ng-if="user[0].status=='Logged_in'" ng-click="logOut()" class="fa fa-sign-out signOut"></span>

					</div>
					<div class="col-md-4 col-xs-18 cage searches">
						<span><img src="img/search.png"> <p>search site</p></span>
					</div>
				</div>
				<div class="row">
					<nav class="navbar col-xs-18 navbar-default">
						<div class="web_back"></div>
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse"  ,-target="#navbar" aria-expanded="false" aria-controls="navbar">
							<span class="sr-only">Toggle navigation</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<div class="tab-top visible-xs-block">
							<div class="search_Item_title" ng-class="menuClass('Flights')" ng-click="openSearch('Flights', 'NF', 'retTic', 'server/flight_autocomplete.php')">
								<img src="img/flight.png" />
							</div>
							<div class="search_Item_title" ng-class="menuClass('Hotels')" ng-click="openSearch('Hotels',  '', 'regular', 'server/hotel_autocomplete.php')">
								<img src="img/hotels.png" />
							</div>
							<div class="search_Item_title" ng-class="menuClass('Tours')" ng-click="openSearch('Tours',  '', 'regular', 'server/hotel_autocomplete.php')">
								<img src="img/tours.png" />
							</div>
							<div class="search_Item_title" ng-class="menuClass('Transfers')" ng-click="openSearch('Transfers', '', 'regular', 'server/hotel_autocomplete.php')">
								<img src="img/transfer.png" />
							</div>
							<div class="search_Item_title" ng-class="menuClass('Visa')" ng-click="openSearch('Visa','','regular','')">
								<img src="img/visa.png" />
							</div>
							<div class="search_Item_title" ng-class="menuClass('Insurances')" ng-click="openSearch('Insurance','NF','regular','')">
								<img src="img/insurance.png" />
							</div>
						</div>
						<div class="row navbar-collapse collapse" id="navbar">
							<ul class="container linkage">
								<li class="col-xs-18"><a href="#/" class="selected">home</a></li>
								<li class="col-xs-18"><a href="#/about">about</a></li>
								<li class="col-xs-18"><a href="http://blog.getcentre.com" target="_blank">blog</a></li>
								<li class="col-xs-18"><a href="#/contact">contact</a></li>
								<li class="col-xs-18"><a ng-click="openRegister('login')">Agent / User </a></li>
								<li class="col-xs-18"><a ng-click="openRegister('register')">Register</a></li>
							</ul>
						</div>
					</nav>
					<div class="col-xs-18 hidden-xs hidden-md" ng-init="initSearch()">
						<!--booking engine -->
						<div class="container booking-e">
							<div class="row">
								<div class="col-xs-18 no-padding">
									<div class="col-xs-18 no-padding">
										<div class="tab-top">
											<div class="col-md-3" ng-class="menuClass('Flights')"  ng-click="updateSearch('Flights', 'NF', 'retTic', 'server/flight_autocomplete.php')">
												<p class="hidden-xs">flights</p>
												<span><img src="img/flight.png" /></span>
											</div>
											<div class="col-md-3"  ng-class="menuClass('Hotels')" ng-click="updateSearch('Hotels',  '', 'regular', 'server/hotel_autocomplete.php')" >
												<p class="hidden-xs">hotels</p>
												<span><img src="img/hotels.png" /></span>
											</div>
											<div class="col-md-3" ng-class="menuClass('Tours')"  ng-click="updateSearch('Tours',  '', 'regular', 'server/hotel_autocomplete.php')">
												<p class="hidden-xs">tours</p>
												<span><img src="img/tours.png" /></span>
											</div>
											<div class="col-md-3" ng-class="menuClass('Transfers')"   ng-click="updateSearch('Transfers', '', 'regular', 'server/hotel_autocomplete.php')">
												<p class="hidden-xs">transfers</p>
												<span><img src="img/transfer.png" /></span>
											</div>
											<div class="col-md-3" ng-class="menuClass('Visa')"  ng-click="updateSearch('Visa','','regular','')" >
												<p class="hidden-xs">visa</p>
												<span><img src="img/visa.png" /></span>
											</div>
											<div class="col-md-3" ng-class="menuClass('Insurances')" ng-click="updateSearch('Insurance','NF','regular','')"  >
												<p class="hidden-xs">insurance</p>
												<span><img src="img/insurance.png" /></span>
											</div>
										</div>									
									</div>
								</div>
								<div class="col-xs-18 hidden-xs hidden-sm">
									<div class="col-xs-18">
										<div class="tab-below  hideMe" id="searchMachine" ng-show="search">
											<div ng-if="defaultSearch.module!='Visa' && defaultSearch.module!='Insurance' && defaultSearch.module!='Transfers'">

												<div class="col-xs-18 hidden-xs trip-type booking-form" ng-show="searchInit" ng-if="defaultSearch.moduleType!='regular'">
													<div class="btn" ng-click="moduleChangeType(type)"  ng-repeat="type in searchObject.typeBreak"  ng-class="typeClasses( type.value, defaultSearch.moduleType)">
														<p ng-bind="type.name"></p>
													</div>
												</div>
												<div class="col-xs-18 visible-xs trip-type booking-form" ng-show="searchInit" ng-if="defaultSearch.moduleType!='regular'">
													<div class="col-xs-18" ng-click="moduleChangeType(type)"  ng-repeat="type in searchObject.typeBreak"  ng-class="typeClasses( type.value, defaultSearch.moduleType)">
														<p ng-bind="type.name"></p>
													</div>
												</div>
												<div ng-repeat="input in defaultSearch.moduleCurrType" ng-if="input!=''" ng-class="formPosition(input)">
													<div class="col-xs-18 no-padding going booking-form"  ng-if="input.type=='place' && !(input | isArray) && (input.name=='From' || input.name=='Destination' || searchInit)">
														<label class="" ng-bind="input.name"></label>
														<div class="clearfix visible-xs-block"></div>
														<div class="inputWrapper">
															<input type="text" class="placeSearcher"  placeholder="enter destination"  ng-change="searchAirports($index)" ng-model="input.value.name" ng-click="searchRevel()" name={{$index}} />
															<span ng-if="input.name=='From'" class="iconFlightFrom"></span>
															<span ng-if="input.name=='To'" class="iconFlightTo"></span>
															<ul class="airportList" id="airSearch{{$index}}" ng-if="input.value.name.length>1 ">
																<li ng-repeat="airport in airportList[$index] track by $index" data="{{airport.c}}" ng-click="selectAirport($parent.$index, airport)">
																	({{airport.c}}){{airport.n}}, {{airport.l}}
																</li>
															</ul>
														</div>
													</div>
													<div class="col-xs-18 booking-form bookingFormInput no-padding" ng-init="setDates(input)"  ng-if="input.type=='date' && !(input | isArray)">
														<input type="text" ng-if="input.subType=='fromdate'" data="dateFrom_3" name="{{$index}}|" class="fromdate datePickerDummy" date-from />
														<input type="text" ng-if="input.subType=='todate'"  data="dateto_3" name="{{$index}}|" class="todate datePickerDummy" date-to />
														<div class="dateContainer" ng-if="input.subType=='fromdate'" name="f"  >
															<div class="dateBreaker rborder" ng-click="setFromDate(0)" >
																<span ng-bind="input.value.day"></span>
																<span ng-bind="input.value.month"></span>
																<span ng-bind="input.value.year"></span>
															</div>
															<div class="iconContainer" ng-click="setFromDate(0)"><span  class="iconCalendar"></span></div>
														</div>
														<div class="dateContainer" ng-if="input.subType=='todate'"  name="f" >
															<div class="dateBreaker rborder" ng-click="setToDate(0)" >
																<span ng-bind="input.value.day"></span>
																<span ng-bind="input.value.month"></span>
																<span ng-bind="input.value.year"></span>
															</div>
															<div class="iconContainer" ng-click="setToDate(0)"><span  class="iconCalendar"></span></div>
														</div>
													</div>
													<div class="col-xs-18  no-padding"  ng-if="input.type=='occupancy' && !(input | isArray) && searchInit">
														<div class="col-xs-18 no-padding booking-form col-md-9" ng-repeat="guest in input.subtypes">
															<div class="col-xs-18 people-side">
																<div class="col-xs-6 increaser">
																	<p class="plus" ng-click="addOccupancy(guest)">+</p>
																	<p class="plus" ng-click="takeOccupancy(guest)">-</p>
																</div>

																<div class="col-xs-6 anum"><p class="apush" ng-bind="guest.value | custNo"></p></div>
																<div class="col-xs-6"><p class="apush" ng-bind="guest.name"></p></div>
															</div>
															<div class="col-xs-18 nopadding" ng-if="guest.name=='Child' && guest.ages.length > 0">
																<div class="col-xs-18 nopadding" ng-repeat="childAge in guest.ages">
																	<span class="col-xs-18 nopadding child_select"><label>Child {{$index+1}}</label></span>
																	<div class="get_input col-xs-18">
																		<input type="text" ng-model="childAge.value" class="form-control trans_input_sm input-sm" placeholder="Date of Birth" birth-dchild >
																	</div>
																	<!-- <select class="" ng-model="childAge.value" required="required" ng-options="option.value as option.name for option in childAgeOptions" ></select> -->
																</div>
															</div>
														</div>
													</div>

													<div class="col-xs-18 booking-form no-padding"  ng-if="input.type=='room' && !(input | isArray) && searchInit">
														<div class="col-xs-18 people-side">
															<div class="col-xs-6 increaser">
																<p class="plus" ng-click="addRoom(input)">+</p>
																<p class="plus" ng-click="takeRoom(input)">-</p>
															</div>
															<div class="col-xs-6 anum"><p class="apush" ng-bind="input.value | custNo"></p></div>
															<div class="col-xs-6"><p class="apush" ng-bind="input.name">Rooms</p></div>
														</div>
													</div>
													<!-- <div class="col-md-2 arrow booking-form no-padding"  ng-if=" input.type=='date' && input.subType=='todate' && !(input | isArray)">&rarr;</div> -->
													<div ng-if="input | isArray" class="col-xs-18 no-padding">
														<div ng-repeat="inp in input track by $index" class="col-xs-18 no-padding">
															<div ng-if="defaultSearch.module=='Flight'" class="clearfix visible-xs-block desCounter" >
																<span>Destination </span>
																<span ng-bind="$index+1" class="destNum"></span>
															</div>
															<div  ng-repeat="form in inp track by $index" ng-class="formPosition(form, input)">
																<div class="col-xs-18 no-padding going booking-form"  ng-if="form.type=='place'" ng-show="form.name=='From' || searchInit" >
																	<label ng-bind="form.name"></label>
																	<div class="inputWrapper">
																		<input type="text" class="placeSearcher" placeholder="enter destination"  ng-init="setlocators()" ng-model="form.value.name" ng-click="searchRevel()" ng-change="searchAirports($index, $parent.$parent.$parent.$index)" name="{{$parent.$parent.$index}}|{{$index}}" />
																		<ul class="airportList" id="airSearch{{$index}}" ng-if="form.value.name.length>1 ">
																			<li ng-repeat="airport in airportList[$index] track by $index" data="{{airport.c}}" ng-click="selectAirport($parent.$index, airport, $parent.$parent.$parent.$parent.$index)">
																				({{airport.c}}){{airport.n}}, {{airport.l}}
																			</li>
																		</ul>
																	</div>
																</div>
																<div class="col-xs-18 bookingFormInput booking-form no-padding " ng-init="setDates(form)"  ng-if="form.type=='date'">
																	<input type="text" ng-if="form.subType=='fromdate'"  data="from_3"  name="{{$parent.$parent.$parent.$index}}" class="fromdate datePickerDummy" date-from />
																	<div class="dateContainer" ng-if="form.subType=='fromdate'" >
																		<div class="dateBreaker rborder" ng-click="setFromDate($parent.$parent.$parent.$index)" >
																			<span ng-bind="form.value.day"></span>
																			<span ng-bind="form.value.month"></span>
																			<span ng-bind="form.value.year"></span>
																		</div>
																		<div class="iconContainer" ng-click="setFromDate($parent.$parent.$parent.$index)"><span  class="iconCalendar"></span></div>
																	</div>
																</div>
																<div class="col-xs-18 booking-form no-padding"  ng-if="form.type=='guest' && searchInit ">
																	<div ng-if="($index+1)%2==1" class="clearfix visible-xs-block desCounter" >
																		<span>Room </span><span ng-bind="$parent.$parent.$parent.$index+1" class="destNum"></span>
																	</div>
																	<div class="col-xs-18 people-side">
																		<div class="col-xs-6 increaser">
																			<p class="plus" ng-click="addOccupancy(form)">+</p>
																			<p class="plus" ng-click="takeOccupancy(form)">-</p>
																		</div>
																		<div class="col-xs-6 anum"><p class="apush" ng-bind="form.value | custNo"></p></div>
																		<div class="col-xs-6"><p class="apush" ng-bind="form.name"></p></div>
																	</div>
																	<div class="col-xs-18 nopadding" ng-if="form.name=='Child' && form.ages.length > 0">
																		<div class="col-xs-18 nopadding" ng-repeat="childAge in form.ages">
																			<span class="col-xs-18 nopadding child_select"><label>Child {{$index+1}}</label></span>
																			<div class="get_input col-xs-18">
																				<input type="text" ng-model="childAge.value" class="form-control trans_input_sm input-sm" placeholder="Date of Birth" birth-dchild >
																			</div>
																			<!-- <select class="" ng-model="childAge.value" required="required" ng-options="option.value as option.name for option in childAgeOptions" ></select> -->
																		</div>
																	</div>
																</div>
															</div>
															<div ng-if="$index!=0 && defaultSearch.module=='Flights'" class="remove" ng-click="removeDestination($index, input)"><span class="glyphicon glyphicon-remove-sign"></span> Remove </div>
														</div>
														<div class="col-xs-18 booking-form trip-type"  ng-if="defaultSearch.module=='Flights'"  ng-click="addMoreDes(input)">
															<div class="addmore"><span class="plus">+</span>Add more destination</div>
														</div>
													</div>
												</div>
												<div ng-repeat="input in defaultSearch.others" class="col-md-6 col-xs-18 no-padding booking-form" ng-show="searchInit">
													<div class="col-xs-18 no-padding" ng-if="input.type=='select'" name="{{input.name}}">
														<label ng-bind="input.name" class="col-md-8 col-xs-18 no-padding"></label>
														<div class="bookingFormInput col-xs-18 col-md-9">
															<select class="" ng-model="input.value" required="required" ng-options="option.value as option.name for option in input.options" ng-change="class_change(input.value)" ></select>
															<span class="ic_sm_xx col-xs-3 hidden-xs"  ></span>
														</div>
													</div>
												</div>
												<div class="col-md-3 col-xs-18 no-padding pull-right booking-form sButAlign">
													<input type="submit" ng-disabled="disabled" value="search" ng-click="setSearch()" class="search-btn" />
												</div>

											</div>
											<div ng-show="defaultSearch.module=='Transfers'">
												<transfer-engine class="col-xs-18 no-padding"></transfer-engine>
											</div>
											<div ng-show="defaultSearch.module=='Visa'">
												<visa-engine class="col-xs-18 no-padding" ng-show="defaultSearch.module=='Visa'"  ng-controller="otherPages"></visa-engine>
											</div>
											<div ng-show="defaultSearch.module=='Insurance'">
												<insurance-engine class="col-xs-18 no-padding" ng-show="defaultSearch.module=='Insurance'"  ng-controller="otherPages"></insurance-engine>
											</div>
										</div>
									</div>
								</div>
							</div>						
						</div>
					</div>
				</div>
				<div class="row" ng-view autoscroll="true" id="appLoader"></div>
				<footer-below subscribe="subscribe(subEmail)"></footer-below>

				</div>
				
			</div>
		</div>		
		<?php if(isset($_POST["txnref"])){ ?>
			<input type="hidden" id="pref" value="<?php echo $_POST["txnref"];?>" payref="<?php echo $_POST["payRef"];?>" retref="<?php echo $_POST["retRef"];?>" />
		<?php }    ?>
		<script>
			!function(A,n,g,u,l,a,r){A.GoogleAnalyticsObject=l,A[l]=A[l]||function(){
			(A[l].q=A[l].q||[]).push(arguments)},A[l].l=+new Date,a=n.createElement(g),
			r=n.getElementsByTagName(g)[0],a.src=u,r.parentNode.insertBefore(a,r)
			}(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
			ga('create', 'UA-74716647-2');
			ga('send', 'pageview');
	   	</script>
	    <script src="bower_components/jquery/dist/jquery.js"></script>
		<script src="bower_components/angular/angular.js"></script>
		<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	    <script src="bower_components/getcentre/jquery-ui.js"></script>
		<script src="bower_components/angular-ui/build/angular-ui.min.js"></script>
	    <script src="bower_components/jquery.ui.autocomplete.html.js"></script>
	    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-sanitize.js"></script>
	    <script src="bower_components/angular-animate/angular-animate.js"></script>
	    <script src="bower_components/angular-route/angular-route.js"></script>
	    <script src="bower_components/angular-resource/angular-resource.js"></script>
	    <script src="bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
	    <script src="bower_components/angular-filter/dist/angular-filter.min.js"></script>
		<script src="bower_components/moment/min/moment.min.js"></script>
		<script src="js/sha512.js"></script>
		<!-- app scripts -->
		<script type="text/javascript" src="js/lib/app.js"></script>
		<script type="text/javascript" src="js/lib/routes/router.js"></script>
		<script type="text/javascript" src="js/lib/controllers/mainController.js"></script>
		<script type="text/javascript" src="js/lib/controllers/flightList.js"></script>
		<script type="text/javascript" src="js/lib/controllers/otherPages.js"></script>
		<script type="text/javascript" src="js/lib/controllers/registerLogin.js"></script>
		<script type="text/javascript" src="js/lib/controllers/searchModal.js"></script>
		<script type="text/javascript" src="js/lib/controllers/hotelList.js"></script>
		<script type="text/javascript" src="js/lib/controllers/hotelDetails.js"></script>
		<script type="text/javascript" src="js/lib/controllers/ltourDetails.js"></script>
		<script type="text/javascript" src="js/lib/controllers/tourList.js"></script>
		<script type="text/javascript" src="js/lib/controllers/tourDetail.js"></script>
		<script type="text/javascript" src="js/lib/controllers/transferList.js"></script>
		<script type="text/javascript" src="js/lib/controllers/travel_pack.js"></script>
		<script type="text/javascript" src="js/lib/controllers/Add_guest.js"></script>
		<script type="text/javascript" src="js/lib/controllers/voucher.js"></script>
		<script type="text/javascript" src="js/lib/controllers/paymentConfirm.js"></script>
		<script type="text/javascript" src="js/lib/directives/mainDirective.js"></script>
		<script type="text/javascript" src="js/lib/services/mainServices.js"></script>
		<script type="text/javascript" src="js/lib/factories/mainFactory.js"></script>
		<script type="text/javascript" src="js/lib/filters/mainFilters.js"></script>
		<script type="text/javascript" src="js/lib/getAnimations.js"></script>
	</body>
</html>

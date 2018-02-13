<!DOCTYPE html>
<html ng-app='GetCentre'>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Online Flight, Hotel, Tours and Transfer booking portal.">
    <meta name="keywords" content="Book Flights, Book Hotels, Tickets, Book Tours, Visa, Reservations, Vacations, Nigeria, Lagos, Africa, London, Dubai, Transfers, Airport, Airline, Car Rental, Online, Website, Cheap, Getaways, Affordable, get, centre, grand, express, tours">
    <meta name="author" content="Olushola Adedokun">
    <title>GETCentre :: Home</title>

    <link rel="stylesheet" href="css/index2.css" type="text/css" />
    <!-- <link rel="stylesheet" href="app/bootstrap/css/bootstrap.min.css" type="text/css" /> -->
    <link rel="stylesheet" href="css/icon.css" type="text/css" />
    <link rel="stylesheet" href="css/style.css" type="text/css" />
    <link type="text/css"  rel="stylesheet" href="css/autocomplete.css">
	<link type="text/css"  rel="stylesheet" href="app/bower_components/getcentre/jquery-ui.css">
    <link rel="stylesheet" href="css/animate_angular.css" type="text/css" />
    <!-- <link rel="stylesheet" href="css/jquery.jscrollpane.css" type="text/css" /> -->
</head>

<body>
	<div class="web_back"  ng-controller="GetCentre">

    	<div class="container">
            <div class="col-xs-18 top_container">
                <div class="col-lg-3 col-md-2 col-sm-6 col-xs-18 navbar-header logo nopadding">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navmenus">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="navbar-brand nopadding">
                    	<img class="hidden-xs" src="images/logo_color.png" width="155" height="80"/>
                        <img class="visible-xs-inline" src="images/logo_color.png" width="90" height="46"/>
                   </div>
                </div>
                <div class="col-lg-15 col-md-16 col-sm-12 nopadding nopadding menu_signin collapse navbar-collapse"  id="navmenus">
                   <ul class="nav col-md-18 navbar-nav nopadding" >
                        <li ng-class="{ active:page.isSet(6)}"><a ng-click="page.setPage(6)" href="#/travel_pack">
                        	 <div class="travel-pack" ng-controller="TravelPack">
                             	<span class="icon-suitcase3"></span>
                                <div class="pack-counter" ng-bind="travelPD.length"></div>

                             </div>
                        </a></li>
                        <li ng-class="{ active:page.isSet(5)}" ng-controller="GetCentre">
                        	<div class="col-md-18 nopadding"  ng-switch on="getUdata[0].status">
                                <a ng-click="page.setPage(5)" ng-switch-when="Register">
                                   <div class="account">Account</div>
                                   <div class="user-add" ng-click="openRegister('log_reg')"> <span class="icon-user-plus"></span></div>
                                </a>
                                <a ng-click="page.setPage(5)" ng-switch-when="Logged_in">
                                   <div class="account" ng-bind="getUdata[1].fname| limitTo:10"></div>
                                   <div class="user-add" ng-click="openRegister()"> <span class="icon-user-plus"></span></div>
                                </a>
                             </div>
                        </li>
                        <li ng-class="{ active:page.isSet(4)}"><a ng-click="page.setPage(4)" href="#/contact_us">Contact</a></li>
                        <li class="hidden-sm" ng-class="{ active:page.isSet(3)}"><a ng-click="page.setPage(3)" href="http://blog.getcentre.com" target="_blank">Blog</a></li>
                        <li class="hidden-sm" ng-class="{ active:page.isSet(2)}"><a ng-click="page.setPage(2)" href="#/about">About</a></li>
                        <li ng-class="{ active:page.isSet(1)}"><a ng-click="page.setPage(1)" href="#/home"><i class=""></i>Home</a></li>
                     </ul>
                </div>
            </div>
        </div>
        <div class="col-xs-18 container" id="b_container">
        	<div class="col-xs-18 app_engine">
            	<div class="col-xs-18 search-box nopadding">
                   	<ul class="col-xs-18 nopadding search-header">
                    	<li class="col-xs-3" ng-class="{s_active: curr_search.service==='Flights'}" ng-click="updateSearch('Flights', 'server/flight_autocomplete.php')"><span class="s_text hidden-xs hidden-sm">Flights</span><span class="icon-get_plane ic"></span></li>
                        <li class="col-xs-4 col-sm-3" ng-class="{s_active: curr_search.service==='Hotels'}" ng-click="updateSearch('Hotels', 'server/hotel_autocomplete.php')" ><span class="s_text hidden-xs hidden-sm">Hotels</span><span class=" icon-get_hotel ic"></span></li>
                        <li class="col-xs-3" ng-class="{s_active: curr_search.service==='Tours'}" ng-click="updateSearch('Tours', 'server/hotel_autocomplete.php')"><span class="s_text hidden-xs hidden-sm">Tours</span><span class=" icon-get_tour ic"></span></li>
                        <li class="col-xs-3" ng-class="{s_active: curr_search.service==='Transfers'}" ng-click="updateSearch('Transfers', 'server/hotel_autocomplete.php')"><span class="s_text hidden-xs hidden-sm">Transfers</span><span class=" icon-get_car2 ic"></span></li>
                        <li class="col-xs-3" ng-class="{s_active: curr_search.service==='Visa'}" ng-click="updateSearch('Visa', 'server/hotel_autocomplete.php')"><span class="s_text hidden-xs hidden-sm">Visa</span><span class=" icon-get_passport ic"></span></li>
                    </ul>
                    <div class="viewanimate" ng-view autoscroll="true"></div>
                </div>
            </div>
            <!-- <div class=" col-xs-18 col-sm-11 text-anim">
            	<span class="col-sm-18 text_anim_head">The World is waiting...</span>
                <span class="col-sm-18  text_anim_p">...Are you ready to explore?</span>
                <div class="col-sm-18">
                    <div class=" col-xs-4 get_button_primary btn-lg">Discover GETCentre</div>
                </div>
            </div>-->


            <div class="col-xs-18 tour-posts" ng-init="localTours()">

            	<div class="col-xs-18 text-center info-top">
            		<h1 class="top-header">Our Top Tours</h1>
            		<p class="top-subheader">explore the world with us</p>
            	</div>

            	<div ng-class="tourClasses($index)"  ng-repeat="tours in localTs">

                		<a href="#/tour/ltour/{{tours.id}}">
                		<div class="over-cover"></div>
                        <div class="tourImgfill">
            		          <img ng-src="../admin/packageimages/{{tours.pict}}"  class="ftimg"/>
                        </div>
                		<div class="headline"><h1 class="the-place" ng-bind="tours.country"></h1>
                		<p class="the-package"  ng-bind="tours.pname"></p></div></a>
                		<span class="from-price" >From &#8358;<span ng-bind="tours.cost | number:2"></span></span>

            	</div>



            	<!-- <div class="leader-board col-md-18">

            		<ul class="bxslider">
            			<li><img src="img/slider1.jpg" /></li>
            			<li><img src="img/slider1.jpg" /></li>

            		</ul>


            	</div> -->

            	<div class="blog-sec">

            		<div class="col-xs-18 col-md-18 text-center info-top">
            			<h1 class="top-header">World Happenings</h1>
            			<p class="top-subheader">explore our blog, get lastest news</p>
            		</div>
            		<div class="col-md-6 col-xs-9 post" ng-repeat="blog in blogs | limitTo:2">
            			<div class="blogImgContainer">
                            <div class="bImgContent">
                                <img src="img/blg1.jpg" blog-img blogcode="{{blog.id}}" class="blgimg"/>
                            </div>
                        </div>
            			<div class="tag">Travel</div>
            			<div class="post-header" ng-bind-html="blog.title | limitTo:60">
            				<h2 ng-bind-html="blog.title | limitTo:60"></h2>
            			</div>
            			<div class="post-content">
            				<p ng-bind-html="blog.excerpt | limitTo:120"></p>
            				<a href="{{blog.permalink}}" target="_blank"><p>Read More >></p></a>
            			</div>
            		</div>
            		<div class="col-md-6 col-xs-18 lastblg">
            			<div class="inner-post">
            				<h1><a href="http://www.blog.getcentre.com">Check out even more interesting posts</a></h1>
            			</div>
            		</div>
            	</div>
        	</div>

            <!-- <div class="col-xs-18 col-sm-18 blog-posts" >
            	<span class="col-xs-18 col-sm-18 blog-post-title">Explore Our Blog</span>
                <div class="col-xs-18 col-sm-6  from-blog" ng-repeat="blog in blogs | limitTo:3">
                    <div class="col-sm-18 nopadding each-blog">
                    	<div class="col-sm-18 nopadding blog-img">
                            <a href="{{blog.permalink}}" target="_blank">
                                <img src="images/blog1.jpg" blog-img blogcode="{{blog.id}}" width="100%" height="100%">
                            </a>
                        </div>
                        <div class="col-sm-18 blog-details">
                        	<div class="col-sm-18 blog-title" ng-bind-html="blog.title | limitTo:60"></div>
                            <div class="col-sm-15 blog-fewdet"></div>
                            <span class="col-sm-18 nopadding blog-more"><a href="{{blog.permalink}}" target="_blank">More >></a></span>
                        </div>
                    </div>
                </div>

                 <span class="col-xs-18 col-sm-18 allpost"><a href="http://www.blog.getcentre.com">View All Posts</a></span>
            </div> -->
        </div>
        <div class="col-xs-18" id="footer_container">
        	<div class="subscribe">
            	<div class="container">
                	<div class="col-xs-18 subscribe_item">
                        <div class="col-xs-18 col-sm-6">Receive info on  our Tour and Travel Deals: <br> Subscribe to Our Newsletter</div>
                        <form ng-submit="subscribe(subemail)">
                            <div class="col-xs-18 col-sm-12 ">
                                <div class="get_input col-xs-18 col-sm-12">
                                    <input type="email" class="col-xs-15 col-sm-15 form-control input-lg trans_input" ng-model="subemail" placeholder="Type your email Address" required />
                                    <span class=" icon-Email-Open1 ic_lg col-xs-3 nopadding"></span>
                                </div>
                                <div class="col-xs-18 col-sm-6">
                                	<input type="submit" class="col-xs-18 get_button_secondary btn-lg" value="Subscribe"/>
                                </div>
                            </div>

                            <div class="col-xs-18 col-sm-offset-6 col-sm-12" ng-bind="sub_message"></div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="foot_social">
            	<div class="container">
                	<div class="col-xs-18 col-md-2 foot_col">
                    	<span class="col-xs-18 foot_title">ABOUT</span>
                        <span class="col-xs-18 foot_item"><a href="#/about">The Company</a></span>
                        <span class="col-xs-18 foot_item"><a href="#/about">Our Vision</a></span>
                        <span class="col-xs-18 foot_item"><a href="#/about">Value Proposition</a></span>
                    </div>
                    <!--<div class="col-md-3 foot_col">
                    	<span class="col-md-18 foot_title">PARTNER</span>
                        <span class="col-md-18 foot_item">Sabre</span>
                        <span class="col-md-18 foot_item">Hotelbeds</span>
                        <span class="col-md-18 foot_item">TouchDown Travels</span>
                    </div>-->
                    <div class="col-xs-18 col-md-9 foot_col">
                    		<span class="col-xs-18 foot_title">SUPPORT</span>
                        	<div class="col-xs-18 col-md-6 foot_item"><a href="#/support">Privacy Policy</a></div>
                            <div class="col-xs-18 col-md-6 foot_item"><a href="#/contact_us">Contact</a></div>
                            <div class="col-xs-18 col-md-6 foot_item"><a href="#/support">Cookies Usage</a></div>
                        	<div class="col-xs-18 col-md-6 foot_item"><a href="#/support">Terms &amp; Conditions</a></div>
                            <div class="col-xs-18 col-md-6 foot_item"><a href="#/support">3rd Party Disclosure</a></div>
                            <!--<div class="col-md-6">Tutorial</div>-->
                        	<div class="col-xs-18 col-md-6 foot_item"><a href="#/support">Information Protection</a></div>
                            <div class="col-xs-18 col-md-6 foot_item"><a href="#/support">Pricing</a></div>
                            <!--<div class="col-md-6">Pricing</div>-->
                    </div>
                    <div class="col-xs-18 col-md-3 foot_col">
                    	<span class="col-xs-18  foot_title">ACCOUNT</span>
                        <span class="col-xs-18 foot_item">Your Account</span>
                        <span class="col-xs-18 foot_item">Your Cart</span>
                        <span class="col-xs-18 foot_item">Log Out</span>
                    </div>
                    <!-- <div class="col-xs-18 col-md-4 foot_col">
                    	<div class="col-xs-18 foot_title">PAYMENT OPTIONS</div>
                        <div class="col-xs-18 pay_img">
                            <img src="images/paygate.png" width="213" height="140"/>
                         </div>
                    </div> -->

                </div>

            </div>
            <div class="paymentOptions">
                <div class="container">
                    <div class="col-xs-18">
                        <span class="col-xs-18">Payment Options</span>
                        <div class="col-xs-9 nopadding">
                            <div class="col-xs-9 nopadding">
                                <img height="41" src="images/interswitchLogo.png" />
                            </div>
                            <div class="col-xs-9 nopadding">
                                <img height="50" src="images/mastercard.png" />
                            </div>
                        </div>
                        <div class="col-xs-9 nopadding">
                            <div class="col-xs-9 nopadding">
                                <img height="40" src="images/verve.png" />
                            </div>
                            <div class="col-xs-9 nopadding">
                                <img height="41" src="images/banktransfer.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="social_copy">
            	<div class="container">
                	<div class="col-xs-18 col-md-6 copy_right" >Copyright &copy; 2015 GETCentre <br class="visible-xs-inline"><span class="hidden-xs">|</span> Design By <span class="autonimrod">Autonimrod Limited</span></div>
                    <div class=" col-xs-18 col-md-10 pull-right social_media" >
                    	<a target="_blank" href="https://www.facebook.com/getcentreapp/" class="slink icon-facebook4"></a>
                        <a target="_blank" href="https://twitter.com/getcentre1" class="slink icon-twitter3"></a>
                        <a target="_blank" href="https://www.linkedin.com/company/get-centre" class="slink icon-linkedin3"></a>
                        <a target="_blank" href="https://plus.google.com/u/0/118132775185913832007" class="slink icon-googleplus"></a>
                        <a target="_blank" href="https://www.youtube.com/channel/UCGyqvVm1UHPO3f8nK7ykWAA" class="slink icon-youtube2"></a>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="pref" value="<?php echo $_POST["txnref"];?>" payref="<?php echo $_POST["payRef"];?>" retref="<?php echo $_POST["retRef"];?>" >
    </div>
    <script>
      !function(A,n,g,u,l,a,r){A.GoogleAnalyticsObject=l,A[l]=A[l]||function(){
      (A[l].q=A[l].q||[]).push(arguments)},A[l].l=+new Date,a=n.createElement(g),
      r=n.getElementsByTagName(g)[0],a.src=u,r.parentNode.insertBefore(a,r)
      }(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
      ga('create', 'UA-74716647-2');
      ga('send', 'pageview');
   </script>
    <script src="app/bower_components/jquery/dist/jquery.js"></script>
    <script src="app/bower_components/getcentre/jquery-ui.js"></script>
    <script src="app/bower_components/jquery.ui.autocomplete.html.js"></script>
    <script src="app/bower_components/angular/angular.js"></script>
    <!--sanitises html-->
    <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.4.0/angular-sanitize.js"></script>
    <!--required module to enable animation support in AngularJS -->
    <script src="app/bower_components/angular-animate/angular-animate.js"></script>
    <script src="app/bower_components/angular-route/angular-route.js"></script>
    <script src="app/bower_components/angular-resource/angular-resource.js"></script>
     <script src="app/bower_components/angular-bootstrap/ui-bootstrap-tpls.min.js"></script>
    <!--<script src="app/bower_components/angular-ui/build/angular-ui.min.js"></script>-->
    <script src="app/bower_components/angular-filter/dist/angular-filter.min.js"></script>
    <script src="script/sha512.js">	</script>
    <script src="script/app.js"></script>
    <script src="script/services.js"></script>
    <script src="script/getAnimations.js"></script>
    <script src="script/flightList.js"></script>
    <script src="script/hotelList.js"></script>
	<script src="script/hotelDetails.js"></script>
    <script src="script/tourList.js"></script>
    <script src="script/transferList.js"></script>
    <script src="script/travel_pack.js"></script>
    <script src="script/ltourDetails.js"></script>
    <script src="script/tourDetail.js"></script>
    <script src="script/Add_guest.js"></script>
    <script src="script/voucher.js"></script>
    <script src="script/otherPages.js"></script>
    <script src="script/jquery.jscrollpane.min.js"></script>
    <script src="script/paymentConfirm.js"></script>
    <script type="text/javascript" src="script/moment.js"></script>

    <link href="textanim/animate.css" rel="stylesheet">

    <script src="textanim/jquery.fittext.js"></script>
    <script src="textanim/jquery.lettering.js"></script>
    <script src="http://yandex.st/highlightjs/7.3/highlight.min.js"></script>
    <script src="textanim/jquery.textillate.js"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script src="textanim/anim.js"></script>

    <!--Start of Zopim Live Chat Script-->
    <script type="text/javascript">
    window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
    d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
    _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
    $.src="//v2.zopim.com/?4EF0TN7YSQlFEUKKLJ817uaxSQ2P6XMb";z.t=+new Date;$.
    type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
    </script>
    <!--End of Zopim Live Chat Script-->
</body>
</html>

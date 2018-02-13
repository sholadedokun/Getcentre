<div class="col-md-16">
    <div class="col-md-offset-3 col-md-15 page_head">
        <h4 class="col-xs-6 h_search_title">Tour Checkout</h4>
        <div class="col-xs-12 h_process_bar">
            <i>Step</i>
            <div class="progress_num">1</div>
            <div class="progress_to"></div>
            <div class="progress_num visible-lg visible-md">2</div>
            <div class="progress_to visible-lg visible-md"></div>
            <i class=" hidden-lg  hidden-md " style="margin:1.3em 0"><b>out of</b></i>
            <div class="progress_num visible-lg visible-md">3</div>
            <div class="progress_to"></div>
            <div class="progress_num_current ">4</div>
            <i class=" hidden-lg  hidden-md " style="margin:1.3em 0">Steps</i>
        </div>
    </div>
    <div class="col-md-18 nopadding">
    	<div class="col-md-11 nopadding" style="min-height:305px">
        	<div class="col-md-7 nopadding" style="min-height:285px">
        	<div class="col-md-18 ">
                <div class="col-md-18 login_title"><h4>Your Tour List</h4></div>
                <div class="col-md-18 tour_pack_list">
                    <div class="col-md-18">
                        <div class="col-md-18">
                            <div class="col-md-18">
                            	<label>Your Package Contains {{getTour.length}} Tours</label>
                                 <ul class="col-md-18 nopadding scroller_container">
                                    <li class="col-md-18" ng-repeat="tours in getTour" on-finish-render="ngRepeatFinished">
                                        <div class="room_spec col-md-16">
                                            <div class="room_t_n_cont col-xs-5 nopadding">
                                                <div class="room_thumb_nail">
                                                <img ng-src="{{tours[1].Image[0].Url}}" width="50" height="50" /></div>
                                            </div>
                                            <div class="col-xs-13 nopadding">
                                                <div class="room_type">
                                                    <label>{{tours[0].Paxes.AdultCount}} Adults {{tours[0].Paxes.ChildCount}} Children</label></div>
                                                <div class="room_type"> 
                                                    {{tours[0].TicketInfo.Name | limitTo:25}}
                                                </div>
                                                <div class="room_type">
                                                    {{getData[21].valueData| limitTo:25 }}
                                                </div>
                                                <div class="room_price">&euro;  {{tours[0].TotalAmount}}</div>
                                            </div>
                                            <div class=" btn-sm pull-right btn get_button_primary" ng-click="addtourist($index)">Add Lead Tourist</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        	<div class="col-md-11 nopadding">
                <div class="col-md-18 login_title"><h4>Please Select Lead/Holder Guest*</h4></div>
                <div class="col-md-18 login_form">
                    <div class="col-md-18 term_defination">*This person is resposible for this tour reservation. </div>
                    	<div  class="col-md-18" ng-if="Array.isArray(travelers)">
                            <div class="col-md-18 lead_pax" ng-repeat="guest in travelers">
                                <!--<label> {{$index+1}}</label>-->
                                <div class="col-md-18" ng-if="guest['@type']!='CH'">
                                	<div class="col-md-18 get_pad">
                                    	<label><input type="radio" name="LeadPAX" ng-model="lead.user" value="{{guest.CustomerId}}|{{adultGuest[$index][0]"/> {{adultGuest[$index][0]}}</label>
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                        <div class="col-md-18" ng-if="!Array.isArray(travelers)">
                            <div class="col-md-18" ng-if="travelers['@type']!='CH'">
                            	<div class="col-md-18 get_pad">
                                	<label><input type="radio" name="LeadPAX" ng-model="lead.user" value="{{travelers.CustomerId+'|'+adultGuest[0][0]"/> {{adultGuest[0][0]}}</label>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-7 nopadding" style="min-height:305px">
        	<div class="col-md-18 trip_summ_title">
            	<h4>Your Tour Summary</h4>
            </div>
            <div class="col-md-18 trip_summ">
            	<div class="col-md-7 nopadding" style="min-height:155px; background:#eee">
                	<img ng-src="{{getTour[0][1].Image[1].Url}}" width="150" height="120" style=" padding-top:30px" />
                </div>
                <div class="col-md-11" style="min-height:155px;">
                	<div class="col-md-18">
                    	<div class="col-xs-18 summ_serv_name">
                        	<h5>{{getTour[0][0].TicketInfo.Name }} 
                            </h5>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Destination</label>
                            <div class="col-xs-12 nopadding">{{getData[21].valueData}}</div>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Ticket</label>
                            <div class="col-xs-12 nopadding">{{getTour[0][0].Paxes.AdultCount}} Adults {{getTour[0][0].Paxes.ChildCount}} Children</div>
                        </div>
                        
                    	<div class="col-xs-18 summ_hotel_add nopadding">
                        	<label  class="col-xs-6 nopadding">Tour Date From</label>
                            <div class="col-xs-12 nopadding"><span>{{getTour[0][0].DateFrom['@date'] | hdate}}</span></div>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Tour Date to</label>
                            <div class="col-xs-12 nopadding"><span>{{getTour[0][0].DateTo['@date'] | hdate}}</span></div>
                        </div>
                        <div class="col-md-18 get_pad">
                    	<div class="col-xs-6 summ_price_label">Price</div>
                    	<div class="col-xs-12 total_price"><sup>$</sup>{{getTour[0][0].TotalAmount}}</div>
                    </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-sm-18 nopadding pay_method" ng-controller="GetCentre">
            	<div class="col-md-18 nopadding"  ng-switch on="userd[0].status">                  
            	<div class="col-sm-18" name="login_register" ng-switch-when="Register">
                    <div class="col-xs-18 login_head"><h4>Please, you will need to :</h4></div>                    
                    <button type="submit"  class="col-xs-offset-1 col-xs-5 btn btn-default btn-sm get_pad get_button_primary">Login</button>
                    <div class="col-xs-4 login_head2"><h4>OR</h4></div>
                    <button type="submit" ng-click="openRegister()" class="col-xs-5 btn btn-default btn-sm get_pad get_button_primary">Register</button>
                    <div class="col-xs-18 login_head2"><h4>To Complete your Tour Reservation</h4></div>                    
                </div>
                <div class="col-sm-18" name="login_register" ng-switch-when="Logged_in">
                    <div class="col-xs-18 login_head2"><h5>This Booking Will be Added to the User Account:</h5></div> 
                    <div class="col-xs-9 ">
                    	<div class="col-xs-18"><b>Full Name</b></div>
                        <div class="col-xs-18">{{userd[1].fname}} {{userd[1].lname}}</div>
                        <div class="col-xs-18"><b>Email Address</b></div>
                        <div class="col-xs-18">{{userd[1].email}}</div>
                        <div class="col-xs-18"><b>Phone Number</b></div>
                        <div class="col-xs-18">{{userd[1].phone}}</div>
                    </div>    
                    <div class="col-xs-9 nopadding">               
                    <a type="submit"  class="link_a" style="margin-top: 20px;">Change User</a>
                    <a ng-click="openRegister()" class="link_a" style="margin:0.1em 0 0.5em;">Register New Account</a>
                    <a  href="#" style="margin-bottom:10px;">
                    	<button type="submit" ng-click="next('/tours/tour_confirmation', lead)"  class="col-xs-16 btn btn-default btn-sm get_pad get_button_primary">Continue</button>
                        </a>
                    </div>                    
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<div class="col-md-2 visible-lg visible-md nopadding" style="min-height:345px">
    <ul class="col-md-18 side_menu nopadding">
        <li class="nopadding" style="height:3px; background:#92c841"></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Flight</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc2">Hotels</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Visas</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc2">Properties</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Exhibitions</div></li>
    </ul>
</div>
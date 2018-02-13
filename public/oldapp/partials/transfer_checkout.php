<div class="col-md-16">
    <div class="col-md-offset-3 col-md-15 page_head">
        <h4 class="col-xs-6 h_search_title">Transfer Checkout</h4>
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
        	<div class="col-md-11 nopadding">
                <div class="col-md-18 login_title"><h4>Please Select Lead/Holder Guest*</h4></div>
                <div class="col-md-18 login_form">
                    <div class="col-md-18 term_defination">*This person is resposible for this transfer service reservation. </div>
                    	<div  class="col-md-18" ng-if="Array.isArray(travelers)">
                            <div class="col-md-18 lead_pax" ng-repeat="guest in travelers">
                                <!--<label> {{$index+1}}</label>-->
                                <div class="col-md-18" ng-if="guest['@type']!='CH'">
                                	    
                                    <div class="col-md-18 get_pad">
                                    	<label><input type="radio" name="LeadPAX" ng-model="lead.user" value="{{guest.CustomerId}}|{{adultGuest[$index][0]}}"/> {{adultGuest[$index][0]}}</label>
                                    </div>                                 
                                </div>
                            </div>
                        </div>
                        <div class="col-md-18" ng-if="!Array.isArray(travelers)">
                            <div class="col-md-18" ng-if="travelers['@type']!='CH'">
                            	<div class="col-md-18 get_pad">
                                    	<label><input type="radio" name="LeadPAX" ng-model="lead.user" value="{{travelers.CustomerId}}|{{adultGuest[0][0]"/> {{adultGuest[0][0]}}</label>
                                    </div> 
                            </div>
                        </div>
                </div>
            </div>
            <div class="col-md-7 nopadding" style="background:#fff; max-height:305px; overflow:hidden">
            	 <div class="panel-group" id="accordion">
                      <div class="panel panel-default get_panel">
                        <div class="panel-heading get_panel_heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" onclick="return false;">Cancellation Policy</a>
                          </h4>
                        </div>
                        <div id="collapse1" class="panel-collapse get_panel_collapse collapse in">
                          <div class="panel-body"  ng-show="cancel_policies">                          	
                            <div class="col-xs-18 nopadding">
                                <ul class="col-xs-18 nopadding">
                                    <li class="col-xs-18 nopadding">
                                        <div class="col-xs-18" style="margin-bottom:20px">
                                            Cancellation after <b>{{cancel_policies['@time'] | htime}} </b>on<b>
                                            {{cancel_policies['@dateFrom'] | hdate}}</b> will cost 
                                            <b>{{cancel_policies['@amount']}}</b>
                                        </div>
                                        <div class="col-xs-18" style="margin-bottom:20px">
                                           <label>The following is applicable to this Booking:  </label>
                                            <div class="col-md-18" ng-repeat="mod in modify_policies">{{mod}}</div>
                                        </div>
                                        
                                    </li>
                                </ul>
                             </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default get_panel">
                        <div class="panel-heading get_panel_heading2">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onclick="return false;">Reservation Rules</a>
                          </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse get_panel_collapse collapse">
                          <div class="panel-body">
                          	<div class="col-xs-18" style="margin-bottom:20px">
                          		<div><label>Maximum Driver Waiting time(Domestic):</label>{{max_wait_time_dom}} Minutes</div>
                                <div><label>Maximum Driver Waiting time(International):</label>{{max_wait_time_int}} Minutes</div>
                             </div>
                              <div class="col-xs-18" style="margin-bottom:20px" ng-repeat="rule in reserve_rules">
                               <label>{{rule.Description}}  </label>
                                <div class="col-md-18" >{{rule.DetailedDescription}}</div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="panel panel-default get_panel">
                        <div class="panel-heading get_panel_heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"  onclick="return false;">Pickup Information</a>
                          </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse get_panel_collapse collapse">
                          <div class="panel-body">{{info}}</div>
                        </div>
                      </div>
                    </div> 
            </div>
        </div>
        
        <div class="col-md-7 nopadding" style="min-height:305px">
        	<div class="col-md-18 trip_summ_title">
            	<h4>Your Transfer Summary</h4>
            </div>
            <div class="col-md-18 trip_summ">
            	<div class="col-md-7 nopadding" style="min-height:155px; background:#eee">
                	<img ng-src="{{transInfo.TransferInfo.ImageList.Image[1].Url}}" width="150" height="120" style=" padding-top:30px" />
                </div>
                <div class="col-md-11" style="min-height:155px;">
                	<div class="col-md-18">
                    	<div class="col-xs-18 summ_serv_name">
                        	<h5>{{transInfo.ProductSpecifications.MasterProductType['@name'] | limitTo:50}} 
                            {{transInfo.ProductSpecifications.MasterServiceType['@name'] | limitTo:25 }}
                            ({{transInfo.ProductSpecifications.MasterVehicleType['@name'] | limitTo:25 }} ) 
                            </h5>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Pick up</label>
                            <div class="col-xs-12 nopadding"><span ng-show="transInfo.PickupLocation['@xsi:type']!='ProductTransferHotel'">({{transInfo.PickupLocation.Code}})</span>{{transInfo.PickupLocation.Name}}</div>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Destination</label>
                            <div class="col-xs-12 nopadding">
                            <span ng-show="transInfo.DestinationLocation['@xsi:type']!='ProductTransferHotel'">({{transInfo.DestinationLocation.Code}})</span>
                            {{transInfo.DestinationLocation.Name}}</div>
                        </div>
                    	<div class="col-xs-18 summ_hotel_add nopadding">
                        	<label  class="col-xs-6 nopadding">Pickup Date</label>
                            <div class="col-xs-12 nopadding"><span>{{transInfo.DateFrom['@date'] | hdate }}</span></div>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding">
                        	<label class="col-xs-6 nopadding">Pickup Time</label>
                            <div class="col-xs-12 nopadding"><span>{{transInfo.DateFrom['@time'] | htime}}</span></div>
                        </div>
                        <div class="col-xs-18 summ_hotel_add nopadding"  ng-if="transInfo.DestinationLocation['@xsi:type']!='ProductTransferHotel'">
                        	<label class="col-xs-6 nopadding">Departure Time</label>
                            <div class="col-xs-12 nopadding"><span>{{transInfo.DateTo['@time'] | htime}}</span></div>
                        </div>
                        <div class="col-md-18 get_pad">
                    	<div class="col-xs-6 summ_price_label">Price</div>
                    	<div class="col-xs-12 total_price"><sup>$</sup>{{transInfo.TotalAmount}}</div>
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
                    <div class="col-xs-18 login_head2"><h4>To Complete your Transfer Reservation</h4></div>                    
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
                    	<button type="submit" ng-click="next('/tours/transferConfirmation', lead)"  class="col-xs-16 btn btn-default btn-sm get_pad get_button_primary">Continue</button>
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
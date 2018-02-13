<script>
	$(document).ready(function() { 
		$('.p_container').jScrollPane();
	})
</script>
<link type="text/css"  rel="stylesheet" href="css/autocomplete.css">
<link type="text/css"  rel="stylesheet" href="app/bower_components/getcentre/jquery-ui.css">
<div class="col-md-18 ">
    <div class="col-md-18 nopadding">
    	<div class="col-md-6 nopadding" style="min-height:285px; margin-top:2em !important">
        	<div class="col-md-18 ">
                <div class="col-md-18 login_title"><h4>Create Your Tour Package</h4></div>
                <div class="col-md-18 tour_search_list">
                	<div class="col-md-4  nopadding h_search_menu">
                        <ul class="nav navbar-nav">
                            <li class="active"><a ng-click="touroptions='toursO'" href="#">Tours Only</a></li>
                            <li><a ng-click="touroptions='transferO'" href="#">Transfers Only</a></li>
                            <li style="border:none;"><a ng-click="page.setPage(3)" href="#">Tours + Transfers</a></li>
                         </ul>
                    </div>
                    <div class="col-md-14" >
                    	
                    	<div id="tsearchportal" class="col-md-18 nopadding"  ng-switch on="tourType">                        	
                            <div class="col-xs-18 form-group nopadding" ng-show="touroptions=='toursO'">
                                <label for="location1">Vacating to</label>
                                <div class="col-md-18 location_cover" style="padding-bottom:0">
                                    <input type="text" id="tour_complete" class="form-control input-lg get_input f_location_input flight_complete" placeholder="Dubai UAE" name="dep" >
                                </div>
                            </div>                            
                            <div class="col-xs-18 form-group nopadding" ng-show="touroptions=='toursO'">
                                <div class="col-xs-9 nopadding">
                                    <label for="f_from_date">Starting On</label>
                                    <div class="f_search_calender f_calendar">  
                                        <div class="col-xs-7 nopadding f_dayth">
                                            <input type="text" class="form-control get_input" ng-model="f_day" ng-click="setfromdate()" id="h_from_date">
                                        </div>
                                        <div class="col-xs-11 nopadding f_month">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="setfromdate()" ng-model="f_month" id="h_from_month">
                                            <div class="col-xs-18 divider_h"></div>
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="setfromdate()" ng-model="f_year" id="h_from_year">
                                        </div>
                                        <div class="col-xs-18 change_date" ng-click="setfromdate()">
                                            Change Date<input type="text" id="s_date" class="datepicker_dummy" tdate-from />
                                        </div>
                                    </div>
                                </div>                            
                                <div class="col-xs-9 nopadding">
                                    <label for="h_from_date">Ending On</label>
                                    <div class="f_search_calender f_calendar">  
                                        <div class="col-xs-7 nopadding f_dayth">
                                            <input type="text" class="form-control get_input" ng-model="t_day" ng-click="settodate()" id="h_from_date">
                                        </div>
                                        <div class="col-xs-11 nopadding f_month">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="settodate()" ng-model="t_month" id="h_from_month">
                                            <div class="col-xs-18 divider_h"></div>
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="settodate()" ng-model="t_year" id="h_from_year">
                                        </div>
                                        <div class="col-xs-18 change_date" ng-click="settodate()">
                                            Change Date <input type="text" id="e_date" class="datepicker_dummy" tdate-to />
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                            
                            <div class="col-xs-18 form-group nopadding"  ng-show="touroptions=='transferO'">
                               <div class="col-xs-18" > 
                                    <label class="col-xs-18" for="location1">Pick Up Location</label>
                                    <div class="col-md-18 location_cover">
                                        <select class="input-sm" ng-model="pickupType" required="required" ng-init="pickupType='select'" ng-options="option.value as option.name for option in locationtype" >
</select>
                                    </div>
                               </div>
                               <div class="col-md-18 location_cover" ng-show="pickupType=='Hotel'" style="padding-bottom:0">
                                    <input type="text" class="form-control input-lg get_input f_location_input flight_complete" placeholder="Please Hotel Location" name="dep" id="transfer_hp_complete">
                                </div>
                               <div class="col-md-18 location_cover" ng-show="pickupType!='select'" style="padding-bottom:0">
                                    <input type="text" class="form-control input-lg get_input f_location_input flight_complete" placeholder="Please type a {{pickupType}} Code OR Name" name="dep" id="transfer_complete">
                                </div>
                            </div>
                            <div class="col-xs-18 form-group nopadding" ng-show="touroptions=='transferO'">
                                <div class="col-xs-9 nopadding">
                                    <label for="f_from_date">Pick-up Date</label>
                                    <div class="f_search_calender f_calendar">  
                                        <div class="col-xs-7 nopadding f_dayth">
                                            <input type="text" class="form-control get_input" ng-model="f_day" ng-click="setfromdate()" id="h_from_date">
                                        </div>
                                        <div class="col-xs-11 nopadding f_month">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="setfromdate()" ng-model="f_month" id="h_from_month">
                                            <div class="col-xs-18 divider_h"></div>
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="setfromdate()" ng-model="f_year" id="h_from_year">
                                        </div>
                                        <div class="col-xs-18 change_date" ng-click="setfromdate()">
                                            Change Date<input type="text" id="s_date" class="datepicker_dummy" tdate-from />
                                        </div>
                                    </div>
                                    
                                </div>                            
                                <div class="col-xs-9 nopadding">
                                    <label for="f_from_date">Pick-up Time</label>
                                    <div class="col-xs-16 get_pad" style="padding-top:0 !important">
                                        <div class="col-xs-8 nopadding" style="padding-top:0 !important">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="t_hr" value="01">
                                        </div>
                                        <div class="col-xs-offset-2 col-xs-8 nopadding" style="padding-top:0 !important">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="t_min" value="59">
                                        </div>
                                        <div class="col-xs-16" style="padding-top:5px !important">
                                            <div class="col-md-18">
                                                <select class="col-md-18 input-sm" ng-model="ptimeType" required="required" ng-init="ptimeType='0'" ng-options="option.value as option.name for option in am_pm" >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>                           
                            </div>
                            <div class="col-xs-18 form-group nopadding"  ng-show="touroptions=='transferO'">
                           <div class="col-xs-18"> 
                                <label class="col-xs-18" for="location1">Destination Location</label>
                                <div class="col-md-18 location_cover">
                                    <select class="input-sm" ng-model="destinationType" required="required" ng-init="destinationType='select'" ng-options="option.value as option.name for option in locationtype" >
</select>
                                </div>
                           </div>
                           <div class="col-md-18 location_cover" ng-show="destinationType=='Hotel'" style="padding-bottom:0">
                                    <input type="text" class="form-control input-lg get_input f_location_input flight_complete" placeholder="Hotel Location" name="dep" id="transfer_hd_complete">
                                </div>
                           <div class="col-md-18 location_cover" ng-show="destinationType!='select'" style="padding-bottom:0">
                                <input type="text"  class="form-control input-lg get_input f_location_input flight_complete" placeholder="{{destinationType}} Code OR Name" name="dep" id="transfer_complete_2">
                            </div>
                        </div>
                            <div class="col-xs-18 nopadding" ng-show="destinationType=='Terminal'">
                                    <label for="f_from_date">Flight / Bus / Train /Ship Departure Time</label>
                                    <div class="col-xs-9 get_pad" style="padding-top:0 !important">
                                        <div class="col-xs-8 nopadding" style="padding-top:0 !important">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="d_hr" value="01">
                                        </div>
                                        <div class="col-xs-offset-2 col-xs-8 nopadding" style="padding-top:0 !important">
                                            <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="d_min" value="59">
                                        </div>
                                        <div class="col-xs-16" style="padding-top:5px !important">
                                            <div class="col-md-18">
                                                <select class="col-md-18 input-sm" ng-model="dtimeType" required="required" ng-init="dtimeType='0'" ng-options="option.value as option.name for option in am_pm" >
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="col-xs-18" style="padding:1em 0">
                                <div class="col-xs-9 nopadding">
                                        <div class="f_search_accomodation">  
                                            <div class="col-xs-7 f_acco_icon ">
                                                <img class="f_acco_icon_adult" src="images/adult_h.png"/>
                                            </div>
                                            <div class="col-xs-11 nopadding f_cont">
                                                <div class="col-xs-12 f_dayth nopadding">
                                                    <input type="text" class="form-control get_input" value="{{tour_atten[0] | custNo}}" id="r_adult_1">
                                                    <div class="divider_h"></div>
                                                    <div class=" col-xs-18 f_icon_desc" style="">Adults</div>
                                                </div>
                                                <div class="col-xs-6 nopadding search_right_corner f_cont">
                                                    <div class="pass_sel f_acco_add" ng-click="tour_atten[0]=tour_atten[0]+1">+</div>
                                                     <div class="divider_h"></div>
                                                    <div class="pass_sel f_acco_add" ng-click="tour_atten[0]=tour_atten[0]-1">-</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-xs-9 nopadding">
                                        <div class="f_search_accomodation"> 
                                            <div class="col-xs-7 f_acco_icon ">
                                                <img class="f_acco_icon_child"  src="images/child_h.png"/>
                                            </div>
                                            <div class="col-xs-11 nopadding f_cont" >
                                            <div class="col-xs-12 f_dayth nopadding">
                                                <input type="text" class="form-control get_input" value="{{tour_atten[1].length | custNo}}" id="r_infant">
                                                <div class="divider_h"></div>
                                                <div class=" col-xs-18 f_icon_desc" style="">Children</div>
                                            </div>
                                            <div class="col-xs-6 nopadding search_right_corner f_cont">
                                                <div class="pass_sel f_acco_add" ng-click="tour_atten[1].push([])">+</div>
                                                 <div class="divider_h"></div>
                                                <div class="pass_sel f_acco_add" ng-click="tour_atten[1].pop([])">-</div>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6" ng-repeat="child in tour_atten[1]">
                                        <span class="col-xs-18 nopadding">Child {{$index+1}}: Age</span>
                                        <select class="col-xs-18 nopadding" ng-model="tour_atten[1][$index]">
                                            <option value="0" selected="selected">Select Age</option>
                                            <option value="1">1 Year</option>
                                            <option value="2">2 Years</option>
                                            <option value="3">3 Years</option>
                                            <option value="4">4 Years</option>
                                            <option value="5">5 Years</option>
                                            <option value="6">6 Years</option>
                                            <option value="7">7 Years</option>
                                            <option value="8">8 Years</option>
                                            <option value="9">9 Years</option>
                                            <option value="10">10 Years</option>
                                            <option value="11">11 Years</option>
                                            <option value="12">12 Years</option>
                                            <option value="13">13 Years</option>
                                            <option value="14">14 Years</option>
                                            <option value="15">15 Years</option>
                                            <option value="16">16 Years</option>
                                            <option value="17">17 Years</option>
                                        </select>
                                    </div>
                            </div>
                            
                            <div class="col-xs-18" ng-show="touroptions=='transferO'"> 
                                <label class="col-xs-18" for="location1">Do you want a Return Transfer?</label>
                                <div class="col-md-18 location_cover">
                                    <select class="input-sm" ng-model="returnType" required="required" ng-init="returnType='N'" ng-options="option.value as option.name for option in returntrans" >
</select>
                                </div>
                                <div class="col-xs-18 form-group nopadding" ng-if="returnType=='Y'">
                                    <div class="col-xs-9 nopadding">
                                        <label for="f_from_date">Return Date</label>
                                        <div class="f_search_calender f_calendar">  
                                    <div class="col-xs-7 nopadding f_dayth">
                                        <input type="text" class="form-control get_input" ng-model="t_day" ng-click="settodate()" id="h_from_date">
                                    </div>
                                    <div class="col-xs-11 nopadding f_month">
                                        <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="settodate()" ng-model="t_month" id="h_from_month">
                                        <div class="col-xs-18 divider_h"></div>
                                        <input type="text" class="form-control col-xs-18 input-sm get_input" ng-click="settodate()" ng-model="t_year" id="h_from_year">
                                    </div>
                                    <div class="col-xs-18 change_date" ng-click="settodate()">
                                        Change Date <input type="text" id="e_date" class="datepicker_dummy" tdate-to />
                                    </div>
                                </div>                                            
                                    </div>                            
                                    <div class="col-xs-9 nopadding">
                                        <label for="f_from_date">Pick-up Time</label>
                                        <div class="col-xs-16 get_pad" style="padding-top:0 !important">
                                            <div class="col-xs-8 nopadding" style="padding-top:0 !important">
                                                <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="r_hr" value="01">
                                            </div>
                                            <div class="col-xs-offset-2 col-xs-8 nopadding" style="padding-top:0 !important">
                                                <input type="text" class="form-control col-xs-18 input-sm get_input" ng-model="r_min" value="59">
                                            </div>
                                            <div class="col-xs-16" style="padding-top:5px !important">
                                                <div class="col-md-18">
                                            <select class="col-md-18 input-sm" ng-model="rtimeType" required="required" ng-init="rtimeType='0'" ng-options="option.value as option.name for option in am_pm" >
    </select>
                                        </div></div>
                                        </div>
                                    </div>                           
                                </div>
                               </div>
                        </div>
                        <div class="col-md-18" style="padding-bottom:1em" >
                       		<a href="#"  ng-click="setTourTransfer(touroptions)"  ><div class="col-md-offset-4 col-md-10 btn get_button_primary">Search</div></a>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-12 t_product_cont">
        	<div class="col-md-14">
                <div class="col-md-18" style="height:320px; overflow:hidden;">
                	<img  class="col-md-18 img-responsive" ng-src="{{mainImageUrl}}"  height="750" width="500">
                    <div class="" style="position:absolute; top:50px; height:150px; background:#eee; width:200px">
                    	<!--<div style="font-weight:bold; font-size:24px; color:#444">{{mainName}}</div>
                        <div style="font-weight:bold; font-size:24px; color:#444">{{mainName}}</div>
                        <div style="font-weight:bold; font-size:24px; color:#444">{{mainName}}</div>-->
                    </div>
                </div>
                <div class="col-md-18">
                    <div class="col-sm-3"><Label>View All Package</Label></div>
                	<div class="col-sm-15 t_pack_slide" >
                   <!-- <div class="t_p_left_sc"></div>-->
                    <div class=" col-sm-18 t_p_slide_frame" >
                        <div class="t_p_slide_scroller">
                            <div class="t_package_thm"  ng-repeat="pack in packages">
                                <div class="col-xs-18 nopadding">
                                	<img  class="img-responsive" src="{{pack.package_img_sm}}" height="80" width="120">
                                </div>
                            </div>
                            
                        </div>            
                    </div>
                    <!--<div class="t_p_right_sc"></div>-->
                </div>
            	</div>
            
            </div>	
            <div class="col-md-4 nopadding">
            	<div class="col-md-18 nopadding">
		<div class="col-md-18 noapdding" style="min-height:305px">
        	<div class="col-md-18 green_bar"></div>
            <div class="col-md-18 tour_addon">
            	<div class="col-md-8 nopadding couple_img"></div>
                <div class="col-md-10 t_get_pad" style="min-height:83px;">
                	<div class="col-md-18">
                        <div class="col-xs-18 tour_cat">Get Tours For Couples</div>
                    </div>
                 </div>
             </div>
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 tour_addon">
            	<div class="col-md-8 nopadding family_img"></div>
                <div class="col-md-10 t_get_pad" style="min-height:83px;">
                	<div class="col-md-18">
                        <div class="col-xs-18 tour_cat">Get Tours For Family</div>
                    </div>
                 </div>
             </div> 
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 tour_addon">
            	<div class="col-md-8 nopadding team_img"></div>
                <div class="col-md-10 t_get_pad" style="min-height:83px;">
                	<div class="col-md-18">
                        <div class="col-xs-18 tour_cat">Get Tours For Teams</div>
                    </div>
                 </div>
             </div> 
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 tour_addon">
            	<div class="col-md-8 nopadding school_img"></div>
                <div class="col-md-10 t_get_pad" style="min-height:83px;">
                	<div class="col-md-18">
                        <div class="col-xs-18 tour_cat">Get Tours For Schools</div>
                    </div>
                 </div>
             </div>  
            
        </div>
   </div>
            </div>
        </div>
    </div>
</div>

    
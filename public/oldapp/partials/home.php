<div class="col-xs-18 search-tool">
    <form>
    	<!-- <div class="col-xs-18 form-control trans_input" ng-show="curr_search.service=='Flights' && searchinit">
        	<div  class="col-xs-9 col-md-3 col-md-offset-6 fd-tab">
        		<div class="get_input col-xs-18">
            	<div class="col-xs-5 icon-Arrow38 flight_t" ng-class="{ft_active: getData[0].flightType==='OW'}" ng-click="getData[0].flightType='OW'"></div>
                <div class="col-xs-13" style="padding:0.35em 1em">One Way</div>
            </div>
            </div>
            <div  class="col-xs-9 col-md-3 fd-tab">
            	<div class="get_input col-xs-18">
            	<div class="col-xs-5 icon-Arrow-21 flight_t" ng-class="{ft_active: getData[0].flightType==='NF'}" ng-click="getData[0].flightType='NF'"></div>
                <div class="col-xs-13" style="padding:0.35em 1em">Round Trip</div>
            </div>
            </div>
        </div> -->
        <div class="col-xs-18 row">
            <div class="col-xs-8 col-xs-offset-5 flightt" ng-show="curr_search.service=='Flights' && searchinit">
            	<div  class="col-xs-6 fonw ftinact" ng-class="{ftactive: getData[0].flightType==='OW'}">
            		<div class="col-xs-18">
                	       <div class="col-xs-18"  ng-click="getData[0].flightType='OW'">One Way</div>
                    </div>
                </div>
                <div  class="col-xs-6 ftinact " ng-class="{ftactive: getData[0].flightType==='NF'}" >
                	<div class=" col-xs-18">
                    	<div class="col-xs-18" ng-click="getData[0].flightType='NF'">Return Trip</div>

                    </div>
                </div>
                <div  class="col-xs-6 fret ftinact " ng-class="{ftactive: getData[0].flightType==='MF'}" >
                	<div class=" col-xs-18">
                    	<div class="col-xs-18" ng-click="getData[0].flightType='MF'">Multiple Destination</div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-18 col-sm-7" ng-hide="curr_search.service=='Flights' && getData[0].flightType=='MF'">
            <div class="col-sm-18  each_form fsanim" id="from" ng-show="curr_search.service=='Flights' ">
                <label class="col-xs-7 col-md-6 get_pad hidden-sm">Leaving From</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input" ng-model="search.return" ng-click="searchinit=true;" placeholder="Type a Destination" id="from_complete" name="dep">
                    <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs"></span>
                </div>
            </div>
            <div class="col-sm-18 each_form fsanim" id="destination" ng-show="curr_search.service=='Hotels' || curr_search.service=='Tours' || searchinit ">
                <label class="col-xs-7 col-md-6 get_pad  hidden-sm">Going to</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input " ng-model="search.Dest"  ng-click="searchinit=true;" placeholder="Type a Destination" id="to_complete" name="des">
                    <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs"></span>
                </div>
            </div>
            <div class="col-sm-18 each_form fsanim" id="trans_pickup" ng-show="curr_search.service=='Flights'  && searchinit">
                <label class="col-xs-7 col-md-6 get_pad  hidden-sm">Flight Class</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <select class="col-xs-18 col-sm-15 form-control input-md trans_input" ng-model="fclass" required="required" ng-options="option.value as option.name for option in fclasses" ng-change="class_change(fclass)" ></select>
 				<span class="icon-ticket3 ic_sm_xx col-xs-3 hidden-xs"  ></span>
                </div>
            </div>
            <div class="col-sm-18 each_form fsanim" id="trans_pickup" ng-show="curr_search.service=='Transfers'">
                <label class="col-xs-7 col-md-6 get_pad  hidden-sm">Pick Up Location</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <select class="col-xs-18 col-sm-15 form-control  input-md trans_input" ng-model="pickupType" required="required" ng-init="pickupType='select'" ng-options="option.value as option.name for option in locationtype" ></select>
                    <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs"></span>
                </div>
                <div class="get_input col-sm-18 pull-right col-xs-11 col-md-12" ng-show="pickupType=='Hotel'">
                     <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input_sm" placeholder="Please Type Hotel Location" name="dep" id="transfer_hp_complete">
                </div>
                <div class="get_input col-sm-18 pull-right col-xs-11 col-md-12" ng-show="pickupType!='select'">
                    <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input_sm" placeholder="Please type a {{pickupType}} Code OR Name" name="dep" id="transfer_complete">
                </div>
            </div>
            <div class="col-sm-18 each_form fsanim" id="trans_destination" ng-show="curr_search.service=='Transfers' && searchinit">
                <label class="col-xs-7 col-md-6 get_pad  hidden-sm">Destination Location</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <select class="col-xs-18 col-sm-15 form-control  input-md trans_input" ng-model="destinationType" required="required" ng-init="destinationType='select'" ng-options="option.value as option.name for option in locationtype" ></select>
                    <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs"></span>
                </div>
                <div class="get_input col-sm-18 pull-right  col-xs-11 col-md-12" ng-show="destinationType=='Hotel'">
                     <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input_sm" placeholder="Please Type Hotel Location" name="des" id="transfer_hd_complete">
                </div>
                <div class="get_input col-sm-18 pull-right col-xs-11 col-md-12" ng-show="destinationType!='select'">
                    <input type="text" class="col-xs-18 col-sm-15 form-control  input-md trans_input_sm" placeholder="Please type a {{destinationType}} Code OR Name" name="des" id="transfer_complete_2">
                </div>
                <div class="nopadding col-sm-18 pull-right col-xs-11 col-md-12" ng-show="destinationType=='Terminal'  && searchinit">
                    <div class="pull-right time_label col-md-18">Flight / Bus / Train /Ship Departure Time</div>
                    <div class="get_input col-sm-18 pull-right col-xs-11 col-md-14">
                    	<input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="d_hr" value="01">
                        <input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="d_min" value="59">
                        <select class="col-xs-4 form-control day_month time_select input-md trans_input_sm" ng-model="dtimeType" required="required" ng-init="dtimeType='0'" ng-options="option.value as option.name for option in am_pm" >
                        </select>
                        <span class="icon-time nopadding ic_sm_xs col-xs-4 hidden-xs"></span>
                    </div>

                </div>
            </div>
            <div class="col-xs-18 each_form fsanim" ng-show="curr_search.service=='Transfers'  && searchinit">
                <label class="col-xs-7 col-md-6 get_pad" for="location1">Do you want a Return Transfer?</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <select class="col-xs-18 col-sm-15 form-control  input-md trans_input" ng-model="returnType" required="required" ng-init="returnType='Y'" ng-options="option.value as option.name for option in returntrans" ></select>
    				<span class="icon-get_car2 outer_ic ic_sm_xs col-xs-3 hidden-xs"><span class="icon-Arrow41 inner_ic ic_sm_xs col-xs-3"></span></span>
                </div>
            </div>
            <div class="col-sm-18 each_form fsanim"  id="rooms" ng-show="curr_search.service=='Hotels'  && searchinit ">
                <label class="col-xs-7 col-md-6 get_pad hidden-sm">Booking</label>
                <div class="get_input col-sm-18  col-xs-11 col-md-12">
                    <div class="col-xs-5 col-md-4 s_add_m">
                        <div ng-click="room_plus()">+</div>
                        <div ng-click="room_minus()">-</div>
                    </div>
                    <input type="text" class="col-xs-6 col-md-5 day_month input-md trans_input" ng-readonly="true" value="{{1+room_num|custNo }}" placeholder="01">
                    <span class="col-xs-7 col-md-5 s_label sh_l">Room</span>
                    <span class="icon-get_king-bed nopadding ic_sm col-md-4 hidden-xs"></span>
                </div>
            </div>
        </div>
        <div class="col-sm-11 col-xs-18 " ng-hide="curr_search.service=='Flights' && getData[0].flightType=='MF'">
            <div class="col-sm-9 xs_media">
                <!-- <div class="col-sm-18 each_form" id="date_from">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm ">
                        <span ng-if="getData[0].flightType!='OW'">From</span>
                        <span ng-if="getData[0].flightType=='OW'">On</span>
                        <input type="text" id="fromdate" class="datepicker_dummy" date-from />
                    </label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <input type="text" class="col-xs-5 col-md-4 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_day"  id="h_from_date" placeholder="01" name="" >
                        <input type="text" class="col-xs-7 col-md-5 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_month"  id="h_from_month" placeholder="July" name="">
                        <input type="text" class="col-xs-6 col-md-6 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_year"  id="h_from_year" placeholder="2015" name="">

                        <span ng-click="setfromdate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3 hidden-xs"></span>
                    </div>
                    <div class="col-sm-18 pull-right fsanim" ng-show="curr_search.service=='Transfers'  && searchinit">
                        <div class="pull-right time_label col-md-18">Pick-up Time</div>
                        <div class="get_input col-sm-18 pull-right col-xs-11 col-md-14">
                        	<input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="t_hr" value="01">
                            <input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="t_min" value="59">
                            <select class="col-xs-4 form-control day_month time_select input-md trans_input_sm" ng-model="ptimeType" required="required" ng-init="ptimeType='0'" ng-options="option.value as option.name for option in am_pm" >
                            </select>
                            <span class="icon-time nopadding ic_sm_xs col-xs-4 hidden-xs"></span>
                        </div>
                    </div>
                </div> -->

                <div class="col-sm-18 each_form fsanim" id="adult" ng-show="searchinit">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm">For</label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <div class="col-xs-5 col-md-4 s_add_m">
                            <div ng-click="room[0][1]=room[0][1]+1">+</div>
                            <div ng-click="room[0][1]=room[0][1]-1">-</div>
                        </div>
                        <input type="text" class="col-xs-7 col-md-5 day_month input-md trans_input" ng-readonly="true" value="{{room[0][1]|custNo}}" placeholder="01">
                        <span class="col-xs-6 col-md-5 s_label sh_l">Adult</span>
                        <span class="icon-get_man ic_sm col-xs-1 hidden-xs"></span>
                        <span class="icon-get_woman nopadding ic_sm col-xs-1 hidden-xs"></span>
                    </div>
                </div>
                <!--<div class="col-sm-18 each_form fsanim" id="elder" ng-show="curr_search.service=='Flights'">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm">And</label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <div class="col-xs-5 col-md-4 s_add_m">
                            <div ng-click="room[0][1]=room[0][1]+1">+</div>
                            <div ng-click="room[0][1]=room[0][1]-1">-</div>
                        </div>
                        <input type="text" class="col-xs-7 col-md-4 day_month input-md trans_input" ng-readonly="true" placeholder="00">
                        <span class="col-xs-6 col-md-6 s_label sh_l">Elder</span>
                        <span class="icon-get_elder-man ic_sm col-xs-1 hidden-xs"></span>
                        <span class="icon-get_elder-woman nopadding ic_sm col-xs-1 hidden-xs"></span>
                    </div>
                </div>-->
            </div>
            <div class="col-sm-9 xs_media">
                <!-- <div class="col-sm-18 each_form fsanim" id="date_to" ng-hide="curr_search.service=='Flights' && getData[0].flightType=='OW'">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm">Until <input type="text" id="todate" class="datepicker_dummy" date-to /></label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <input type="text" class="col-xs-5 col-md-4 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_day"  id="h_to_date" placeholder="01">
                        <input type="text" class="col-xs-7 col-md-5 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_month"  id="h_to_month" placeholder="Dec">
                        <input type="text" class="col-xs-6 col-md-6 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_year"  id="h_to_year" placeholder="2015">
                        <span ng-click="settodate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3 hidden-xs"></span>
                    </div>
                    <div class="col-sm-18 " ng-show="curr_search.service=='Transfers' && searchinit">
                    <div class="pull-right time_label col-md-18">Pick-up Time</div>
                    <div class="get_input pull-right col-sm-18  col-xs-11 col-md-14">
                    	<input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="r_hr" value="01">
                        <input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input_sm" ng-model="r_min" value="59">
                        <select class="col-xs-4 form-control day_month time_select input-md trans_input_sm" ng-model="rtimeType" required="required" ng-init="rtimeType='0'" ng-options="option.value as option.name for option in am_pm" >
                        </select>
                        <span class="icon-time nopadding ic_sm_xs col-xs-4 hidden-xs"></span>
                    </div>

                </div>
                </div> -->

                <div class="col-sm-18 each_form fsanim" id="kid" ng-show="searchinit">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm">And</label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <div class="col-xs-5 col-md-4 s_add_m">
                            <div ng-click="room[0][2].push([])">+</div>
                            <div ng-click="room[0][2].pop([])">-</div>
                        </div>
                        <input type="text" class="col-xs-7 col-md-5 day_month input-md trans_input" ng-readonly="true" value="{{room[0][2].length|custNo}}" id="child1" placeholder="01">
                        <span class="col-xs-6 col-md-5 s_label sh_l">Kid</span>
                        <span class="icon-get_boy ic_sm col-xs-1  hidden-xs"></span>
                        <span class="icon-get_girl nopadding ic_sm col-xs-1  hidden-xs"></span>
                    </div>
                </div>
                <div class="nopadding col-xs-6" ng-repeat="child in room[0][2]">
                	<div class="col-xs-18" ng-show="curr_search.service!='Flights'">
                        <span class="col-xs-18 nopadding child_select"><label>Child {{$index+1}}: Age</label></span>
                        <select class="col-xs-18 form-control get_pad input-sm" ng-model="room[0][2][$index]">
                            <option value="0" selected="selected">Select Age</option>
                            <option value="0">0-11 Months</option>
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
                    <div class="col-xs-18" ng-show="curr_search.service=='Flights'">
                    	<span class="col-xs-18 nopadding child_select"><label>Child {{$index+1}}</label></span>
                        <div class="get_input col-xs-18">
                        	<input type="text" ng-model="room[0][2][$index]" class="form-control trans_input_sm input-sm" placeholder="Date of Birth" birth-dchild >
                        </div>
                     </div>
                </div>
            </div>

            <div class="col-md-18 " ng-repeat="eachroom in rooms">
                <span class="child_select"><label class="">{{eachroom.label}}</label></span>
                <div class="row nopadding">
                    <div class="col-sm-9 xs_media each_form fsanim" >
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm">For</label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <div class="col-xs-5 col-md-4 s_add_m">
                            <div ng-click="room[eachroom.room_no][1]=room[eachroom.room_no][1]+1">+</div>
                            <div ng-click="room[eachroom.room_no][1]=room[eachroom.room_no][1]-1">-</div>
                        </div>
                        <input type="text" class="col-xs-6 col-md-4 day_month input-md trans_input" ng-readonly="true" value="{{room[eachroom.room_no][1]|custNo}}" id="{{room.adultid}}"  ng-init="room[eachroom.room_no][1]=room[eachroom.room_no][1]+1" placeholder="01" name="">
                        <span class="col-xs-6 col-md-5 s_label sh_l">Adult</span>
                        <span class="icon-get_man ic_sm col-xs-1  hidden-xs"></span>
                        <span class="icon-get_woman nopadding ic_sm col-xs-1  hidden-xs"></span>
                    </div>
                </div>
                    <div class="col-sm-9 xs_media each_form fsanim" >
                        <label class="col-xs-7 col-md-4 get_pad hidden-sm">And</label>
                        <div class="get_input col-sm-18  col-xs-11 col-md-14">
                            <div class="col-xs-5 col-md-4 s_add_m">
                                <div ng-click="room[eachroom.room_no][2].push([])">+</div>
                                <div ng-click="room[eachroom.room_no][2].pop([])">-</div>
                            </div>
                            <input type="text" class="col-xs-6 col-md-4 day_month input-md trans_input" ng-readonly="true" value="{{room[eachroom.room_no][2].length|custNo}}" id="{{room.childid}}" placeholder="01">
                            <span class="col-xs-6 col-md-5 s_label sh_l">Kid</span>
                            <span class="icon-get_boy ic_sm col-xs-1  hidden-xs"></span>
                            <span class="icon-get_girl nopadding ic_sm col-xs-1  hidden-xs"></span>
                        </div>
                        <div class="nopadding col-xs-6"  ng-repeat="child in room[eachroom.room_no][2]">
                        <span class="col-xs-18 nopadding child_select"><label>Child {{$index+1}}: Age</label></span>
                        <select class="col-xs-18 form-control get_pad input-sm" ng-model="room[eachroom.room_no][2][$index]">
                            <option value="0" selected="selected">Select Age</option>
                            <option value="0">0-11 Months</option>
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
            </div>
            </div>
        </div>
        <div class="col-xs-18" ng-init="initSearch()">
            <div class="col-xs-8 col-xs-offset-5 flightt" ng-if="defaultSearch.moduleType!='regular'">
            	<div  class="col-xs-6 ftinact"  ng-repeat="type in searchObject.typeBreak" id="to_complete" ng-class="typeClasses($index, type.value, searchObject.typeBreak.length-1, defaultSearch.moduleType)">
            		<div class="col-xs-18">
                	       <div class="col-xs-18"  ng-click="moduleChangeType(type)" ng-bind="type.name"></div>
                    </div>
                </div>
            </div>
            <div ng-repeat="input in defaultSearch.moduleCurrType">
                <div class="col-xs-18" ng-if="!(input | isArray)">
                    <div class="col-xs-9" ng-if="input.type=='place'">
                        <div class="get_input col-sm-18  col-xs-11 col-md-9">
                            <input type="text" class="col-xs-18 col-sm-15 form-control input-md trans_input placeSearch" ng-init="setlocators()" ng-model="input.value.name" placeholder="Type a {{input.name}}" name="{{$index}}">
                            <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs"></span>
                        </div>
                    </div>
                    <div class="col-xs-9" ng-if="input.type=='date'">
                        <label class="col-xs-7 col-md-4 get_pad hidden-sm" >
                            <span ng-bind="input.name" ></span>
                            <input type="text" ng-if="input.subType=='fromdate'" name="f" class="{{input.subType}} datepicker_dummy" date-from />
                            <input type="text" ng-if="input.subType=='todate'" name="f"  class="{{input.subType}} datepicker_dummy" date-to />
                        </label>
                        <div class="get_input col-sm-18  col-xs-11 col-md-14" ng-if="input.subType=='fromdate'"  name="f" >
                            <input type="text" class="col-xs-5 col-md-4 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="input.value.day"   placeholder="01"   name="" >
                            <input type="text" class="col-xs-7 col-md-5 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="input.value.month" placeholder="July" name="">
                            <input type="text" class="col-xs-6 col-md-6 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="input.value.year"   placeholder="2015" name="">
                            <span  ng-click="setfromdate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3 hidden-xs"></span>
                        </div>
                        <div class="get_input col-sm-18  col-xs-11 col-md-14" ng-if="input.subType=='todate'"  name="f">
                            <input type="text" class="col-xs-5 col-md-4 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="input.value.day"   placeholder="01"   name="" >
                            <input type="text" class="col-xs-7 col-md-5 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="input.value.month"   placeholder="01"   name="">
                            <input type="text" class="col-xs-6 col-md-6 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="input.value.year"   placeholder="01"   name="">

                            <span ng-click="settodate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3 hidden-xs"></span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-18" ng-if="input | isArray">
                    <div class="col-xs-18" ng-repeat="inp in input track by $index">
                        <div class="col-xs-18" ng-repeat="form in inp track by $index">
                            <div class="col-xs-9" ng-if="form.type=='place'">
                                <div class="get_input col-sm-18  col-xs-11 col-md-9">
                                    <input type="text" class="col-xs-18 col-sm-15 form-control input-md trans_input placeSearch" ng-init="setlocators()" ng-model="form.value.name" placeholder="Type a {{form.name}}"  name="{{$parent.$parent.$index}}|{{$index}}">
                                    <span class="icon-get_map-pin ic_sm col-xs-3 nopadding hidden-xs" ></span>
                                </div>
                            </div>
                            <div class="col-xs-9" ng-if="form.type=='date'">
                                <label class="col-xs-7 col-md-4 get_pad hidden-sm " >
                                    <span ng-bind="form.name" ></span>
                                    <input type="text" class="{{form.subType}} datepicker_dummy"   name="{{$parent.$parent.$index}}" date-from />
                                </label>
                                <div class="get_input col-sm-18  col-xs-11 col-md-14" >
                                    <input type="text" class="col-xs-5 col-md-4 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="form.value.day"  id="h_from_date" placeholder="01" name="" >
                                    <input type="text" class="col-xs-7 col-md-5 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="form.value.month"  id="h_from_month" placeholder="July" name="">
                                    <input type="text" class="col-xs-6 col-md-6 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="form.value.year"  id="h_from_year" placeholder="2015" name="">
                                    <span ng-click="setfromdate(form)" class="icon-get_calendar nopadding ic_sm_s col-xs-3 hidden-xs"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-18" ng-click="addMoreDes(input)">Add more destination</div>
                </div>
            </div>
            <div ng-repeat="input in currentProGuest">
                <div class="col-sm-18 each_form fsanim" name="{{input.name}}">
                    <label class="col-xs-7 col-md-4 get_pad hidden-sm"></label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-14">
                        <div class="col-xs-5 col-md-4 s_add_m">
                            <div ng-click="input.value=input.value+1">+</div>
                            <div ng-click="input.value=input.value-1">-</div>
                        </div>
                        <input type="text" class="col-xs-7 col-md-5 day_month input-md trans_input" ng-readonly="true" value="{{input.value|custNo}}" placeholder="01">
                        <span class="col-xs-6 col-md-5 s_label sh_l" ng-bind="input.name"></span>

                        <span ng-if="input.name=='Adult'" class="icon-get_man ic_sm col-xs-1 hidden-xs"></span>
                        <span ng-if="input.name=='Adult'" class="icon-get_woman nopadding ic_sm col-xs-1 hidden-xs"></span>
                        <span ng-if="input.name=='Child'" class="icon-get_boy ic_sm col-xs-1 hidden-xs"></span>
                        <span ng-if="input.name=='Child'" class="icon-get_girl nopadding ic_sm col-xs-1 hidden-xs"></span>
                    </div>
                </div>
            </div>
            <div ng-repeat="input in currentProOthers">
                <div class="col-sm-18 each_form fsanim" ng-if="input.type=='select'" name="{{input.name}}">
                    <label class="col-xs-7 col-md-6 get_pad  hidden-sm" ng-bind="input.name"></label>
                    <div class="get_input col-sm-18  col-xs-11 col-md-12">
                        <select class="col-xs-18 col-sm-15 form-control input-md trans_input" ng-model="input.value" required="required" ng-options="option.value as option.name for option in input.options" ng-change="class_change(input.value)" ></select>
     				    <span class="icon-ticket3 ic_sm_xx col-xs-3 hidden-xs"  ></span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xs-18 s_butt">
            <div class="col-sm-offset-14 col-xs-18 col-sm-4 get_button_primary btn-lg  " ng-click="setSearch()">Search for {{curr_search.service}}</div>
        </div>
    </form>
</div>

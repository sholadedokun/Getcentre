<div class="col-xs-18 search_result partial_view">
    <div class="col-xs-18 search_bar">
        <div class="col-xs-12">Search Result for Tours in {{search_c.hdesdesc}} <input type="hidden" id="new_list" ng-model="new_list" value="{{tours | orderBy:sort}}" /></div>
        <div class="col-xs-6">Sort Result</div>
    </div>
    <div class="col-xs-18  update_search">
        <div class="col-xs-18 col-sm-6"> 
            <div class="col-xs-18"><label>I'm Going to</label></div>
            <div class="nopadding get_input col-sm-18  col-xs-11">
                <input type="text" class="col-xs-15 col-sm-15 form-control  input-md trans_input" ng-model="Dest" placeholder="Type a Destination" id="to_complete" name="des">
                <span class="icon-get_map-pin ic_sm col-xs-3 nopadding"></span>
            </div>
        </div>
        <div class="col-xs-9  col-sm-4">
            <div class="col-xs-18"><label>From<input type="text" id="fromdate" class="datepicker_dummy" date-from /></label></div>
            
            <div class="nopadding get_input col-sm-18  col-xs-11">
                <input type="text" class="col-xs-4 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_day"  id="h_from_date" placeholder="01" name="" >
                <input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_month"  id="h_from_month" placeholder="July" name="">
                <input type="text" class="col-xs-6 form-control day_month get_pad input-md trans_input" ng-click="setfromdate()" ng-model="f_year" id="h_from_year" placeholder="2015" name="">
               
                <span ng-click="setfromdate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3"></span>
            </div>
        </div>
        <div class="col-xs-9 col-sm-4">
            <div class="col-xs-18"><label>Until<input type="text" id="todate" class="datepicker_dummy" date-to /></label></div>
            <div class="nopadding get_input col-sm-18  col-xs-11">
                        <input type="text" class="col-xs-4 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_day"  id="h_to_date" placeholder="01">
                        <input type="text" class="col-xs-5 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_month"  id="h_to_month" placeholder="Dec">
                        <input type="text" class="col-xs-6 form-control day_month get_pad input-md trans_input" ng-click="settodate()" ng-model="t_year"  id="h_to_year" placeholder="2015">
                        <span ng-click="settodate()" class="icon-get_calendar nopadding ic_sm_s col-xs-3"></span>
                    </div>
        </div>
        <div class="col-xs-9 col-sm-4">
            <label>&nbsp;</label>
            <div class=" col-xs-offset-0 col-xs-9 col-sm-18 get_button_primary btn-lg"  ng-click="setSearch()">Update Search</div>
        </div>
        <div class="col-xs-18 change_occu"> <span class="cha_label">For :</span> {{search_c.hAdult}} Adults <span ng-if="search_c.fChild>0">{{search_c.hChild}} Kids</span><span class="cha_action"> (Change Guests)</span></div>
    </div>
    <div class="col-md-5 filter_s">
        <div class="col-md-18 s_info">
            <p>Your Search returned <span>{{tours_total}} tours</span> From</p> 
            <p class="sf_price"> <sup class="curr" ng-bind-html="convS"></sup><span>{{lowest_price | currencyConvert | number:2}}</span></p>
            <span>Use the field below to refine your search</span>
            
        </div>
        <ul class="col-md-18 s_filter">
            <li class="col-md-18 pr_item">
                <div class="col-md-18"><label>Price</label></div>
                <div class="get_input col-md-5 col-xs-6">
                    <input type="text" class="col-md-18 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="from" name="">
                </div>
                <div class=" get_input col-md-offset-1 col-md-5 col-xs-6">
                    <input type="text" class="col-md-18 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="to" name="">
                </div>
                <div class="col-xs-18 col-md-7">
                    <div class="col-md-18 get_button_primary btn-lg">Apply</div>
                </div>
            </li>
            <li class="col-md-18 sf_item">
            	<div class="col-md-18 service_list">
                    <div class="col-md-15">Tour Name</div>
                    <div class="col-md-3"><span class="add_icon plus_ic ">+</span><span class="add_icon minus_ic hideme">-</span></div>
                </div>
                <div class="col-md-18 s_input">
                    <input type="text" class="col-md-18 form-control input-sm  get_input trans_input_sm" ng-model="tour_name" placeholder="Type Tour Name" name="">
                </div>
            </li>
            <li class="col-md-18 sf_item">
            	<div class="col-md-18 service_list">
                    <div class="col-md-15">Tour Types</div>
                    <div class="col-md-3"><span class="add_icon plus_ic ">+</span><span class="add_icon minus_ic hideme">-</span></div>
                </div>
                <div class="col-md-18 s_input">
                	<select class="col-sm-18 nopadding get_input input-sm" ng-model="pInt" ng-options="option.pofinterest as option.pofinterest for option in hprox | unique: 'pofinterest' | lowercase"></select>
                </div>
            </li>
            <li class="col-md-18 sf_item">
            	<div class="col-md-18  service_list">
                    <div class="col-md-15">Tour Category</div>
                    <div class="col-md-3"><span class="add_icon plus_ic ">+</span><span class="add_icon minus_ic hideme">-</span></div>
                </div>
                <div class="col-md-18 s_input">
                	<select class="col-sm-18 nopadding get_input input-sm"  ng-model="pChain" ng-options="option.hchainname as option.hchainname for option in hchain | unique: 'hchainname' | lowercase"></select>
                </div>
            </li>
        </ul>
    </div>
    <div class="col-md-13 list_holder">
    	<div class="col-md-18 main_list" ng-repeat="tour in tours | orderBy:sort">
        <div class="col-md-4 img_holder nopadding link"><img src="{{tour.TicketInfo.ImageList.Image[0].Url | imglarge}}" ng-click="settour_details($event, $index)" width="100%" height="100%" /></div>
        <div class="col-md-10 hdetails">
            <div class="col-md-18 h_title nopadding link" ng-click="settour_details($event, $index)">{{tour.TicketInfo.Name | limitTo:55 }}</div>
            <div class="col-md-18 map_shdetails">{{search_c.hdesdesc}} <span><a href="#">Show Map</a></span></div>
            <div class="col-md-18 h_details">{{tour.TicketInfo.DescriptionList.Description.$ | limitTo:150 }}...</div>
            <div class="col-md-18 r_v_c">
                {{tour.TicketInfo.Segmentation.SegmentationGroup[0].Segment.Name}}
            </div>
        </div>
        <div class="col-md-4 price_action t_list" ng-if="tour.AvailableModality[0]['@code']">
            <div class="f_price"> <span class="icon-get_man ic_sm f_ic_guest "></span> <sup class="curr_book" ng-bind-html="convS"></sup><span>{{tour.AvailableModality[0].PriceList.Price[0].Amount | currencyConvert | number:2}}</span></div>
            <div class="f_price"> <span class="icon-get_boy ic_sm f_ic_guest "></span> <sup class="curr_book" ng-bind-html="convS"></sup><span>{{tour.AvailableModality[0].PriceList.Price[1].Amount | currencyConvert | number:2}}</span></div>
            <div class="v_details link" ng-click="settour_details($event, $index)">View Details</div>
            <div class="book_but col-md-18 get_button_primary btn"  ng-click="book_tour(tour, 0, 0)">Book</div>             
        </div>
        <div class="col-md-4 price_action t_list" ng-if="tour.AvailableModality['@code']">
            <div class="f_price"> <span class="icon-get_man ic_sm f_ic_guest "></span> <sup class="curr_book" ng-bind-html="convS"></sup><span>{{tour.AvailableModality.PriceList.Price[0].Amount | currencyConvert | number:2}}</span></div>
            <div class="f_price"> <span class="icon-get_boy ic_sm f_ic_guest "></span> <sup class="curr_book" ng-bind-html="convS"></sup><span>{{tour.AvailableModality.PriceList.Price[1].Amount | currencyConvert | number:2}}</span></div>
            <div class="v_details">View Details</div>
            <div class="book_but col-md-18 get_button_primary btn" ng-click="book_tour(tour, 0, 0)">Book</div>             
        </div>
        <div class="col-md-18 room_spec">
            <div class="col-md-5 nopadding">{{tour.AvailableModality | first_c}}</div>
            <div class="col-md-4 nopadding">{{tour.AvailableModality | first_d}}</div>
            <div class="col-md-3 nopadding"><span class="curr_book" ng-bind-html="convS"></span>{{tour.AvailableModality | peradult  | currencyConvert | number:2}}/adult</div>
            <div class="col-md-6 nopadding board_types">
            	<div class="col-md-18" tourvaluate tourz="{{tour}}" name="{{$index}}" >
                    <span class="add_icon plus_ic ">+</span><span class="add_icon minus_ic hideme">-</span>
                    <a class="special_link plus_ic ">View Other Tour Options/Dates</a>
                    <a class="special_link minus_ic hideme">Hide Other Tour Options/Dates</a>
                </div>
            </div>
        </div>
    </div>
    <div class="loading_note" ng-if="load_note" loading></div>
    </div>
</div>
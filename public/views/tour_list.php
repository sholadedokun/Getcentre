<div class="container searchPage">


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

<div class="col-xs-18 search_result partial_view">
    <div class="col-xs-18 search_bar">
        <div class="col-xs-12">Search Result for Transfers in {{search_c.hdesdesc}} <input type="hidden" id="new_list" ng-model="new_list" value="{{transfers | orderBy:sort}}" /></div>
        <div class="col-xs-6">Sort Result</div>
    </div>
    <div class="col-xs-18 update_search">
        <div class="col-xs-18 col-sm-6">
            <div class="col-xs-18"><label>I'm Going to</label></div>
            <div class="nopadding get_input col-sm-18  col-xs-11">
                <input type="text" class="col-xs-15 col-sm-15 form-control form_pad input-md trans_input" ng-model="search.Dest" placeholder="Type a Destination" name="">
                <span class="icon-get_map-pin ic_sm col-xs-3 nopadding"></span>
            </div>
        </div>
        <div class="col-xs-9  col-sm-4">
            <div class="col-xs-18"><label>From</label></div>
            <div class="nopadding get_input col-sm-18  col-xs-11 ">
                <input type="text" class="col-xs-4 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="01" name="">
                <input type="text" class="col-xs-5 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="Dec" name="">
                <input type="text" class="col-xs-5 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="2015" name="">
                <span class="icon-get_calendar nopadding ic_sm col-xs-4"></span>
            </div>
        </div>
        <div class="col-xs-9 col-sm-4">
            <div class="col-xs-18"><label>Until</label></div>
            <div class="nopadding get_input col-sm-18  col-xs-11">
                <input type="text" class="col-xs-4 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="01" name="">
                <input type="text" class="col-xs-5 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="Dec" name="">
                <input type="text" class="col-xs-5 form-control form_pad input-md trans_input" ng-model="search.D" placeholder="2015" name="">
                <span class="icon-get_calendar nopadding ic_sm col-xs-4"></span>
            </div>
        </div>
        <div class="col-xs-9 col-sm-4">
            <label>&nbsp;</label>
            <div class=" col-xs-offset-0 col-xs-9 col-sm-18 get_button_primary btn-lg">Update Search</div>
        </div>
        <div class="col-xs-18 change_occu"> <span class="cha_label">Your are currently booking :</span> {{search_c.hTotalroom}} Airport Transfer for {{search_c.hAdult}} Adults and {{search_c.hChild}} children<span class="cha_action"> (Change Tourist)</span></div>
    </div>
    <div class="col-md-5 filter_s">
        <div class="col-md-18 s_info">
            <p>Your Search returned <span>{{transfers_total}} transfers</span> From</p> 
            <p class="sf_price"> <sup class="curr"  ng-bind-html="convS"></sup><span>650.02</span></p>
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
                <div class="col-md-14">Vehicle Type</div>
                <div class="col-md-3 icon-play"></div>
            </li>
            <li class="col-md-18 sf_item">
                <div class="col-md-14">Tour Types</div>
                <div class="col-md-3 icon-play"></div>
            </li>
            <li class="col-md-18 sf_item">
                <div class="col-md-14">Accomodation Type</div>
                <div class="col-md-3 icon-play"></div>
            </li>
            <li class="col-md-18 sf_item">
                <div class="col-md-14">Board</div>
                <div class="col-md-3 icon-play"></div>
            </li>
        </ul>
    </div>
    <div class="col-md-13 list_holder">
    	<div class="col-md-18 main_list" ng-repeat="transfer in transfers | orderBy:sort">
        <div class="col-md-4 img_holder nopadding"><img src="{{transfer.TransferInfo.ImageList.Image[2].Url | imglarge}}" width="100%" height="100%" /></div>
        <div class="col-md-10 hdetails">
            <div class="col-md-18 h_title nopadding">{{transfer.ProductSpecifications.MasterProductType['@name'] | limitTo:55 }} {{transfer.ProductSpecifications.MasterServiceType['@name'] | limitTo:50}} ({{transfer.ProductSpecifications.MasterVehicleType['@name'] | limitTo:50}})</div>
            <div class="col-md-18 h_details">
            	<ul class="col-md-18">
                    <li class="col-md-9" ng-repeat="bullet in transfer.ProductSpecifications.TransferGeneralInfoList.TransferBulletPoint">
                        {{bullet.Description}}
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="col-md-4 price_action " >
            <div class="m_price"> <sup class="curr_book" ng-bind-html="convS"></sup><span>{{transfer.TotalAmount  | currencyConvert | number:2}}</span></div>
            <div class="p_det">Trip/Vehicle</div>
            <div class="v_details">&nbsp;</div>
            <div class="book_but col-md-18 get_button_primary btn" ng-click="book_transfer(transfer)">Select Vehicle</div>            
        </div>
        <div class="col-md-18 room_spec">
            <div class="col-md-18 nopadding">{{transfer.PickupLocation.Name}}<span class="s_label">To</span> {{transfer.DestinationLocation.Name}}</div>
        </div>
        
        <!--<div class="col-md-18 nopadding hideme"></div>-->
    </div>
    </div>
</div>
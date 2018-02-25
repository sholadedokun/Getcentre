<div class="container">
    <div class="col-xs-18 search_bar">
        <div class="col-xs-18 col-md-14"><h3>{{t.name}}</h3></div>
        <div class="col-xs-18 col-md-4">
        	 <label class="col-xs-18" style="padding:0.4em 0 0 0" for="sorting">Return to Search List</label>
        </div>
    </div>
    <div class="col-xs-18 col-md-11 nopadding">
    	<div class="col-xs-18 img_slide nopadding">
        	<div class="col-xs-18 img_holder_lg nopadding">
            	<img src="{{mainImageUrl | imglarge}}" width="100%" height="100%" />
            </div>
            <div class="col-xs-18 nopadding thumb_hold">
                <div id="thumb_load">
                    <div class="hthumb" name="{{$index}}" ng-repeat="thumb in allpict" ng-if="$even">
                        <img ng-src="{{thumb.Url}}" ng-click="setImage(thumb, $index)" width="90" height="60" />
                    </div>
                </div>
                <div class="col-xs-18">
                	<span class="col-xs-3 col-md-1 get_pad slide_arrow" id="left_th"><</span>
                    <span class="col-xs-12 col-md-16 get_pad slide_num">{{curr_pic}} <span class="s_label">of</span> {{allpict.length}}</span>
                    <span class="col-xs-3 col-md-1 get_pad slide_arrow" id="right_th">></span>
                </div>
            </div>
        </div>
        <div class="col-xs-18 hdetails nopadding">
        	<div class="col-xs-18 col-md-14 search_result">
                <div class="col-xs-18 col-md-12 h_title nopadding"><h3>{{t.name}}</h3></div>
                <div class="col-xs-18 col-md-6 h_rate">
                    <span class="icon-star"></span>
                    <span class="icon-star"></span>
                    <span class="icon-star"></span>
                    <span class="icon-star"></span>
                </div>
                <div class="col-xs-18 map_shdetails">{{t.destination}} <span><a href="#">Show Map</a></span></div>
                <div class="col-xs-18 h_details" ng-bind-html='t.brief'></div>
                <div class="col-xs-18 search_result" ng-repeat="segment in t.segment">
                <b><h3><span ng-bind="segment.Name"></span></h3></b>
                <div class="" ng-if="segment.Name !='Activity for'">
                {{segment.Segment.Name}}
                </div>
                <div class="" ng-if="segment.Name =='Activity for'">
                <div ng-repeat="forS in segment.Segment">
                	{{forS.Name}}
                </div>
                </div>
            </div>
            </div>
            </div>
            <div class="col-md-18 view_all_boards">
    <div class="col-md-18 all_boards">
        <div class="col-md-12 nopadding">
            <div class="col-md-8 nopadding">Category</div>
            <div class="col-md-6 nopadding">Available dates</div>
            <div class="col-md-4 nopadding">Price/Adult</div>
        </div>
        <div class="col-md-6 nopadding">Total Price</div>
    </div>
    <div class="col-md-18" ng-show="isArray(getTour[0].AvailableModality)">
    	<div class="col-md-18 nopadding" ng-repeat="eachtour in  getTour[0].AvailableModality" >
        <form>
        <div class="col-md-12 room_spec">
            <div class="col-md-8 room_type">{{eachtour.Name}}</div>
            <div class="col-md-6 get_pad" ng-show="isArray(eachtour.OperationDateList.OperationDate)">
                <div class="col-md-18 get_pad  get_input room_type">
                    <select class="input_xs col-md-18" ng-model="Selecteddate" ng-change="tour_date(Selecteddate)" ng-options="datety['@date'] as (datety['@date'] | hdate) for datety in eachtour.OperationDateList.OperationDate " ng-init="Selecteddate = eachtour.OperationDateList.OperationDate[0]['@date']"    >
                    </select>
                </div>
            </div>
            <div class="col-md-6 get_pad" ng-show="!isArray(eachtour.OperationDateList.OperationDate)">
                <div class="col-md-18 get_pad  get_input room_type">
                	<div ng-model="Selecteddate">{{eachtour.OperationDateList.OperationDate['@date'] | hdate}}</div>

                </div>
            </div>
            <div class="col-md-4 get_pad"><span class="curr_book" ng-bind-html="convS"></span> {{eachtour.PriceList.Price[0].Amount  | currencyConvert | number:2}}</div>
        </div>
        <div class="col-md-6 t_price">
            <div class="col-md-18"><sup class="curr_book" ng-bind-html="convS">  </sup><span>{{eachtour.PriceList.Price[3].Amount  | currencyConvert | number:2}}</span></div>
            <div class="book_but pull-right col-md-6 get_button_primary btn-sm"  ng-click="book_tour(getTour[0], eachtour, Selecteddate)">Book</div>
        </div>
        </form>
    </div>
    </div>
    <div class="col-md-18" ng-show="!isArray(getTour[0].AvailableModality)">
    	<div class="col-md-18 nopadding">
        <div class="col-md-12 room_spec">
            <div class="col-md-8 room_type">{{getTour[0].AvailableModality.Name}}</div>
            <div class="col-md-6 get_pad" ng-show="isArray(getTour[0].AvailableModality.OperationDateList.OperationDate)">
                <div class="col-md-18 get_pad  get_input room_type">
                    <select class="input_xs col-md-18" ng-model="Selecteddate" ng-change="tour_date(Selecteddate)" ng-options="datety['@date'] as (datety['@date'] | hdate) for datety in getTour[0].AvailableModality.OperationDateList.OperationDate " ng-init="Selecteddate = getTour[0].AvailableModality.OperationDateList.OperationDate[0]['@date']"    >
                    </select>
                </div>
            </div>
            <div class="col-md-6 get_pad" ng-show="!isArray(getTour[0].AvailableModality.OperationDateList.OperationDate)">
                <div class="col-md-18 get_pad  get_input room_type">
                	<div ng-model="Selecteddate">{{getTour[0].AvailableModality.OperationDateList.OperationDate['@date'] | hdate}}</div>

                </div>
            </div>
            <div class="col-md-4 get_pad"><span class="curr_book"  ng-bind-html="convS"></span> {{getTour[0].AvailableModality.PriceList.Price[0].Amount  | currencyConvert | number:2}}</div>
        </div>
        <div class="col-md-6 t_price">
            <div class="col-md-18"><sup class="curr_book"  ng-bind-html="convS"></sup><span>{{getTour[0].AvailableModality.PriceList.Price[3].Amount  | currencyConvert | number:2}}</span></div>
            <div class="book_but pull-right col-md-6 get_button_primary btn-sm"  ng-click="book_tour(getTour[0], getTour[0].AvailableModality, Selecteddate)">Book</div>
        </div>
    </div>
    </div>

</div>
        </div>
    </div>
    <div class="loading_note" ng-if="load_note" loading></div>
</div>

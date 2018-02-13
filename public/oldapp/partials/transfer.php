<script>
	$(document).ready(function() { 
		$('.p_container').jScrollPane();
	})
</script>
<link type="text/css"  rel="stylesheet" href="css/autocomplete.css">
<link type="text/css"  rel="stylesheet" href="app/bower_components/getcentre/jquery-ui.css">
<div class="col-md-16 ">
	<div class="col-md-offset-4 col-md-14">
    	<div class="col-sm-12 t_head">
        	<div class="col-sm-18 t_head_mover nopadding">
            	<div class="col-sm-18 nopadding">
                    <div class="col-sm-12">
                        <h5>{{tours_total}} Cars found in {{getData[21].valueData| limitTo:45 }}</h5>
                        
                    </div>
                    <div class="col-md-6 btn get_button_primary" ng-click="changeDest()">Change Destination</div>
                </div>
                <div class="col-md-18 location_cover">
					<input type="text" id="tour_complete" class="form-control col-md-12 input-lg get_input f_location_input flight_complete" placeholder="Type Destination" name="dep"  style="margin:15px 0 0">
					<button class="col-md-6 btn get_button_primary" ng-click="searchDest()" style="margin:15px 0 0">Search</button>
				</div>
             </div>
        </div>
    </div>
    <div class="col-md-18 nopadding">
    	<div class="col-md-4 nopadding" style="min-height:285px">
        	<div class="col-md-18 ">
                <div class="col-md-18 login_title"><h4>Your Tour List</h4></div>
                <div class="col-md-18 tour_pack_list">
                    <div class="col-md-18">
                        <div class="col-md-18">
                            <div class="col-md-18">
                            	<label>Your Package Contains {{getTour.length}} Tours</label>
                                 <ul class="col-md-18 nopadding scroller_container">
                                    <li class="col-md-18" ng-repeat="tours in getTour" on-finish-render="ngRepeatFinished">
                                        <div class="room_spec">
                                            <div class="room_t_n_cont">
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
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-18"></div>
                        </div>
                        <div class="col-md-18" >
                       <a href="#/tours/tours_checkout" ><div class="col-md-18 pull-right btn get_button_primary">Get Package</div></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 t_product_cont">
        	<div class="col-sm-18">
        		<div class="col-md-6 t_search"><div>Search for a specific tour</div></div>
            	<div class="col-md-8 nopadding t_search"> 
            	<input type="text"  class="form-control input-sm get_input" placeholder="E.g Skydiving" id="tour_search">
            </div> 
        	</div>
        	<div class="t_container col-md-18" ng-controller="ModalCtrl" >
            	
                <div class="col-md-18 scroller_container">
                	<div class="col-md-18 list_compact" ng-repeat="tour in tours" on-finish-render="ngRepeatFinished">
                        <div class="col-md-18 " >
                            <div class="hotel_thumb_nail"><img  src="{{tour.TicketInfo.ImageList.Image[0].Url}}" width="70" height="70"/></div>
                            <div class="col-xs-18 hotel_list_container">
                                <div class="col-md-18  short_detail">
                                    <div class="col-xs-6 tour_desc">
                                        <div class="tour_title">{{tour.TicketInfo.Name | limitTo:55 }}</div>
                                        <div class="tour_dest">{{getData[21].valueData | limitTo:28 }}</div>
                                    </div>
                                    <div class="col-md-9 tour_summary">
                                    	{{tour.TicketInfo.DescriptionList.Description.$ | limitTo:150 }}
                                    </div>
                                    <div class="col-md-3 tour_add" ng-if="tour.AvailableModality[0]['@code']">
                                    	<div class="tour_price"><label>A:</label>£ {{tour.AvailableModality[0].PriceList.Price[0].Amount}}</div>
                                        <div class="tour_price"><label>C:</label>£ {{tour.AvailableModality[0].PriceList.Price[1].Amount}}</div>
                                    	<div class=" btn-sm btn get_button_primary" ng-click="opentourDetails(tour)">Add Tour</div>
                                    </div>
                                    <div class="col-md-3 tour_add" ng-if="tour.AvailableModality['@code']">
                                    	<div class="tour_price"><label>A:</label>£ {{tour.AvailableModality.PriceList.Price[0].Amount}}</div>
                                        <div class="tour_price"><label>C:</label>£ {{tour.AvailableModality.PriceList.Price[1].Amount}}</div>
                                    	<div class=" btn-sm btn get_button_primary" ng-click="opentourDetails(tour)">Add Tour</div>
                                    </div>
                                    
                                    <div class="col-md-18 p_stat">
                                    	<div class="col-md-12">{{tour.TicketInfo.Segmentation.SegmentationGroup[0].Segment.Name}}</div>
                                       <!-- <div class="col-md-5 col-md-offset-1" name="{{tour.AvailableModality['@attributes'].availToken}}"  ng-click="addTour($event)">View Details</div>-->
                                    </div>
                                    
                                </div>
                               
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
        <div class="col-md-4 nopadding">
	<div class="col-md-17 nopadding">
		<div class="col-md-18" style="min-height:305px">
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
	
<script type="text/ng-template" id="tourDetails.html">
	<link type="text/css"  rel="stylesheet" href="app/bower_components/getcentre/jquery-ui.css">
	<div class="col-md-18" style="min-height:230px; padding:1em 1.5em; position:relative;  background:#0fb6ba">
	<div class="col-md-18 nopadding" style="color:#fefefe; min-height:35px">
        <div class="col-xs-18 nopadding hotel_name" >{{tour.TicketInfo.Name}}</div>
    </div>
    <div class="col-md-18 nopadding">        
       <div class="col-md-6 nopadding">
       		<div class="col-md-18 nopadding">
				<div class="col-md-18 nopadding" style=" height:200px; background:#fff"><img ng-src="{{mainImageUrl}}" width="285" height="200" /></div>
				<div class="col-md-18 nopadding" style=" height:50px; padding:5px; overflow:hidden; position:relative; background:#eee">
					<div style="width:30000px; float:left; height:50px; left:0; position:relative; " id="thumb_load">                
						<div class="hthumb" name="{{$index}}" ng-repeat="thumb in tour.TicketInfo.ImageList.Image" ng-if="$even">                        
							<img ng-src="{{thumb.Url}}" ng-click="setImage(thumb.Url)" width="40" height="40" />
						</div>           
					</div>
					<div class="tc_mover" id="left_th" style="left:0px; display:none;" ng-click="move_left" ><img src="images/leftarr.png" width="12" height="38" /></div>
					<div class="tc_mover" id="right_th" style="right:0px" ng-click="move_right"><img src="images/rightarr.png" width="12" height="38" /></div>
				</div>
		   </div>
       </div>
       <div class="col-md-12 nopadding">
            <ul class="col-md-18 hotel_tab sm">
                <li class="active_tab  first_li"><a href="#">Tour Description</a></li>
                <li><a href="#">Tour Features</a></li>
                <li><a href="#">Location and Meeting point</a></li>
                <li class="last_li visible-lg">&nbsp;</li>             
            </ul>
            <div class="col-md-18 nopadding">
				<div class="col-md-11">
					<div class="col-md-18" style="overflow:hidden">
						<div class="col-md-18 h_descript">
							<div class="col-xs-18 hot_container nopadding">
								<div class="col-xs-18 hotel_container nopadding">
									<div class="col-xs-18 nopadding" style="height:140px">
										<div class="col-xs-18"><h4>General Description</h4></div>
										<div class="col-xs-18">{{tour.TicketInfo.DescriptionList.Description.$ }}</div>
									</div>
								</div>
							</div>                        
						</div>
					</div>
            	</div>
				<div class="col-md-7 nopadding">
					<div class="col-xs-18 tour_avail">Available Dates</div>
					<ul class="col-xs-18 nopadding">
						<li  class="col-xs-18 nopadding" ng-repeat="avail in tours">
							<label style="font-size:18px">								
								<input type="checkbox" ng-model="checktour[$index]" ng-change="selectedTours($index)">
								&nbsp;&nbsp; {{avail.DateFrom['@date'] | hdate}} 
							</label>
							<div class="col-xs-18">Adult({{adult_sel}}) {{avail.AvailableModality.PriceList.Price[4].Amount}} | Children({{child_sel}}) 
							{{avail.AvailableModality.PriceList.Price[5].Amount}}
							</div>
						</li>
					</ul>
				</div>
					
           </div>
        </div>
     </div>
</div>
<div class="modal-footer">
    <button class="btn get_button_primary" ng-click="ok()" style="margin:15px 0 0">Add Tour</button>
    <button class="btn get_button_warning" ng-click="cancel()" style="margin:15px 0 0">Cancel</button>
</div>
</script>
    
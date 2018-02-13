<link type="text/css"  rel="stylesheet" href="css/autocomplete.css">
<link type="text/css"  rel="stylesheet" href="app/bower_components/getcentre/jquery-ui.css">
<div class="col-md-16 ">
	<div class="col-md-18 nopadding">
    	<div class="col-md-5 nopadding" style="min-height:285px">
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
                                            <div class=" btn-sm pull-right btn get_button_primary" ng-click="addtourist($index)">Add Tourist Details</div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-13 t_product_cont" >
        	<div class="t_container col-md-10 nopadding" style="background:#eee">            	
                <div class="get_panel_heading2 col-md-18">
                	<div class="panel-title guest_top">Add Tourists</div>
                </div>
                <div class="col-md-18 get_panel" ng-switch on="selectTour">
                	<div class="col-md-18" ng-switch-when="selected">
                		<div class="col-md-18 get_pad" ng-repeat="guest in tourguest track by $index"> 
                        	<div class="col-xs-18 guest_tab nopadding" ng-show="getTour[selectedT][1]['@SPUI']!=null">
                            	<div class="col-xs-18 guest_head each_form">{{tourist[0].TicketInfo.Name}} | {{tourist[0].DateFrom['@date'] | hdate}}</label></div>
                                <div ng-hide="getTour[selectedT][2].hasOwnProperty()">
                                    <div class="col-md-18" ng-repeat="tourist in getTour[selectedT]" >
                                        <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[0]">
                                            <input type="text" class="form-control input-sm get_input" ng-model="each_guest[0]" placeholder="Adult Full Name" name="">
                                        </div>
                                        <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[1]">
                                            <input type="text" class="form-control input-sm get_input" ng-model="each_guest[0]" placeholder="Child Full Name" name="">
                                        </div>
                                        <div class=" btn-sm pull-right btn get_button_primary" ng-click="addTtourist($index, selectedT)">Add Tourist</div>
                                    </div>
                                </div>
                                <div ng-show="getTour[selectedT][2].hasOwnProperty()">
                                    
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[0]">
                                       Adult {{$index + 1}} : {{each_guest[0]}}
                                    </div>
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[1]">
                                       Child {{$index + 1}} : {{each_guest[0]}}
                                    </div>
                                    <div class=" btn-sm pull-right btn get_button_primary" ng-click="addTtourist($index, selectedT)">
                                        Edit Tourist Details</div>
                                </div>
                            </div>
                            <div class="col-xs-18 guest_tab nopadding" ng-show="getTour[selectedT][1].Image!=null">
                                <div class="col-xs-18 guest_head each_form">
                                	{{getTour[selectedT][0].TicketInfo.Name}} | <label>{{getTour[selectedT][0].DateFrom['@date'] | hdate}}</label>
                                </div>
                                <div ng-hide="getTour[selectedT][2].hasOwnProperty()">
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[0]">
                                        <input type="text" class="form-control input-sm get_input" ng-model="each_guest[0]" placeholder="Adult Full Name" name="">
                                    </div>
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[1]">
                                        <input type="text" class="form-control input-sm get_input" ng-model="each_guest[0]" placeholder="Child Full Name" name="">
                                    </div>
                                    <div class="col-xs-18 each_form">
                                        <div class="btn-sm pull-right btn get_button_primary" ng-click="addTtourist('one', selectedT)">Add Tourist</div>
                                    </div>
                                </div>
                                <div ng-show="getTour[selectedT][2].hasOwnProperty()">
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[0]">
                                       Adult {{$index + 1}} : {{each_guest[0]}}
                                    </div>
                                    <div class="col-xs-18 each_form" ng-repeat="each_guest in guest[1]">
                                       Child {{$index + 1}} : {{each_guest[0]}}
                                    </div>
                                    <div class=" btn-sm pull-right btn get_button_primary" ng-click="addTtourist($index, selectedT)">
                                        Edit Tourist Details</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-18"  ng-switch-when="none">
                		{{tourguest[0]}}
                    </div>
                </div>
            </div>
            <div class="col-md-8 nopadding" >
            	 <div class="col-md-18 panel-group" id="accordion" style="background:#fff; max-height:265px; overflow:hidden">
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
                                            Cancellation from <b>{{cancel_policies.DateTimeFrom['@date'] | hdate}} </b>to<b>
                                            {{cancel_policies.DateTimeTo['@date'] | hdate}}</b> will cost 
                                            <b>{{cancel_policies.Amount}}</b>
                                        </div>
                                        <div class="col-xs-18" style="margin-bottom:20px">
                                           <label>The following is applicable to this Booking:  </label>
                                            <div class="col-md-18" ng-repeat="mod in modify_policies">
                                            	<ul>
                                                	<li>Modification</li>
                                                    <li>Cancellation</li>
                                                    <li>Confirmation</li>
                                                </ul>
                                            </div>
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
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onclick="return false;">Important Information</a>
                          </h4>
                        </div>
                        <div id="collapse2" class="panel-collapse get_panel_collapse collapse">
                          <div class="panel-body">
                          	<div class="col-xs-18" style="margin-bottom:20px">
                          		{{comment.$}}
                             </div>
                              
                          </div>
                        </div>
                      </div>
                      <!--<div class="panel panel-default get_panel">
                        <div class="panel-heading get_panel_heading">
                          <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3"  onclick="return false;">Additional Information</a>
                          </h4>
                        </div>
                        <div id="collapse3" class="panel-collapse get_panel_collapse collapse">
                          <div class="panel-body">{{info}}</div>
                        </div>
                      </div>-->
                    </div> 
                 <div class="col-xs-18">
                     <a class="pull-right" href="#/tours/tours_checkout">
                        <div class="btn-sm pull-right btn get_button_primary" ng-click="addTtourist('one', selectedT)">Continue</div>
                     </a>
                 </div>
            </div>
            <!--<div class="col-md-8 nopadding">
            	<div class="col-md-18 t_pack_summ_cont">
                    <div class="col-md-18 t_get_pad t_pack_sum">Your Tour Summary</div>
                    <div class="col-md-18 t_pack_summ">
                        <div class="col-md-18 t_pack_title" >
                            <div class="col-md-6"><label>Tours</label></div>
                            <div class="col-md-6"><label>Date</label></div>
                            <div class="col-md-6"><label>Tourist</label></div>
                        </div>
                        <div class="col-md-18" style="min-height:30px;" ng-repeat="tours in getTour">
                            <div class="col-md-6">{{tours[0].TicketInfo.Name | limitTo:10}}</div>
                            <div class="col-md-6">{{tours[0].DateFrom['@date'] | hdate}}</div>
                            <div class="col-md-6">{{tourist.length}}</div>
                        </div>
                    </div>
                    <div class="col-md-18 nopadding">
                        <div class="col-md-9 col-md-offset-9 get_pad">
                            <div class="col-xs-6 summ_price_label">Price</div>
                            <div class="col-xs-12 total_price"><sup>$</sup>10,000</div>
                        </div>
                        <a href="#/tours/tours_checkout">
                        	<div class="btn-sm pull-right btn get_button_primary" ng-click="addTtourist('one', selectedT)">Add Tourist</div>
                        </a>
                    </div>
                </div>
            </div>-->
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

    
<div class="col-md-12" style="min-height:230px; padding:1em 1.5em; position:relative;  background:#0fb6ba">
	<div class="col-md-12 nopadding" style="color:#fefefe; min-height:35px">
        <div class="col-xs-12 nopadding hotel_name" >{{tour.TicketInfo.Name}}</div>
    </div>
    <div class="col-md-12">        
       <div class="col-md-4 nopadding">
       		<div class="col-md-12 nopadding">
            <div class="col-md-12 nopadding" style=" height:200px; background:#fff"><img ng-src="{{mainImageUrl}}" width="275" height="200" /></div>
            <div class="col-md-12 nopadding" style=" height:50px; padding:5px; overflow:hidden; position:relative; background:#eee">
                <div style="width:30000px; float:left; height:50px; left:0; position:relative; " id="thumb_load">                
                    <div class="hthumb" name="{{$index}}" ng-repeat="thumb in tour.TicketInfo.ImageList.Image">                        
                        <img ng-src="{{thumb.Url}}" ng-click="setImage(thumb.Url)" width="40" height="40" />
                    </div>           
                </div>
                <div class="tc_mover" id="left_th" style="left:0px; display:none;" ><img src="images/leftarr.png" width="12" height="38" /></div>
                <div class="tc_mover" id="right_th" style="right:0px"><img src="images/rightarr.png" width="12" height="38" /></div>
        	</div>
       </div>
       </div>
       <div class="col-md-8 nopadding">
            <ul class="hotel_tab">
                <li class="active_tab first_li"><a href="#">Tour Description</a></li>
                <li><a href="#">Facilities</a></li>
                <li><a href="#">Contact</a></li>
                <li class="last_li visible-lg">&nbsp;</li>             
            </ul>
            <div class="col-md-12">
                <div class="col-md-8">
                    <div class="col-md-12 h_descript">
                        <div class="col-xs-12 hot_container nopadding">
                            <div class="col-xs-12 hotel_container nopadding">
                                <div class="col-xs-12 nopadding" style="height:140px">
                                    <div class="col-xs-18"><h4>General Description</h4></div>
                                    <div class="col-xs-18">{{tour.TicketInfo.DescriptionList.Description }}</div>
                                </div>
                        	</div>
                    	</div>                        
                	</div>
            	</div>
           </div>
        </div>
     </div>
</div>
<div class="modal-footer">
    <button class="btn btn-primary" ng-click="ok()">Add Tour</button>
    <button class="btn btn-warning" ng-click="cancel()">Cancel</button>
</div>
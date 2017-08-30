	<!-- <script src="../app/bower_components/jquery/dist/jquery.js"></script> -->
	<script src="./js/sha512.js"></script>
   	<div class="col-xs-18 acct">
    	<form name="form1" id="formSUb" action="https://webpay.interswitchng.com/paydirect/pay" method="post">
            <input name="product_id" type="hidden" id="p_id"  value="6208" />
            <input name="amount" type="hidden" id="amt" value="8000000" />
            <input name="currency" type="hidden" value="566" />
            <input name="site_redirect_url" type="hidden" value="https://www.getcentre.com/#/payMentConfirm" />
            <input name="site_name" type="hidden" value="https://www.getcentre.com/apptest" />
            <input name="cust_id" id="cust_id" type="hidden" value="123" />
            <input name="cust_id_desc" id="cust_id_desc" type="hidden" value="Agent" />
            <input name="cust_name" id="cust_name" type="hidden"  />
            <input name="cust_name_desc" id="cust_name_desc" type="hidden" />
            <input name="txn_ref" type="hidden" id="txn_ref" value="" />
            <input name="pay_item_id" id="pay_id" type="hidden" value="101" />
            <input name="pay_item_name" id="pay_item_name" type="hidden" value="Transaction|web" />
            <input name="local_date_time" type="hidden" id="local_date_time" />
            <input name="hash" type="hidden" id="hash_hid" value="" />
            <!--<div id="hash_value"></div>
            <input type="Submit" value="Submit"/>-->
            <div class="col-xs-18 col-md-6 col-xs-offset-6 travel_list">
            	<div class="col-xs-18 headers ">Comfirmation &amp; Payment</div>
                <div class="col-xs-18 pay_confirm">
                    <div class="col-xs-18 nopadding">
                        <span class="col-xs-18">
                            <span class="sub_title">You are making a total booking of the sum of </span><br>
                            <div class="col-xs-18 m_price"> <sup class="curr_book ng-binding">₦</sup><span >{{amount | number:2}}</span></div>
                            All Payment are being made to GETCentre
                        </span>
                    </div>

                </div>
            </div>
            <div class="col-xs-18 col-md-6 service_list col-xs-offset-6">
            	<div class="col-xs-18 service_name">Your Transacction Reference</div>
                <div class="col-xs-18 headers" ng-bind="txn"></div>
            </div>
            <div class="col-xs-18 col-md-6  col-xs-offset-6 btn btn-default btn-sm get_button_primary" ng-click="cont()" >Click to continue</div>
            <h3  class="col-xs-6 col-xs-offset-6" ng-show="waiting">Please wait while we contact our payment gateway.</h3>
        </form>
    </div>

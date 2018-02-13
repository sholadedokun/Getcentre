<div class="col-md-16">
    <div class="col-md-11 page_head confirm_top_left_corner">
        Your Booking Was Successful, Please View Your Booking Details Below
    </div>
    <div class="col-md-18 nopadding">
    	<div class="col-md-11 nopadding" style="min-height:305px">
        	<div class="col-md-9 nopadding">
                <div class="col-md-18 confirm_details">
                	<div class="col-md-18 confirm_title"><h5>Your Personal Profile Details</h5></div> 
                    <div class="col-md-18 confir_detail_container" >
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Full Name</div>
                            <div class="col-xs-11 confirm_input">{{user.title+' '+user.fname+' '+user.lname}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Email</div>
                            <div class="col-xs-11 confirm_input">{{user.email}} </div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Phone</div>
                            <div class="col-xs-11 confirm_input">{{user[5]}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Postal Code</div>
                            <div class="col-xs-11 confirm_input">{{user[9]}}</div>
                        </div>
                        <div class="col-md-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Address</div>
                            <div class="col-xs-11 confirm_input">{{user[10]}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">City</div>
                            <div class="col-xs-11 confirm_input">{{user[11]}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">State</div>
                            <div class="col-xs-11 confirm_input">{{user[12]}}</div>
                        </div>
                    </div>
                    <div class="col-md-18 confirm_edit">
                    	<button type="submit"  class="col-xs-6 col-xs-offset-1 btn btn-default btn-sm get_pad get_button_secondary pull-right">Edit Profile</button>
                        <button type="submit"  class="col-xs-6 btn btn-default btn-sm get_pad get_button_secondary pull-right">View Profile</button>
                    </div>
                </div>
            </div>
            <div class="col-md-9 nopadding">
                <div class="col-md-18 confirm_details">
                	<div class="col-md-18 confirm_hotel_title"><h5>Your Transfer Reservation</h5></div>  
                    <div class="col-md-18 confir_detail_container" >
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Vehicle Type</div>
                            <div class="col-xs-11 confirm_input">{{getTransfer[0].ProductSpecifications.MasterVehicleType['@name']}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Service Type</div>
                            <div class="col-xs-11 confirm_input">
                            	{{getTransfer[0].ProductSpecifications.MasterProductType['@name']}}, {{getTransfer[0].ProductSpecifications.MasterServiceType['@name']}}
                            </div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Pickup Location</div>
                            <div class="col-xs-11 confirm_input">
                            	<span ng-show="getTransfer[0].PickupLocation['@xsi:type']!='ProductTransferHotel'">({{getTransfer[0].PickupLocation.Code}})</span>{{getTransfer[0].PickupLocation.Name}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Pickup Date</div>
                            <div class="col-xs-11 confirm_input">{{getTransfer[0].DateFrom['@date']}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Pickup time</div>
                            <div class="col-xs-11 confirm_input">{{getTransfer[0].DateFrom['@time']}}</div>
                        </div>
                        <div class="col-md-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Destination Location</div>
                            <div class="col-xs-11 confirm_input">
                            	<span ng-show="getTransfer[0].DestinationLocation['@xsi:type']!='ProductTransferHotel'">({{getTransfer[0].DestinationLocation.Code}})</span>
                            {{getTransfer[0].DestinationLocation.Name}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row" ng-if="getTransfer[0].Destination['@xsi:type']!='ProductTransferHotel'">
                            <div class="col-xs-7 confirm_label">Departure time</div>
                            <div class="col-xs-11 confirm_input">{{getTransfer[0].DateFrom['@time']}}</div>
                        </div>
                        <div class="col-xs-18 confirm_det_row">
                            <div class="col-xs-7 confirm_label">Travelers</div>
                            <div class="col-xs-11 confirm_input">({{getTransfer[0].Paxes.AdultCount}})Adults ({{getTransfer[0].Paxes.ChildCount}}) Children</div>
                        </div>
                    </div>
                    <div class="col-md-18 confirm_hotel_edit">
                    	<button type="submit"  class="col-xs-8 col-xs-offset-1 btn btn-default btn-sm get_pad get_button_secondary pull-right">Change Booking</button>
                        <button type="submit"  class="col-xs-8 btn btn-default btn-sm get_pad get_button_secondary pull-right">Cancel Booking</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 nopadding" style="min-height:305px">
        	<div class="col-md-18 green_bar"></div>
            <div class="col-md-18 trip_addon">
            	<div class="col-md-5 nopadding flight_img"></div>
                <div class="col-md-8 get_pad" style="min-height:85px;">
                	<div class="col-md-18">
                    	<div class="col-xs-18 summ_hotel_name"><h5>Add a Flight</h5></div>
                        <div class="col-xs-18 summ_hotel_add">From Lagos</div>
                        <div class="col-xs-18 summ_hotel_add">To New york</div>
                    </div>
                 </div>
                 <div class="col-md-5 get_flight_hotel"><h4>Get Flight Now!</h4>  </div>
                    
                </div>
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 trip_addon">
            	<div class="col-md-18" style="min-height:55px">
                    <div class="col-md-4 nopadding car_img"></div>
                    <div class="col-md-11" style="min-height:55px;">
                        <div class="col-md-18">
                            <div class="col-xs-18 summ_hotel_name"><h5>Rent a Car</h5></div>
                            <div class="col-xs-18 summ_hotel_add">Fiat 500 mini 2/3 Door Car</div>
                            <div class="col-xs-18 summ_hotel_add">Starting at $200</div>
                        </div>
                     </div>
                     <div class="col-md-3 get_pad trip_add_addon">Add Car</div>
                 </div>  
                <div class="col-xs-18" >
                	<div class="col-xs-4 get_pad trip_nav_addon trip_hand">&lt;&lt; Prev</div>
                    <div class="col-xs-10 get_pad trip_nav_addon">View all</div>
                    <div class="col-xs-4 get_pad trip_nav_addon trip_hand">Prev &gt;&gt;</div>
                </div>
              </div>
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 trip_addon">
            	<div class="col-md-18" style="min-height:55px">
                    <div class="col-md-4 nopadding tour_img"></div>
                    <div class="col-md-11" style="min-height:55px;">
                        <div class="col-md-18">
                            <div class="col-xs-18 summ_hotel_name"><h5>Take a Tour</h5></div>
                            <div class="col-xs-18 summ_hotel_add">Tour De-Louvre Paris France</div>
                            <div class="col-xs-18 summ_hotel_add">Starting at $180</div>
                        </div>
                     </div>
                     <div class="col-md-3 get_pad trip_add_addon">Add Tour</div>
                 </div>  
                <div class="col-xs-18" >
                	<div class="col-xs-4 get_pad trip_nav_addon trip_hand">&lt;&lt; Prev</div>
                    <div class="col-xs-10 get_pad trip_nav_addon">View all</div>
                    <div class="col-xs-4 get_pad trip_nav_addon trip_hand">Prev &gt;&gt;</div>
                </div>
              </div>
            <div class="col-md-18 green_bar"></div>
            <div class="col-md-18 confirm_button" ng-controller="paymentDialog">
            	<button class="col-md-offset-10 col-md-7 btn btn-sm get_pad get_button_primary" ng-click="makePayment()">Make Payment</button>
             </div>
        </div>
            
        </div>
    </div>
</div>
<div class="col-md-2 visible-lg visible-md nopadding" style="min-height:345px">
    <ul class="col-md-18 side_menu nopadding">
        <li class="nopadding green_bar"></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Flight</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc2">Hotels</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Visas</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc2">Properties</div></li>
        <li class=" nopadding"><div class="col-md-18 icon_desc1">Exhibitions</div></li>
    </ul>
</div>




<script type="text/ng-template" id="makePayment.html">
<div class="col-md-18" style="min-height:230px; padding:1em 1.5em; position:relative;  background:#0fb6ba">
	<div class="col-md-18 nopadding" style="color:#fefefe; min-height:35px">
        <div class="col-xs-18 nopadding hotel_name">Payment Options</div>
    </div>
    <div class="col-md-18 nopadding">        
       <div class="col-sm-6 nopadding">
			<div class="radio pay_method_radio">
				<label><input type="radio" name="payment_options" id="payoption1" value="Card" />MasterCard/Visa/Verve</label>
			</div>
			<div class="radio pay_method_radio">
				<label><input type="radio" name="payment_options" id="payoption2" value="Internet_banking"/>Internet Banking</label>
			</div>
			<div class="radio pay_method_radio">
				<label><input type="radio" name="payment_options" id="payoption3" value="Bank_transfer"/>Bank Transfer</label>
			</div>
	   </div>
       <div class="col-sm-12 nopadding">
          <div class="col-md-18 h_descript">
                <div class="col-xs-18 hot_container">
                    <div class="col-xs-17 hotel_container">
                        <div class="col-xs-18" style="height:160px">
                            <div class="col-xs-18"><h4>Payment Terms and Conditions</h4></div>
                            <div class="col-xs-18"><b>GENERAL</b><br>
You confirm that you are at least 18 years of age or are accessing the Site under the supervision of a parent or legal guardian. You agree that if you are unsure of the meaning of any part of the Terms and Conditions of Sale, you will not hesitate to contact us for clarification prior to making a purchase.

These Terms and Conditions of Sale fully govern the sale of services purchased on this Site. No extrinsic evidence, whether oral or written, will be incorporated.<br><br>

<b>FORMATION OF CONTRACT</b><br>
Both parties agree that browsing the website and gathering information regarding the services provided by the seller does not constitute an offer to sell, but merely an invitation to treat. The parties accept that an offer is only made once you have selected the item you intend to purchase, chosen your preferred payment method, proceeded to the checkout and completed the checkout process.

Both parties agree that the acceptance of the offer is not made when the seller contacts you by phone or by email to confirm that the order has been placed online. Your offer is only accepted when we send a booking confirmation voucher to your email or phone.

Before your order is confirmed, you may be asked to provide additional verifications or information, including but not limited to phone number and address, before we accept the order.

Please note that there are cases when an order cannot be processed for various reasons. The Site reserves the right to refuse or cancel any order for any reason at any given time.<br><br>

<b>ACCEPTANCE OF ELECTRONIC DOCUMENTS</b><br>
You agree that all agreements, notices, disclosures and other communications that we provide to you electronically satisfy any legal requirement that such communications be in writing.<br><br>

<b>PAYMENT AND PRICING</b><br>
We are determined to provide the most accurate pricing information on the Site to our users; however, errors may still occur, such as cases when the price of an item is not displayed correctly on the website or their is a drastic chhange in the  current foreign exchange rate. As such, we reserve the right to refuse or cancel any order. In the event that an item is mispriced, we may, at our own discretion, either contact you for instructions or cancel your order and notify you of such cancellation.

We shall have the right to refuse or cancel any such orders whether or not the order has been confirmed and your credit/debit card charged. In the event that we are unable to provide the services, we will inform you of this as soon as possible. A full refund will be given where you have already paid for the products.<br><br>

<b>USE OF VOUCHER CODES</b><br>
Our Site accepts the use of voucher codes for orders placed online. The marketing voucher codes which are accepted on our Site entitle you at the time of ordering a product to a saving on the order being placed on our Site. Vouchers may also be issued to customers in exchange for advance payments made to us via transfer to our bank accounts for products intended to be purchased on the Site.

Our voucher codes may not be exchanged for cash. With the exception of vouchers issued in accordance with our refunds policy and vouchers issued in exchange for advance payments, we reserve the right to cancel or withdraw our voucher codes at any time.</div>
                        </div>
                    </div>
                </div>                        
            </div>
            <div class="col-xs-18 checkbox">
                <label><input type="checkbox" name="terms_condition" id="t_c" value="agreed"/>I've read and agreed to GetCentre's <a href="#">Terms and Condition</a>
                </label>
            </div>   
         </div>      
     </div>
</div>
<div class="modal-footer">
    <button class="btn get_button_primary" ng-click="ok()" style="margin:15px 0 0">Continue</button>
    <button class="btn get_button_warning" ng-click="cancel()" style="margin:15px 0 0">Cancel</button>
</div>
</script>
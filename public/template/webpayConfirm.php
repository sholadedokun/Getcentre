<div class="col-xs-18" ng-init="getref()">
	<div class="col-xs-6 col-xs-offset-6" ng-show="waiting">
    	<div class="text_anim_head">Please wait while confirm your payment.</div>
    </div>
    <div class="col-xs-18" ng-show="!waiting">
        <div class="col-xs-18 col-md-6 col-md-offset-6" ng-show="success" style="padding:15px; color:#fff">
            <div class="text_anim_head">Transaction Status</div>
            <p style="padding:10px; margin:5px; border-radius:5px; background:#0C3; color:#fff">
                Your Transcation was successfull. A receipt has been sent to your email. <br/>
                <span><b>Payment Reference:</b><span ng-bind="pref"></span></span><br />
                <span><b>Transaction Reference:</b><span ng-bind="txnref"></span></span>
            </p>
            <div style="text-align:center;"><a href="http://getcentre.com/#/voucher" style="color:#fff">Click here to Continue</a></div>
        </div>
        <div class="col-xs-18 col-md-6 col-md-offset-6" ng-show="!success" style="padding:15px;  color:#fff">
            <div class="text_anim_head">Transaction Status</div>
            <p style="padding:10px; margin:5px; border-radius:5px; background:#f44; color:#fff">
                Error Processing your transaction. Please find possible reasons below. <br/>
                <span><b>Reason:</b></span><span ng-bind="res"></span><br>
                <span><b>Transaction Reference:</b><span ng-bind="txnref"></span></span>

            </p>
            <div style="text-align:center;"><a href="http://getcentre.com/#/payMentGateway" style="color:#555">Click here to Try Again</a></div>
            <div style="text-align:center;"><a href="http://getcentre.com/#/Addguest" style="color:#555">Click here to Continue</a></div>
        </div>
    </div>
</div>

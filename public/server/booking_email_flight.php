<?php
	require_once 'JSON.php';
	require_once 'fun_connect2.php';
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
    $flightDetails=$request->flightDetails;
	$user=$request->userE;
	// $flightDetails=json_decode($_GET["flightDetails"], true);

	//$GuestDetails=json_decode($_GET["GuestDetails"], true);
	// $user=json_decode($_GET["userE"], true);
	$to=$flightDetails->guest_details->adult[0]->email;
	$flightContents=$flightDetails->flightDetails;

	// echo '<pre>'.print_r($flightDetails).' </pre>';
	if($flightDetails->flightType)
	$bookingCode=$request->bookingCode;
	$bookingRef=$request->bookingRef;
	$subject = "Getcentre Flight Reservation";
	$message='<table cellpadding="0" cellspacing="0" style="font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif; width:80%; margin:0 auto;">
    <tr>
        <td>
            <table cellpadding="0" cellspacing="0" style="border:#555 solid 2px; margin:0; padding:0 ">
                <tr style=" height:50px; width:500px;">
                    <td width="48px" style=" padding:20px 0 5px 20px;" align="left" >
                        <img src="http://www.getcentre.com/images/logo_color.png" width="90" height="48" />
                    </td>
                </tr>
                <tr style="padding:auto; width:500px">
                    <td width="500px" colspan="3" style="padding:20px 10px; background:#b6d2d3; ">
                        <span><strong>Dear '.$flightDetails->guest_details->adult[0]->title.' '.$flightDetails->guest_details->adult[0]->fname.' '.$flightDetails->guest_details->adult[0]->lname.',</strong></span>
						<span style="text-align:left">
			                     Your Flight Reservation was Successful.Find the details of your Reservation made on our website
                                 <a href="http://getcentre.com">GETcentre.com</a> on '.date("l jS \of F Y" ).'.
                                 Your reservation has been booked on-hold, Please effect payment as soon as possible.
                        </span>
                    </td>
                </tr>
            	<tr height="auto">
            		<td colspan="2" height="auto" style="padding:0px 0 5px 5px; text-align:center"><h3><strong> Flight Type: '.$flightDetails->flightTypeName.' </strong></h3></td>
            	</tr>';
				for($i=1; $i<= count($flightContents); $i++ ){
					$flightSumnum='Flight Details';
					if($flightDetails->flightType=='MT'){ $flightSumnum='Trip '.$i; }
					else{
						if($flightDetails->flightType=='NF'){
							if($i==1){
								$flightSumnum= 'Going  / Leaving';
							}
							else{
								$flightSumnum= 'Coming / Returning';
							}

						}
					}
				$message.='
				<tr>
        	    	<td colspan=2 style="padding:40px 0 10px 0px; font-size:18px; text-align:center"><strong>'.$flightSumnum.'</strong></td>
        	    </tr>';
				$message.='
				<tr>
        	    	<td width="150px" style="padding:0px 0 0 10px;"><strong>Airline Name:</strong></td>
        			<td width="300px" style="padding:0px 0 0 10px;">'.$flightContents[$i-1]->carrier.'</td>
        	    </tr>
        	    <tr>
        	    	<td width="150px" height="auto" style="padding:0 0 0 10px;"><span style="width:180px"><strong>Departure:</strong></span></td>
        	        <td width="300px" height="auto"  style="padding:0 0 0 10px;"><span>'.$flightContents[$i-1]->depAirport.'</span></td>
        	    </tr>
        	    <tr cellpadding="0">
        	    	<td width="150px" height="auto" style="padding:0 0 0 10px;"><span style="width:180px"><strong>Departure Date:</strong></span></td>
        	        <td width="300px" height="auto"  style="padding:0 0 0 10px;"><span>'.$flightContents[$i-1]->depDate.'|'.$flightContents[$i-1]->depTime.'</span></td>
        	    </tr>
        	    <tr cellpadding="0">
        	    	<td width="150px" height="auto" style="padding:0 0 0 10px;"><span style="width:180px"><strong>Destination:</strong></span></td>
        	        <td width="300px" height="auto"  style="padding:0 0 0 10px;"><span>'.$flightContents[$i-1]->desAirport.'</span></td>
        	    </tr>
        	    <tr cellpadding="0">
        	    	<td width="150px" height="auto" style="padding:0 0 0 10px;"><span style="width:180px"><strong>Destination Date:</strong></span></td>
        	        <td width="300px" height="auto"  style="padding:0 0 0 10px;"><span>'.$flightContents[$i-1]->desDate.'|'.$flightContents[$i-1]->desTime.'</span></td>
        	    </tr>';
				if(count($flightContents[$i-1]->fstop)>0){
					$message.='
	        	    <tr style="padding:10px; height:auto"><td colspan="4" style="padding:10px">
						<table cellpadding="0" cellspacing="0" style="width:100%; border:#555 solid 1px; ">
	            				<tr>
	            					<td style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid"><span style=" font-size:18px;"><strong>Stopover </strong></span></td>
	            					<td style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid"><span style=" font-size:18px;"><strong>Fligth Class</strong></span></td>
	            					<td style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid"><span style=" font-size:18px;"><strong>Flight Duration</strong></span></td>
	            				</tr>';
								foreach($flightContents[$i-1]->fstop as $stops){
									$message.='
	                            <tr>
	        						<td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" ><span>'.$stops->airport.'</span></td>
	        	                    <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" ><span> Class '.$stops->fclass.'</span></td>
	        	                    <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" ><span>'.$stops->flighttime.'</span></td>
	        	                </tr>';
								}
						$message.='
	        				</table>
	        			</td>
	        		</tr>';
					}
				}
				$message.='
            	<tr>
                	<td style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3" ><span style=" font-size:18px;"><strong>Passenger Details</strong></span></td>
                </tr>';
				for($b=0; $b<count($flightDetails->guest_details->adult); $b++){
			$message.='
                <tr>
					<td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="3" >
                    	<span><strong>Name(Adult) : </strong>'.$flightDetails->guest_details->adult[$b]->fname.' '.$flightDetails->guest_details->adult[$b]->lname.'</span>
                        <span><strong>Date Of Birth:</strong>'.$flightDetails->guest_details->adult[$b]->dbirth.'</span>
                    </td>
                </tr>';}
				for($b=0; $b<count($flightDetails->guest_details->child); $b++){
			$message.='
                <tr>
					<td  style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="3" >
                    	<span><strong>Name(Child) : </strong>'.$flightDetails->guest_details->child[$b]->fname.' '.$flightDetails->guest_details->child[$b]->lname.'</span>
                        <span><strong>Date Of Birth:</strong>'.$flightDetails->guest_details->child[$b]->dbirth.'</span>
                    </td>
                </tr>';}
				for($b=0; $b<count($flightDetails->guest_details->infant); $b++){
			$message.='
                <tr>
					<td  style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="3" >
                    	<span><strong>Name (Infant) : </strong>'.$flightDetails->guest_details->infant[$b]->fname.' '.$flightDetails->guest_details->infant[$b]->lname.'</span>
                        <span><strong>Date Of Birth:</strong>'.$flightDetails->guest_details->infant[$b]->dbirth.'</span>
                    </td>
                </tr>';}
				$message.='
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><strong>Last Ticketing Date</strong></span>
                     </td>
                     <td colspan="2" style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358">
                    	<span>'.$flightDetails->lastTicketDate.'</span>
                     </td>
                </tr>
				<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><strong>Expected Amount</strong></span>
                     </td>
                     <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="2" >
                    	<span>'.$flightDetails->Price.'</span>
                     </td>
                </tr>
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><strong>Reservation Code</strong></span>
                     </td>
                     <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="2" >
                    	<span style=" font-size:14px;">'.$bookingCode.'</span>
                     </td>
                </tr>
				<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><strong>Reservation Reference</strong></span>
                     </td>
                     <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="2" >
                    	<span style=" font-size:14px;">'.$bookingRef.'</span>
                     </td>
                </tr>
            	<tr>
                	<td  style="color:#c44; padding:10px " colspan="3">
                    	<p style=" font-size:18px;"><strong>Ticket Cancellation</strong></p>
                     </td>
                </tr>
				<tr>
                     <td style="padding:10px; color:#035358" colspan="3" >
                    	<span style=" font-size:14px;">To cancel your booking please send an email to bookings@getcentre.com or call +2348188019555.</span>
                     </td>
                </tr>
                <tr>
                    <td style="padding:10px; color:#035358" colspan="3" >
            			<p style="text-align:left"><i>
                            Best Regards,</br>
                            The GETCentre Team.</i>
                        </p>
                    </td>
                </tr>
                <tr>
                	<td colspan="4" height="50px"  width="100%" style="padding:10px; clear:both; color:#c44; width:500px; height:80px; font-size:10px;" align="left">
                      <p>
                          This email was intended for '.$to.'. If you think you receive this email by error and any of the content of this email  doesn\'t relate to any of your recent activity or association with www.getcentre.com <a style="color:#c00" href="http://www.getcentre.com/wrongadd.php"> please click here</a>.
                      </p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>';
	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html; charset=iso-8859-1" . "\r\n";
	$headers .= "From:Getcentre.com\r\n";
	$headers .= 'Bcc: sholadedokun@yahoo.com, sholadedokun@gmail.com';
	//$message = nl2br($message);
	$a = mail($to, $subject, $message, $headers);
	// $json = json_encode($row);
	// echo $json;


?>

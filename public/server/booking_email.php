<?php
	require_once 'JSON.php';
	require_once 'fun_connect2.php';
	error_reporting(E_ALL);
	ini_set('display_errors', 0);
	$postdata = file_get_contents("php://input");
	$request = json_decode($postdata);
	$user=$request->leadGuest;
	$sDet=$request->searchD;
	setlocale(LC_MONETARY, 'en_NG');
	$to=$user->email;
	//$reserve_type=$reserve_det->Service;
	$dateFrm='Check-In';
	$dateOut='Check-Out';
	if($sDet->productType=="Hotel"){ $b_type = "Hotel"; $Ticketdatef=$sDet->hcheckinL; $Ticketdatet=$sDet->hcheckoutL;}
	if($sDet->productType=="Tour"){
		$b_type = "Tour"; $dateFrm='Ticket Valid From'; $dateOut='Ticket Valid To';
		$Tdate=$sDet->ticketDate;
		$newTstr = substr_replace($Tdate, '-', 4, 0);
		$newTstr = substr_replace($newTstr, '-', 7, 0);
		$Ticketdatet=date('l jS \of F Y',strtotime($newTstr));
		$Ticketdatef= $Ticketdatet;
	}
	if($sDet->productType=="Transfer"){	$b_type = "Airport Transfer";}
	$currency=$sDet->currency;
	$price=$sDet->Price;
	$subject = "GETCentre $b_type Reservation";
	$message='	<table width="100%" style="font-family:\'Trebuchet MS\', Arial, Helvetica, sans-serif;" align="center" >

	<tr><td>&nbsp;
	<table background="bgcolor="#bfe6ff"  cellpadding="0" cellspacing="0" width="620px" align="center" height="auto" style=" border:#555 solid 2px;  background:url("http://www.getcentre.com/images/get_bg_m.jpg") no-repeat top center; ">
    <tr style=" height:50px; width:500px;">
    	<td width="48px" style=" padding:20px 0 5px 20px;" align="left" >
        	<img src="http://www.getcentre.com/images/logo_color.png" width="90" height="48" />
        </td>

    </tr>
    <tr style="padding:10px; width:500px">
    	<td width="500px" colspan="3" style="padding:20px 10px; background:#b6d2d3; ">
    	<span><b>Dear '.$user->title.' '.$user->fname.' '.$user->lname.',</b></span><br />
    	<span style="text-align:left">
			Your '.$b_type.' Reservation was Successful. Please find the details of your Reservation made on our website <a href="http://getcentre.com">GETcentre.com</a> on '.date("l jS \of F Y" ).'. Your reservation has been booked on-hold, Please effect payment as soon as possible.
        </span>
        </td>
    </tr>
    <tr  style="padding:10px; width:135px">
    	<td  width="135px;" rowspan="4" colspan="2"  height="120px" style=" border-top:#aaa solid thin; padding-left:10px;">
        	<img src="'.$sDet->imgurl.'" width="135" height="90" style="border:1px #0baeb7 solid" />
        </td>
    </tr>
    <tr height="20px" style="height:20px">
    	<td width="300px" colspan="2" height="15px" style="border-top:#aaa solid thin; padding:0px 0 5px 5px; color:#555">
		<b>'.$b_type.' Name :</b> '.$sDet->Name.', '.' ('.$sDet->hotelCat->{'$'}.')<br>
		';

		if($sDet->product=="HotelBed"){
			if($sDet->productType=="Hotel"){
			$message.=$sDet->hotelContact->hotelAddress.', '.$sDet->hotelContact->hotelCity.', '.$sDet->hotelContact->hotelPostalC;
			$message.='<br/><b>Phone Number :</b> '.$sDet->hotelContact->Phone;
			}

		}
		else{$message.=$sDet->destination->{'0'};
		}


		$message.='
        </td>
    </tr>
    <tr>
    	<td width="300px" height="10px" colspan="2" style="padding:0 0 0 10px;">
        	<span style="width:180px"><b>'.$dateFrm.':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span><span>'.$Ticketdatef.'</span>
        </td>
    </tr>
    <tr cellpadding="0">
    	<td width="300px" height="10px" colspan="2" style="padding:0 0 0 10px;">
        	<span style="width:180px"><b>'.$dateOut.':&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span><span>'.$Ticketdatet.'</span>
        </td>
    </tr>

    <tr style="padding:10px; height:160px;">
    	<td colspan="4" style="padding:10px" >';
		if( $sDet->productType=='Hotel'){
		if(isset($sDet->guestBreak[0])){
		for($i=0; $i<count($sDet->guestBreak); $i++){
			if(isset($sDet->guestBreak[$i]->cancel->CancellationPolicy)){
				$odate=$sDet->guestBreak[$i]->cancel->CancellationPolicy->{'@dateFrom'};
				$newstr = substr_replace($odate, '-', 4, 0);
				$newstr = substr_replace($newstr, '-', 7, 0);
				// echo($newstr);
				$cdate=date('l jS \of F Y',strtotime($newstr));
				// echo($cdate);
			};
			$message.='
			<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
                    	<span style=" font-size:18px;"><b>Room '.($i+1).'</b></span>
                     </td>
                </tr>
                <tr>
					<td style="text-align:right; background:#b6d2d3; color:#035358" >
                        <ul style="list-style:none;">
                        	<li><b>Room Type:</b></li>
							<li><b>Board Type:</b></li>
                            <li><b>Adult ('.$sDet->hroomdist[$i][0]->value.'):</b></li>
                            <li>Children ('.$sDet->hroomdist[$i][1]->value.') </li>
                        </ul>
					</td>
					<td style="text-align:left; background:#b6d2d3; color:#035358" colspan="2">
						<ul style="list-style:none">
                        	<li><b>'.$sDet->guestBreak[$i]->roomtype.'</b></li>
							<li><b>'.$sDet->guestBreak[$i]->board.'</b></li>
                            <li><b>'.$sDet->guestBreak[$i]->guest_details->guest[0]->title.' '.$sDet->guestBreak[$i]->guest_details->guest[0]->fname.' '.$sDet->guestBreak[$i]->guest_details->guest[0]->lname.'</b></li>';
							if($sDet->hroomdist[$i][1]->value !=0){
								$message.="<li><b> Children Ages ";
								$chno=count($sDet->hroomdist[$i][1]->ages);
								for($b=0; $b<$chno; $b++){
									$message.=$sDet->hroomdist[$i][1]->ages[$b]->valueYear;
									if(($chno-$b)==1){$message.='.</b></li><br>';}
									else{
										if(($chno-$b)>1){
											if(($chno-$b)==2){$message.=' and ';}
											else{$message.=', ';}
										}
									}
								}
							}
                            $message.='
                        </ul>
                     </td>
                </tr>
				<tr>
					<td  style="text-align:center; background:#b6d2d3; color:#035358"  colspan="3">';
					 if($sDet->product=='HotelBed'){$message.='
						<span><b>Cancelation Penalty : </b> Costs '.$currency.' '.$sDet->guestBreak[$i]->cancel->CancellationPolicy->{'@amount'}.' to cancel after '.$cdate.'</span>';} else{$message.='<span><b>Cancelation Penalty :</b>'.$sDet->guestBreak[$i]->cancel->booking_rule.'</span>';}
						$message.='
					</td>
				</tr>
            </table><br/>';
		}
		}
		else{
			if(isset($sDet->guestBreak[0]->cancel->CancellationPolicy)){
				$odate=$sDet->guestBreak[0]->cancel->CancellationPolicy->{'@dateFrom'};
				$newstr = substr_replace($odate, '-', 4, 0);
				$newstr = substr_replace($newstr, '-', 7, 0);

				$cdate=date('l jS \of F Y',strtotime($newstr));
			};
		$message.='
			<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
                    	<span style=" font-size:18px;"><b>Room 1</b></span>
                     </td>
                </tr>
                <tr>
					<td style="text-align:right; background:#b6d2d3; color:#035358" >
                        <ul style="list-style:none;">
                        	<li><b>Room Type:</b></li>
							<li><b>Board Type:</b></li>
                            <li><b>Adult ('.$sDet->hroomdist[0][1].'):</b></li>
                            <li>Children ('.count($sDet->hroomdist[0][2]).') </li>
                        </ul>
					</td>
					<td style="text-align:left; background:#b6d2d3; color:#035358" colspan="2">
						<ul style="list-style:none">
                        	<li>'.$sDet->guestBreak[0]->roomtype.'</li>
							<li>'.$sDet->guestBreak[0]->board.'</li>
                            <li>'.$sDet->guestBreak[0]->guest_details->guest[0]->title.' '.$sDet->guestBreak[0]->guest_details->guest[0]->fname.' '.$sDet->guestBreak[0]->guest_details->guest[0]->lname.'</li>';
							if(count($sDet->hroomdist[$i][2])!=0){
								$message.="<li> Children Ages ";
								$chno=count($sDet->hroomdist[0][2]);
								for($b=0; $b<$chno; $b++){
									$message.=$sDet->hroomdist[0][2][$b];
									if(($chno-$b)==1){$message.='.</li><br>';}
									else{
										if(($chno-$b)>1){
											if(($chno-$b)==2){$message.=' and ';}
											else{$message.=', ';}
										}
									}
								}
							}
                            $message.='
                        </ul>
                     </td>
                </tr>
				<tr>
					<td  style="text-align:center; background:#b6d2d3; color:#035358"  colspan="3">';
					if($sDet->product=='HotelBed'){$message.='
						<span><b>Cancelation Penalty : </b> Costs '.$currency.' '.$sDet->guestBreak[0]->cancel->CancellationPolicy->{'@amount'}.' to cancel after '.$cdate.'</span>';} else{$message.='<span><b>Cancelation Penalty :</b>'.$sDet->guestBreak[0]->cancel->booking_rule.'</span>';}
						$message.='
					</td>
				</tr>
            </table><br/>';
		}
		}
		if( isset($sDet->comment)){
		$message.='<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
                    	<span style=" font-size:18px;"><b>'.$sDet->productType.' Infomation</b></span>
                     </td>
                </tr>
                <tr>
					<td style="background:#b6d2d3; padding:20px; color:#035358" ><span>'.$sDet->comment.'</span>
					<br/>
					<br/>
					<span style="font-size:14px;"><b>'.$sDet->hroomdist[0][1].' Adult, '.count($sDet->hroomdist[0][2]).' Children</b><br/>';
					$allguest=$sDet->guestBreak[0]->guest_details->guest;
					for($h=0; $h<count($allguest); $h++){
						$message.='<span>'.$allguest[$h]->title.' '.$allguest[$h]->fname.' '.$allguest[$h]->lname.'<span><br/>';
						}
					$message.='
					</td></tr></table>';
		}
		if( isset($sDet->cancel)){
			$fdate=$sDet->cancel->Price->DateTimeFrom->{'@date'};
				$newfstr = substr_replace($fdate, '-', 4, 0);
				$newfstr = substr_replace($newfstr, '-', 7, 0);
				$cdate=date('l jS \of F Y',strtotime($newfstr));
			$tdate=$sDet->cancel->Price->DateTimeTo->{'@date'};
				$newtstr = substr_replace($tdate, '-', 4, 0);
				$newstr = substr_replace($newtstr, '-', 7, 0);
				$tcdate=date('l jS \of F Y',strtotime($newtstr));
		$message.='<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
                    	<span style=" font-size:18px;"><b>Ticket Cancellation</b></span>
                     </td>
                </tr>
                <tr>
					<td style=" background:#b6d2d3; padding:20px; color:#035358" >
					<span><b>Cancelation Penalty : </b> Costs '.$currency.' '.$sDet->cancel->Price->Amount.' to cancel between '.$cdate.' and '.$tcdate.'</span></td></tr></table>';
		}
		if( isset($sDet->contractComment)){
			if( is_array($sDet->contractComment)){
				for($i=0; $i<count($sDet->contractComment); $i++){

			$message.='
				<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
					<tr>
						<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
							<span style=" font-size:18px;"><b>Contract Comment'.($i+1).'</b></span>
						 </td>
					</tr>
					<tr>
						<td width="100%" style="padding:10px; background:#b6d2d3; color:#035358" colspan="3" >
							<p style="text-align:left">
							'.$sDet->contractComment[$i]->Comment{'$'}.'</p>
						</td>

				</table>';
						}
			}
			else{
				$message.='
				<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
					<tr>
						<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid" colspan="3">
							<span style=" font-size:18px;"><b>Contract Comment</b></span>
						 </td>
					</tr>
					<tr>
						<td width="100%" style="padding:10px; background:#b6d2d3; color:#035358" colspan="3" >
							<p style="text-align:left">
							'.$sDet->contractComment->Comment->{'$'}.'</p>
						</td>

				</table>';
			}
		}
	if($sDet->product=='HotelBed'){
	$message.='
            <table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><b>Booking Reference</b></span>
                     </td>
                     <td colspan="2" style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358">
                    	<span style=" font-size:18px;"><b>'.$sDet->ref->IncomingOffice->{'@code'}.'-'.$sDet->ref->FileNumber.'</b></span>
                     </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><b>Payable Through</b></span>
                     </td>
                     <td colspan="2" style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358">
                    	<span style=" font-size:18px;">'.$sDet->supplier->{'@name'}.'</span>
                     </td>
                </tr>
            </table>
            <table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><b>Supplier VAT Number</b></span>
                     </td>
                     <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="2" >
                    	<span style=" font-size:14px;">'.$sDet->supplier->{'@vatNumber'}.'</span>
                     </td>
                </tr>
            </table>
			<table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><b>Total Price</b></span>
                     </td>
                     <td style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358" colspan="2" >
                    	<span style=" font-size:14px;">'.money_format('%i', $sDet->convertedPrice).'</span>
                     </td>
                </tr>
				<tr>
                	<td colspan="2" style="background:#eee; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:12px; color:#955"><b>Price may vary at the time of booking due to currency conversion rate.</b></span>
                     </td>
                </tr>
            </table>'

			;
	}
	else{
		$message.=' <table cellpadding="0" cellspacing="0" style="width:595px; border:#555 solid 1px;">
            	<tr>
                	<td  style="background:#0baeb7; padding:10px; border-bottom:#999 thin solid">
                    	<span style=" font-size:18px;"><b>Booking Code</b></span>
                     </td>
                     <td colspan="2" style="background:#b6d2d3; padding:10px; border-bottom:#999 thin solid; color:#035358">
                    	<span style=" font-size:18px;"><b>'.$sDet->ref.'</b></span>
                     </td>
                </tr>
            </table>';
	}
	$message.='

            <br />
			<p style="text-align:left"><i>
                Best Regards,<br>
                The GETCentre Team.</i>
            </p>
        </td>
    </tr>
     <tr>
     	<td colspan="4" height="50px"  width="100%" style="padding:10px; clear:both; color:#c44; width:500px; height:80px; font-size:10px;" align="left">
          <p>This email was intended for '.$to.'. If you think you receive this email by error and any of the content of this email  doesn\'t relate to any of your recent activity or association with www.getcentre.com <a style="color:#c00" href="http://www.getcentre.com/wrongadd.php"> please click here</a>.
            </p>
        </td>
     </tr>

    </table>
	</td></tr>
    <tr><td>&nbsp;</td></tr>
</table>';

	$headers = "MIME-Version: 1.0"."\r\n";
	$headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
	$headers .= "From:Getcentre.com\r\n";
	$headers .= 'Bcc: sholadedokun@yahoo.com';
	//$message = nl2br($message);
	$a = mail($to, $subject, $message, $headers);
	if($a){echo 'o';}
	else{echo 'b';}


?>

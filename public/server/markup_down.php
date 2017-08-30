<?php

function processmark($m, $nuc){
    if($m['mark_perc'] !=0){
        $p=$nuc * ($m['mark_perc']/100);
    }
    else{
        $p=$m['mark_value'];
    }
    return $p;
}
function compare($mark, $eachflight, $per, $ftype){
    // echo "<pre>".print_r($mark[0]['mark_short'])."</pre>";
    //addup all the taxes for this flight
    $totaltaxs=0;
    $validatingCarrier;
    foreach($per as $tax){
        $tp=$tax->attributes()->price;
        $totaltaxs=$totaltaxs+$tp;
    }
    $nuc=$per->attributes()->price-$totaltaxs;

    //check if flight matches with list of markdowns or markup
    if($ftype!='MF')  $validatingCarrier= $eachflight->extra->adtFlightInfo->outbound->leg0->attributes()->validatingCarrierCode;
    else $validatingCarrier=$eachflight->extra->adtFlightInfo->flight0->leg0->attributes()->validatingCarrierCode;
    foreach($mark as $m){
        if($validatingCarrier == $m['mark_short']){
            $margin=processmark($m, $nuc);
            if($m['mark_type']=='md'){
                $per['margin']=($nuc - $margin)+$totaltaxs;
                $per['nuc']=$nuc;
                $per['markType']='down';
                $per['markPercent']= $m['mark_perc'];
                $per['markValue']= $m['mark_value'];
                $per['totalTaxes']=$totaltaxs;
                $per['appliedMargin']=$margin;
            }
            else{
                $per['margin']=($nuc + $margin)+$totaltaxs;
                $per['nuc']=$nuc;
                $per['markType']='up';
                $per['markPercent']= $m['mark_perc'];
                $per['markValue']= $m['mark_value'];
                $per['totalTaxes']=$totaltaxs;
                $per['appliedMargin']=$margin;
            }
        }
        else{
                $per['margin']=0;
            }
    }
    return $per['margin'];
}
function getmark($from, $to){
    $json_cityAirports=
        '[

            {
                "city":"London",
                "code":"LON",
                "airports":["LHR","LCY","LGW","LTN","STN"]
            }

    ]';
    $cityAirports=json_decode($json_cityAirports);
    foreach($cityAirports as $city){
        foreach($city->airports as $airport){
            if(strtolower($airport)==strtolower($to)){
                $to=$city->code;

            }
            if(strtolower($airport)==strtolower($from)){
                $from=$city->code;
            }
        }
    }
    $sql="Select * from `Markdown` where (`mark_dFrom`='".$from."' AND `mark_dTo`='".$to."') OR (`mark_dFrom`='".$to."' AND `mark_dTo`='".$from."') order by markid  ";
    $res=mysql_query($sql) or die( 'Error getting markdown'.mysql_error());
    $allresultd=array();
    while($info=mysql_fetch_assoc($res)){
        array_push($allresultd, $info);

    }
    // print_r($allresultd);
    return $allresultd;
}
?>

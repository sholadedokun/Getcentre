getcentre.filter('custNo', function () {
    return function (input) {
        var n = input;
        if(n < 10){ if(n < 0){n=0; n='0' + n;}  else{ n='0' + n}}

        return n;
    }
});
getcentre.filter('time_am_pm', function () {
    return function (input) {
        var n =moment(input).format('hh:mm a');
        return n;
    }
});

getcentre.filter('hdate', function () {
    return function (input) {

        input= input.substr(0, 4) + "." + input.substr(4,2)+'.'+input.substr(6);
        var n =moment(input, "YY.MM.DD").format('ddd. DD MMM ');
        return n;
    }
});
getcentre.filter('findAirport', function (retrieveAirports) {
    return function (code, city){
        var reg= new RegExp('Airport|'+city+'|International', 'g');

        var allAirports=retrieveAirports.data();
        // console.log(allAirports)
		var airPortDescription = allAirports.currentAirports.filter((item)=> item.code==code)
		//if airport Bucket is empty and it's Airport's json hasn't be retrieved...
		if(airPortDescription.length == 0 && allAirports.airports.length ==0){
            retrieveAirports.getAllAirports().then(data=>{
                airPortDescription = data.airports.filter((item)=> item.code==code)
                allAirports.currentAirports.push(airPortDescription[0])
                // allAirports.airports=data.airports;
                retrieveAirports.saveData(allAirports);
                return airPortDescription[0].name.replace(reg,'').rep;
            })
		}
		else if(airPortDescription.length == 0){
			airPortDescription = allAirports.airports.filter(item=>	item.code==code)
			allAirports.currentAirports.push(airPortDescription[0])
            retrieveAirports.saveData(allAirports);

            return airPortDescription[0].name.replace(reg,'');
		}
        else{
            return airPortDescription[0].name.replace(reg,'');
        }

    }
});
getcentre.filter('htime', function () {
    return function (input) {
        input=input.substring(0, 2) + ":" + input.substring(2);
        return input+"pm";
    }
});
getcentre.filter('fltime', function () {
    return function (input) {
        input=input.split(':'); input=input[0] + "hrs " + input[1]+'mins';
        return input;
    }
});
getcentre.filter('hrtomin', function () {
    return function (minu) {
        var hours = Math.floor( minu / 60);
        var minutes = minu% 60;
        return(hours+'hrs '+minutes+'mins');
    }
})

getcentre.filter('shortdate', function () {
    return function (date) {
        var n=moment(date).format('ddd. DD MMM YYYY');
        return(n)
    }
})
getcentre.filter('shortdateF', function () {
    return function (date) {
        var n=moment(date, "DD.MM.YY" ).format('DD MMM YYYY');
        return(n)
    }
})
getcentre.filter('lastlegDes', function (findAirportFilter) {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $des_desc=legobj[$arr_leg]['@desDesc'];//getting the destination date of the last leg
        $des_ext = legobj[$arr_leg]['@desDescExt'] ||  findAirportFilter(legobj[$arr_leg]['@desCode'],legobj[$arr_leg]['@desDesc'] ) || '';
        $des='<label>'+$des_desc+'</label> '+$des_ext;//format the date to a better readable format
        return($des)
    }
})
getcentre.filter('lastlegDate', function () {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $arr_date=legobj[$arr_leg]['@desDate'];//getting the destination date of the last leg
        $arr_date=moment($arr_date).format('ddd. DD MMM YYYY');//format the date to a better readable format
        return($arr_date)
    }
})
getcentre.filter('lastlegTime', function () {
    return function (legobj) {
        $total_channel=-1
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        $arr_leg='leg'+$total_channel;//getting the last leg of this trip
        $arr_time=legobj[$arr_leg]['@desTime'];//getting the destination date of the last leg
        return($arr_time)
    }
})
getcentre.filter('stopover', function () {
    return function (legobj) {
        $total_channel=-1;
        for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
        return($total_channel)
    }
})
// getcentre.filter('cabinClass', function () {
//     return function (cabin) {
//         $cabinLetter=cabin.split('|')[1];
//         switch($cabinLetter.toUpperCase()){
//             case 'Y':return 'Economy';
//             case 'S':return 'Economy Premimum';
//             case 'C':return 'Business';
//             case 'J':return 'Business Premium';
//             case 'F':return 'First';
//             case 'P':return 'First Premium';
//             default: return 'Economy';
//         }
//
//         for (property in legobj){if(legobj.hasOwnProperty(property)){$total_channel++;}}
//         return($total_channel)
//     }
// })
getcentre.filter('fprice', function () {
    return function (price) {
        $tot_price=0;
        for (property in price){//loop through each person
            cprice=price[property]
            //check if this flight has been markup_down by checking the the margin object
            if(cprice['@margin']==0 || typeof cprice['@margin']=='undefined'){
                $tot_price=$tot_price+parseFloat(cprice['@price']);
            }
            else{
                $tot_price=$tot_price+parseFloat(cprice['@margin']);
            }
        }
        return $tot_price;
    }
})
getcentre.filter('agentPrice', function (travelPackD) {
    return function (price, agentMark, index) {
        travelPD=travelPackD.data();
        $tot_price=0;
        $tot_pDiscount=0;
        for (property in price){//loop through each person
            cprice=price[property];
            pvalue=0
            newprice=0;
            //check if this flight has been markup_down by checking the the margin object
            if(cprice['@mark_perc'] !=0){
                pvalue=cprice['@nuc'] * (agentMark/100);
            }
            else{
                pvalue=agentMark;
            }
            $tot_pDiscount=$tot_pDiscount+pvalue;
            if(cprice['@margin']==0 || typeof cprice['@margin']=='undefined'){
                $tot_price=$tot_price+parseInt(cprice['@price']);
            }
            else{
                if(cprice['@markType']=='down'){
                    newprice= (parseInt(cprice['@nuc']) - pvalue)+parseInt(cprice['@totalTaxes']);
                }
                else{
                    newprice= (parseInt(cprice['@nuc']) + pvalue)+parseInt(cprice['@totalTaxes']);
                }
                cprice['@agentPrice']=newprice;
                // cprice['@agentDiscount']=cprice['@agentDiscount']+$tot_pDiscount;
                $tot_price=$tot_price+newprice;
            }
        }
        travelPD[index].discount=$tot_pDiscount;
        travelPD[index].soldPrice= $tot_price;
        travelPackD.saveData(travelPD)
        return travelPD[index].totalAgentPrice;
    }
})
getcentre.filter('currencyConvert', function (currencyData) {
    return function (price) {
        var rate=currencyData.data();
        var convF=rate[0].baseCurrency.currFrom;
        var convL=rate[1].currencyList;
        var currR=1;
        for ($a=0; $a<4; $a++){
            if(convL[$a].curr==convF){
                currR=convL[$a].rate;
                return currR*price
            }
        }
    }
})
getcentre.filter('lower_price', function (searchDatas) {
    return function (price) {
        try{room_count= price[0].HotelOccupancy.RoomCount; return price[0].HotelRoom.Price.Amount}//return (room_count)*(price[0].HotelRoom.Price.Amount);
        catch(e){room_count= price.HotelOccupancy.RoomCount; return price.HotelRoom.Price.Amount }// return (room_count)*(price.HotelRoom.Price.Amount)}
    }
})
getcentre.filter('first_b', function () {
    return function (board) {
        try{return board[0].HotelRoom.Board.$;}
        catch(e){return board.HotelRoom.Board.$;}
    }
})
getcentre.filter('first_r', function () {
    return function (rtype) {
        try{return rtype[0].HotelRoom.RoomType.$;}
        catch(e){return rtype.HotelRoom.RoomType.$;}
    }
})
getcentre.filter('first_c', function () {
    return function (category) {
        try{return category[0].Name;}
        catch(e){return category.Name;}
    }
})
getcentre.filter('isArray', function() {
  return function (input) {
    return angular.isArray(input);
  };
});
getcentre.filter('peradult', function () {
    return function (price) {
        if(Array.isArray(price)){
            if(Array.isArray(price[0].PriceList.Price)){return price[0].PriceList.Price[0].Amount;}
            else{return  price[0].PriceList.Price.Amount}
        }
        else{
            if(Array.isArray(price.PriceList.Price)){
                return price.PriceList.Price[0].Amount;
            }
            else{return price.PriceList.Price.Amount}
        }

    }
})
getcentre.filter('first_d',  function (hdateFilter){
    return function (dates) {
        if(Array.isArray(dates)){
            if(Array.isArray(dates[0].OperationDateList.OperationDate)){return hdateFilter(dates[0].OperationDateList.OperationDate[0]['@date']);}
            else{return  hdateFilter(dates[0].OperationDateList.OperationDate['@date'])}
        }
        else{
            if(Array.isArray(dates.OperationDateList.OperationDate)){
                return hdateFilter(dates.OperationDateList.OperationDate[0]['@date']);
            }
            else{return hdateFilter(dates.OperationDateList.OperationDate['@date'])}
        }
    }
})
getcentre.filter('hotel_room', function (){
    return function (room) {
        room_opt=room.length
        if(room_opt>1){return room_opt}
        else{ return 1;}
    }
})
getcentre.filter('imglarge', function () {
    return function (imgs) {
        try{newimg=imgs.replace("/small", "");}
        catch(e){newimg=imgs}
        return newimg
    }
})
getcentre.filter('hotel_r', function () {
    return function (room) {
        room_opt=room.length
        if(room_opt>1){return 'Room Options'}
        else{ return  'Room Option';}
    }
})
getcentre.filter('currency_ex', function (numberFilter) {
    return function (base, exchange, amount) {
        $scope.curr= amount * exchange;
        return $scope.curr;
    }
})
getcentre.filter('pernight', function () {
    return function (price, tnights) {
        if(price instanceof Array){
            if(typeof price[0].HotelRoom.Price.PriceList =='undefined'){return parseFloat(parseFloat(price[0].HotelRoom.Price.Amount)/tnights).toFixed(2); }
            else if(price[0].HotelRoom.Price.PriceList.Price instanceof Array){return price[0].HotelRoom.Price.PriceList.Price[0].Amount;}
            else if(price[0].HotelRoom.Price.PriceList.Price.Amount)return price[0].HotelRoom.Price.PriceList.Price.Amount;

        }
        else {
            if(typeof price.HotelRoom.Price.PriceList !='undefined'){
                if( price.HotelRoom.Price.PriceList.Price instanceof Array){return price.HotelRoom.Price.PriceList.Price[0].Amount;}
                else {return price.HotelRoom.Price.PriceList.Price.Amount;}
            }
            else{return price.HotelRoom.Price.Amount}
        }
    }
})
getcentre.filter('hotel_contract_comment', function () {
    return function (comment) {
        if(Array.isArray(comment)){
            policy=''
            for($i=0; $i<comment.length; $i++){
                policy= '<div class="col-md-18"><b> Please Take Note : </b>'+comment[$i].Comment['$']+'</div>'+policy;
            }
            return policy
        }
        else{ return  '<div class="col-md-18"><b> Please Take Note : </b>'+comment.Comment['$']+'</div>';}
    }
})
getcentre.filter('hotel_room_policy', function (currencyData, htimeFilter, hdateFilter, currencyConvertFilter, numberFilter) {
    return function (cancelation) {
        if(Array.isArray(cancelation.CancellationPolicy)){
            var curr=currencyData.data();
            curr=curr[0].baseCurrency.symbol;
            policy=''
            for($i=0; $i<cancelation.CancellationPolicy.length; $i++){
                policy= '<div class="col-md-18">Cancellation after '+htimeFilter(cancelation.CancellationPolicy[$i]['@time'])+' '+hdateFilter(cancelation.CancellationPolicy[$i]['@dateFrom'])+' will Cost <span class="curr_book ng-binding" >'+curr+'</span> '+currencyConvertFilter(cancelation.CancellationPolicy[$i]['@amount']).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '1,')+"</div>" + policy;
            }
            return policy;
        }
        else{ return  '<div> Cancellation after '+htimeFilter(cancelation.CancellationPolicy['@time'])+' '+hdateFilter(cancelation.CancellationPolicy['@dateFrom'])+' will Cost <span class="curr_book ng-binding" ng-bind-html="convS"></span>'+currencyConvertFilter(cancelation.CancellationPolicy['@amount']).toFixed(2)+'</div>';}
    }
})
getcentre.filter('tour_cancel_policy', function (htimeFilter, hdateFilter, currencyConvertFilter) {
    return function (cancelation) {
        if(Array.isArray(cancelation)){
            policy=''
            for($i=0; $i<cancelation.length; $i++){

                policy= '<div class="col-md-18">Cancellation from '+hdateFilter(cancelation[$i].Price.DateTimeFrom['@date'])+' to '+hdateFilter(cancelation[$i].Price.DateTimeTo['@date'])+' will Cost '+currencyConvertFilter(cancelation[$i].Price.Amount)+"</div>" + policy;
            }
            return policy;
        }
        else{ return  '<div class="col-md-18">Cancellation from '+hdateFilter(cancelation.Price.DateTimeFrom['@date'])+' to '+hdateFilter(cancelation.Price.DateTimeTo['@date'])+' will Cost '+cancelation.Price.Amount+"</div>";}
    }
})

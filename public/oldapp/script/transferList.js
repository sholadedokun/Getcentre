// JavaScript Document
var transferList =  angular.module('transferList', []); 
transferList.controller('transferList', ['$scope', 'searchData', 'transferData', 'transferListRs', 'purchaseData', 'travelPackD', 'serviceAddRs', '$location','currencyData', function($scope, searchData, transferData, transferListRs, purchaseData, travelPackD, serviceAddRs, $location, currencyData) {
  $scope.getData= searchData.data();
  $scope.getTour=transferData.data();
  $scope.currData= currencyData.data();
  $scope.transferlist=[];
  $scope.offer="";
  search_transfer();
  function search_transfer(){
	  var transfer={};
	  $scope.getData= searchData.data();
	  $scope.travelPD= travelPackD.data();
	  $scope.offer="";
	  if($scope.getData[1].htotalnight==0){
		$scope.search_c=checkCookie('Last_Search');
		$scope.travelPD=checkCookie('travelPD');
		}
		else{
			$scope.search_c=$scope.getData[1];
			console.log($scope.search_c)
			setCookie("Last_Search", $scope.search_c, 30);
			setCookie("travelPD", $scope.travelPD, 30);
		}
		function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();    
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
		function getCookie(cname) {
			var name = cname + "=";
			var ca = document.cookie.split(';');			
			for(var i=0; i<ca.length; i++) {
				var c = ca[i].trim();
				   if (c.indexOf(name)==0) {return c.substring(name.length,c.length);}
			}
			return "";
		}
		function checkCookie(cattype) {
			var lSsearch=getCookie(cattype);
			if (lSsearch != "") {
				return JSON.parse(lSsearch);
			} 
			else {}
		} 
		  $scope.tList =transferListRs.get({hDesCode:$scope.getData[4].TpickCode, hDesType:$scope.getData[4].TpickType, hReturnCode:$scope.getData[4].TdropCode, hReturnType:$scope.getData[4].TdropType, hReturnOption:$scope.getData[4].transfer_return,
	  htransferin:$scope.search_c.hcheckin, 
	  htransferout:$scope.search_c.hcheckout,
	  ttransferin:$scope.getData[4].TpickTime, 
	  ttransferout:$scope.getData[4].TdropTime,
	  'transferBreakDown':JSON.stringify($scope.search_c.hRoomBreak)}, function(tList) {
		console.log($scope.tList)
		$scope.transfers_p=$scope.tList.TransferValuedAvailRS;
		$scope.transfers_total=parseInt($scope.transfers_p['@totalItems']);
		console.log($scope.tList);
		$scope.currData[0].baseCurrency.currFrom=$scope.transfers_p.ServiceTransfer[0].Currency['@code'];
		
		$scope.transfers=$scope.transfers_p.ServiceTransfer;	
	//	if($scope.transfers_total!=0){	$scope.getData[26].availToken=$scope.transfers[0]['@availToken'];}
		
	  })	
	  }
	  function setCookie(cname, cvalue, exdays) {
			var d = new Date();
			d.setTime(d.getTime() + (exdays*24*60*60*1000));
			var expires = "expires="+d.toUTCString();    
			document.cookie = cname + "=" + JSON.stringify(cvalue) + "; " + expires;
		}
		$scope.book_transfer = function (transfer) {
			$scope.purchaseD=purchaseData.data();
			$scope.purchaseT='none';
			if($scope.purchaseD[0]!=null){ $scope.purchaseT=$scope.purchaseD[0]['@purchaseToken']}
			$scope.tservAdd = serviceAddRs.get({
			pToken:$scope.purchaseT,
			Availtoken:transfer['@availToken'], 
			contractName:transfer.ContractList.Contract.Name, 
			contractCode:transfer.ContractList.Contract.IncomingOffice['@code'],
			ServiceType:'ServiceTransfer', 
			TransferType:'IN',
			DateFrom:transfer.DateFrom['@date'], 
			DateFTime:transfer.DateFrom['@time'], 
			currency:transfer.Currency['@code'], 
			code:transfer.TransferInfo.Code, 
			codeType:transfer.TransferInfo.Type['@code'],
			VType:transfer.TransferInfo.VehicleType['@code'],
			tourAdult:transfer.Paxes.AdultCount,
			tourChild:transfer.Paxes.ChildCount,
			destLoc:transfer.DestinationLocation.Code,
			DesType:$scope.getData[4].TdropType,
			pickLoc:transfer.PickupLocation.Code,
			picType:$scope.getData[4].TpickType,	
			tourBreakDown:JSON.stringify($scope.search_c.hRoomBreak)
			},
			function(tservAdd) {		
				console.log(tservAdd)
				$scope.serv=tservAdd.ServiceAddRS.Purchase.ServiceList.Service;
				console.log($scope.serv);
				$scope.services=[]
				if(Array.isArray($scope.serv)){ for(var i=0; i<$scope.services.length; i++){$scope.services.push($scope.serv[i])}}
				else{$scope.services.push($scope.serv) }
				for(var i=0; i<$scope.services.length; i++){
					if($scope.services[i]['@xsi:type']=='ServiceTransfer'){ 
					$scope.cust=[];	
					var transfer_guests=$scope.services[i].Paxes.GuestList.Customer;
					if(Array.isArray(transfer_guests)){
						var all_guest_det=[]
						total_guest=transfer_guests.length;
						for(c=0; c<total_guest; c++){
							guest_det={cust_id:transfer_guests[c].CustomerId, cust_type:transfer_guests[c]['@type'], cust_age:transfer_guests[c].Age}
							all_guest_det.push(guest_det);
						}
						$scope.cust=all_guest_det;	
									
					}
					else{
						guest_det={cust_id:transfer_guests.CustomerId, cust_type:transfer_guests['@type'], cust_age:transfer_guests.Age}
						$scope.cust.push(guest_det);
					}
					var name=$scope.services[i].ProductSpecifications.MasterProductType['@name']+' '+$scope.services[i].ProductSpecifications.MasterServiceType['@name']+' '+transfer.ProductSpecifications.MasterVehicleType['@name'];
					var type=$scope.services[i]['@transferType'];
					var picLocType=$scope.services[i].PickupLocation['@xsi:type'];
					var destLocType=$scope.services[i].DestinationLocation['@xsi:type'];
					if(picLocType=='ProductTransferTerminal'){var pickup=$scope.services[i].ArrivalTravelInfo.ArrivalInfo; var pickupType=pickup.Code}
					else{var pickup=$scope.services[i].PickupLocation; var pickupType='Hotel';}
					if(destLocType=='ProductTransferTerminal'){var dropoff=$scope.services[i].DepartureTravelInfo.DepartInfo; var dropType=dropoff.Code}
					else{var dropoff=$scope.services[i].DestinationLocation; var dropType='Hotel';} 					
					
					travel_pack={ product:'Hotelbeds', productType:'Transfer', purchaseToken:tservAdd.ServiceAddRS.Purchase['@purchaseToken'], Adult:transfer.Paxes.AdultCount, Child:transfer.Paxes.AdultCount,	hdesdesc:$scope.search_c.hdesdesc,	transferDate:transfer.DateFrom['@date'], transferTime:transfer.DateFrom['@time'], Name:name, sepcName:$scope.services[i].ProductSpecifications,  pickup:pickup, dropOff:dropoff, pickType:pickupType, dropType:dropType, Price:$scope.services[i].TotalAmount, Spui:$scope.services[i]['@SPUI'], guestBreak:$scope.search_c.hRoomBreak, cust_det:$scope.cust, pickupDetails:pickup, cancel:$scope.services[i].CancellationPolicies, contact:$scope.services[i].ContactInfoList, productSpec:$scope.services[i].ProductSpecifications, transSpecific:$scope.services[i].TransferSpecificContent, transferInfo:$scope.services[i].TransferInfo.TransferSpecificContent.GenericTransferGuidelinesList.TransferBulletPoint, transpickupInfo:$scope.services[i].TransferPickupInformation, guest_details:null, currency:$scope.services[i].Currency['@code']}; 
					}
					console.log(travel_pack);
					travelPackD.setData(travel_pack)
					setCookie('travelPD',travelPackD.data(), 30)
					$location.path('/travel_pack');	  
				}
			//	$scope.travelers=$scope.AddedtransferServRs.ServiceList.Service.Paxes.GuestList.Customer;
			});
		}
	}
		
	
	])


// JavaScript Document
var transferList =  angular.module('transferList', ['ui.bootstrap']);
 transferList.directive('onFinishRender', function ($timeout) {
    return {
        restrict: 'A',
        link: function (scope, element, attr) {
            if (scope.$last === true) {
                $timeout(function () {
                    scope.$emit('ngRepeatFinished');
                });
            }
        }
    }
 })
transferList.controller('transferList', ['$scope', 'searchData', 'transferData', 'transferListRs', 'transferServiceAddRs', '$location', function($scope, searchData, transferData, transferListRs, transferServiceAddRs, $location) {
  $scope.getData= searchData.data();
  $scope.transferlist=transferData.data();//stores all transfer booked
  $scope.offer="";
  $scope.guest=[[],[]];
  $scope.selecV=false;
  $scope.adult=$scope.getData[28][0]
  $scope.children=$scope.getData[28][1].length;
  while( $scope.guest[0].push([]) < $scope.adult);
  if($scope.children>0){  while( $scope.guest[1].push([]) < $scope.children);}
  search_transfer();
  
  function search_transfer(){
  var transfer={};
  $scope.tList = transferListRs.get({hDesCode:$scope.getData[5].valueData, hDesType:$scope.getData[6].valueCountry, hReturnCode:$scope.getData[8].valueData, hReturnType:$scope.getData[9].valueCountry, hReturnOption:$scope.getData[9].valueName,
  htransferin:$scope.getData[22].valueData, 
  htransferout:$scope.getData[23].valueData,
  ttransferin:$scope.getData[22].valueName, 
  ttransferout:$scope.getData[23].valueName,
  'transferBreakDown':JSON.stringify($scope.getData[28])}, function(tList) {
	$scope.transfers_p=$scope.tList.TransferValuedAvailRS;
    $scope.transfers_total=parseInt($scope.transfers_p['@totalItems']);
	console.log($scope.tList)
	$scope.transfers=$scope.transfers_p.ServiceTransfer;	
	if($scope.transfers_total!=0){	$scope.getData[26].availToken=$scope.transfers[0]['@availToken'];}
	
  })
  }
  
 $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
    //you also get the actual event object
    //do stuff, execute functions -- whatever...
	$('.scroller_container').jScrollPane();
  });
  $scope.addtransfer=function(transferV){
	$scope.transferlist[0]=transferV;
	$scope.selecV=true;
  }
  $scope.addtraveler=function(){
	$scope.transferlist[1]=$scope.guest;
	console.log($scope.transferlist)
	$location.path('/tours/transferCheckout');
  }
	 
  
  $scope.changeDest=function(){
	  $('.t_head_mover').animate({top:-50})
	}
  $scope.searchDest=function(){
	  $scope.transfers.pop()
	  $scope.newtransfer = search_transfer();
	  $('.t_head_mover').animate({top:0})
	  $scope.changetransfers="change";
	  $('.scroller_container').jScrollPane();
	}
  
   $("#transfer_complete").autocomplete({
		source: "server/hotel_autocomplete.php",
		minLength: 3,
		select: function(event, ui) {
			var url = ui.item.id; var pla=ui.item.value;
			if(url != '#') {
				$scope.getData[20].valueData=url;  //setting the destination code from global search data in app.js
				$scope.getData[21].valueData=pla;  //setting the destination description from global search data in app.js
			}
		},
	
		html: true, // optional (jquery.ui.autocomplete.html.js required)
	
	  // optional (if other layers overlap autocomplete list)
		open: function(event, ui) {
			jQuery(".ui-autocomplete").css("z-index", 1000);
		}
	});
  
}]);

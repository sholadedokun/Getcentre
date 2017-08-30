// JavaScript Document

getcentre.controller('webpay', ['$scope', '$route', '$location', '$http', function($scope, $route, $location, $http){
			var payD=JSON.parse(getCookie('payData'));
			$scope.disabled=false;
			function getCookie(cname) {
				var name = cname + "=";
				var ca = document.cookie.split(';');
				for(var i=0; i<ca.length; i++) {
					var c = ca[i].trim();
					   if (c.indexOf(name)==0) {return c.substring(name.length,c.length);}
				}
			}

			//var ref= Math.floor(Math.random()*10000000);
			console.log(payD);
			$scope.waiting=false;
			$scope.amt= Math.round(payD.amount);
			$scope.amount=$scope.amt/100;
			$scope.txn=payD.txn_ref;
			var payhash= payD.txn_ref+''+payD.product_id+''+payD.pay_item_id+''+$scope.amt+'https://www.getcentre.com/#/payMentConfirm'+'02B7CB07322EF0A14A511435421B8CEBCAA28757EC950735E8AC9CE594BD0C2782E9492EA1252030AEB9F4454A4B1E08AF399D7EC0DBEEFD752C0224678788E6';

			var hash = CryptoJS.SHA512(payhash);
			var hashval= document.getElementById('hash_hid');hashval.value=hash;
			var refval= document.getElementById('txn_ref');	refval.value=payD.txn_ref;
			var amnt= document.getElementById('amt');	amnt.value=$scope.amt;
			var cust_id= document.getElementById('cust_id');	cust_id.value=payD.cust_id;
			var cust_id_desc= document.getElementById('cust_id_desc');	cust_id_desc.value=payD.cust_id_desc;
			var cust_name= document.getElementById('cust_name');	cust_name.value=payD.cust_name;
			var cust_name_desc= document.getElementById('cust_name_desc');	cust_name_desc.value=payD.cust_name_desc;
			var pay_id= document.getElementById('pay_id');	cust_id_desc.value=payD.pay_item_id;
			var pay_item_name= document.getElementById('pay_item_name');	pay_item_name.value=payD.pay_item_name;
			var local_date_time= document.getElementById('local_date_time'); local_date_time.value=payD.local_date_time;
			$scope.$apply();
			$scope.cont=function(){	document.getElementById("formSUb").submit(); $scope.waiting=true;}
}])
getcentre.controller('paymentConfirm', ['$scope', '$route', '$location', '$http', function($scope, $route, $location, $http) {
	$scope.waiting=true;
	var refval= document.getElementById('pref');
	$scope.txnref=refval.value;
	$scope.payref=refval.getAttribute("payref");
	$scope.retref=refval.getAttribute("retref");

	$scope.getref=function(){
	 $http({method:'GET', url:"template/webpay_confirm.php?txnref="+$scope.txnref+"&action=get_amount"})
	.then(function successCallback(response) {
		console.log(response);
		amount=response.data.trim();
		var refval=response.txn_ref;
		var payhash=6208+''+$scope.txnref+''+'02B7CB07322EF0A14A511435421B8CEBCAA28757EC950735E8AC9CE594BD0C2782E9492EA1252030AEB9F4454A4B1E08AF399D7EC0DBEEFD752C0224678788E6';
		var hash = CryptoJS.SHA512(payhash);
		//var hashval= document.getElementById('hash_hid');hashval.value=hash;
		p_id=6208;
		$http({method:'GET', url:"template/webpay_confirm.php?txnref="+$scope.txnref+"&p_id="+p_id+"&amount="+amount+"&hash="+hash+"&action=fetch_response"}).
		then(function successCallback(response) {
			$scope.success=true;
			if(typeof(response.data)==='object'){
				$scope.pref=response.data.PaymentReference;
				$scope.res=response.data.ResponseDescription;
			}
			else{
				$scope.pref= 'Not Available';
				$scope.res='Transaction Failed, Please try again Later.';
			}
			console.log($scope.pref);
			$scope.waiting=false;

			if(response.data.ResponseCode!='00'){
				$scope.success=false;
			}
		},
		function errorCallback(response) {

	  });
	},
	function errorCallback(response) {
   	//console.log(response);
  });
 }
}]);

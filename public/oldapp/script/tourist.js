// JavaScript Document
var tourist =  angular.module('tourist', ['ui.bootstrap']);
 tourist.directive('onFinishRender', function ($timeout) {
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
tourist.controller('tourist', ['$scope', 'searchData', 'tourData', function($scope, searchData, tourData) {
  $scope.getData= searchData.data();
  $scope.Math = window.Math;
  $scope.getTour=tourData.data();//stores all ticket booked
  console.log($scope.getTour);
  $scope.tourist=[];
  $scope.guest=[];
  $scope.tourguest=['Please, Select a tour on the left Panel'];
  $scope.tourist_det={title:'',fname:'',lname:''}
  $scope.offer="";
  $scope.allguest=$scope.getData[28];
  $scope.adult=$scope.allguest[0];
  $scope.child=$scope.allguest[1].length;
  $scope.selectTour='none';
  $scope.selectedT=0;
  $scope.cancel_policies=$scope.getTour[0][0].CancellationPolicyList.Price;
  $scope.comment=$scope.getTour[0][0].CommentList.Comment;
  while( $scope.guest.push([[],[]]) < $scope.getTour.length);
  $scope.$on('ngRepeatFinished', function(ngRepeatFinishedEvent) {
    //you also get the actual event object
    //do stuff, execute functions -- whatever...
	$('.scroller_container').jScrollPane();
  });
  
  $scope.addtourist=function(index){
	$scope.selectTour='selected';
	$scope.selectedT=index;
	if( $scope.guest[index][0][0]==null){//if the tab has not been created.
		while( $scope.guest[index][0].push([]) < $scope.adult);
		if($scope.child>0){while( $scope.guest[index][1].push([]) < $scope.child);}	
		$scope.tourguest=[];
		$scope.tourguest.push($scope.guest[index]);
		
	}
	/*$scope.tourist_d={title:'',fname:'',lname:''}
	$scope.tourist_d.title=$scope.tourist_det.title
	$scope.tourist_d.fname=$scope.tourist_det.fname
	$scope.tourist_d.lname=$scope.tourist_det.lname
	$scope.tourist.push($scope.tourist_d);
	console.log($scope.tourist)*/
  }
  $scope.addTtourist=function(index, selected){
	  if(index=='one'){
		  $scope.getTour[selected].push($scope.guest[selected]);
		  console.log($scope.getTour);
	  }
	  else{
	  	$scope.getTour[selected][index].push($scope.guest[selected]);
		console.log($scope.getTour);
	  }
  }
  
  $scope.changeDest=function(){
	  $('.t_head_mover').animate({top:-50})
	}
  $scope.searchDest=function(){
	  $scope.tours.pop()
	  $scope.newtour = search_tour();
	  $('.t_head_mover').animate({top:0})
	  $scope.changetours="change";
	  $('.scroller_container').jScrollPane();
	}
  
}]);
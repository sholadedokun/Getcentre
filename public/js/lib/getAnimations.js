// JavaScript Document
var getAnimations = angular.module('getAnimations', ['ngAnimate']);
getAnimations.animation('.viewanimate', function() {
return {
	enter: function(element, done) {
      element.css({
        opacity: 0.5,
        position: "relative",
		right: 0,
      })
      .animate({
        top: 0,
        left: 0,
        opacity: 1
        }, 1000, done);
    }
}
})

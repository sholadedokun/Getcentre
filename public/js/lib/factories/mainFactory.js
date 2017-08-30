getcentre.factory('blogRS', ['$resource',
    function($resource){
    return $resource('server/BlogRQRS.php', {}, {
        query: {
            method:'GET',
            params:{},
            isArray:true
        }
    });
}]);
getcentre.factory('ltours', ['$resource',
    function($resource){
    return $resource('server/ltours.php', {}, {
      query: {method:'GET',
                params:{
                },
                isArray:true
            }
    });
}]);
getcentre.factory('appRequest', ['$resource', function($resource){
    return {
        sendRequest:function(url){
            return $resource(url+':id', null, {
              'update': { method:'PUT' }
          })
        }
    }
}])
getcentre.factory('sendMailCRs', ['$resource',
  function($resource){
    return $resource('server/sendMC.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
getcentre.factory('sendMailVRs', ['$resource',
  function($resource){
    return $resource('server/sendMV.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

  //flight
  getcentre.factory('flightListRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  getcentre.factory('flightListNextRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailRQ_next.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  getcentre.factory('flightCondRs', ['$resource',
  function($resource){
    return $resource('server/flightConditionRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
  getcentre.factory('flightCheckRs', ['$resource',
  function($resource){
    return $resource('server/flightAvailCheckRQ.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
getcentre.factory('blogImageRs', ['$resource',
function($resource){
 return $resource('server/bimage.php', {}, {
   query: {method:'GET',
             params:{
             },
             isArray:true
         }
 });
}]);
getcentre.factory('registerUser', ['$resource',
function($resource){
  return $resource('server/register_user.php', {}, {
    query: {method:'GET',
              params:{
              },
              isArray:true
          }
  });
}]);
getcentre.factory('loginUserRs', ['$resource',
function($resource){
return $resource('server/login.php', {}, {
 query: {method:'GET',
           params:{
           },
           isArray:true
       }
});
}]);
getcentre.factory('serviceRemoveRs', ['$resource',
  function($resource){
    return $resource('server/serviceRemove_httpRQ.php', {}, {
      query: {method:'POST',
				params:{
				},
				isArray:true
			}
    });
  }]);
getcentre.factory('flightBookRs', ['$resource',
function($resource){
  return $resource('server/flight_book.php', {}, {
    query: {method:'POST',
              params:{
              },
              isArray:true
          }
  });
}]);
getcentre.factory('purchaseConfirmRs', ['$resource',
function($resource){
  return $resource('server/PurchaseConfirmRQ.php', {}, {
    query: {method:'GET',
              params:{
              },
              isArray:true
          }
  });
}]);
getcentre.factory('purchaseRemoveRs', ['$resource',
function($resource){
return $resource('server/purchaseRemove_httpRQ.php', {}, {
query: {method:'POST',
          params:{
          },
          isArray:true
      }
});
}]);
getcentre.factory('sendmailFlight', ['$resource',
  function($resource){
    return $resource('server/booking_email_flight.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);
getcentre.factory('updateB', ['$resource',
    function($resource){
        return $resource('server/updateTrans.php', {}, {
            query: {
                method:'GET',
                params:{},
                isArray:true
            }
        });
    }
]);
getcentre.factory('apiProxy', ['$resource',
    function($resource){
    return $resource('server/api_proxy.php', {}, {
      query: {method:'GET',
                params:{
                },
                isArray:true
            }
    });
}]);
getcentre.factory('hotelShortDetailsRs', ['$resource',
 function($resource){
   return $resource('server/hshotdet.php', {}, {
     query: {method:'GET',
               params:{
               },
               isArray:true
           }
   });
 }]);
 getcentre.factory('hotelFprox', ['$resource',
function($resource){
 return $resource('server/hotelFilterProxRQ.php', {}, {
   query: {method:'GET',
             params:{
             },
             isArray:true
         }
 });
}]);
getcentre.factory('hotelChain', ['$resource',
function($resource){
 return $resource('server/hotelFilterChainRQ.php', {}, {
   query: {method:'GET',
             params:{
             },
             isArray:true
         }
 });
}]);
getcentre.factory('hotelContact', ['$resource',
function($resource){
return $resource('server/hotelContactstRQ.php', {}, {
 query: {method:'GET',
           params:{
           },
           isArray:true
       }
});
}]);
getcentre.factory('lptours', ['$resource',
  function($resource){
    return $resource('server/gettourpack.php', {}, {
      query: {method:'GET',
				params:{
				},
				isArray:true
			}
    });
  }]);

angular.module('getcentreAdmin')
/* factory that handles the API requests,
    here we use inject angular's $resource to easily manage all the API requests
    METHODS i.e GET,PUT,POST; but DELETE is handle where because, angular resource
    doesn't send body with delete;
*/
.factory('appActions', ['$resource', function($resource){
    return {
        //url is the url of the API request we are making
        apiRequest:function(url){
            return $resource('/'+url+':id', null, {
             //we are refrencing the PUT method as update, so we can use it as 'update' in our controller;
              'update': { method:'PUT' }
          })
        }
    }
}])

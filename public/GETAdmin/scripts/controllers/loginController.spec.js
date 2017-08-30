describe('Tests for loginController ', function() {
    var $controller, loginController, appActions, userData, $scope, $location, $q, $httpBackend; ;

    var validUser={username:'ali', password:'password'};

    // Add login endpoint
    var API = 'http://localhost:3000/user/auth';

    // Add mocked login response
    var RESPONSE_SUCCESS = {"status":"success","sessionId":"8d73ipKkd99w6KtR8lrzDsaV5nKKejO2","username":"ali"}

    // Before each test load our getcentreAdmin module
    beforeEach(angular.mock.module('getcentreAdmin'));
    beforeEach(angular.mock.module('ngRoute'));

    // Before each test set our injected loginController service  and map (_loginController_) to our local loginController variable
    beforeEach(inject(function(_$controller_, _appActions_, _userData_, _$rootScope_, _$q_, _$httpBackend_) {
        $controller = _$controller_
        $scope = _$rootScope_.$new();
        $q=_$q_;
        $httpBackend=_$httpBackend_;
        appActions=_appActions_
        userData=_userData_
        loginController = $controller('loginController', {$scope:$scope, appActions:appActions, userData:userData});


    }));

    it('loginController should exist', function() {
        expect(loginController).toBeDefined();

    });

    // A set of tests for our loginController methods
      describe('All modules under the loginController ', function() {
        // A simple test to verify the method all exists
        it('should exist', function() {
          expect($scope.login).toBeDefined();
        });

      });

    //spyOn(loginController, '$scope.login');

    // tests that the password was encrypted
        describe('Password encryption was done', function() {

            beforeEach(function() {
                //spyOn(loginController, '$scope.login');
                // call the login function
                $scope.login(validUser)
            });

          // A simple test to verify the method all exists
          it('password should equal', function() {
            console.log($scope.getUser)
            expect($scope.user.password).toEqual('5f4dcc3b5aa765d61d8327deb882cf99');
          });

        });

  });

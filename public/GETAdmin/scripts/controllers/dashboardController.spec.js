describe('Tests for dashboardController ', function() {
    var $controller, dashboardController, appActions, userData, $scope, $location, $q, $httpBackend; ;

    var validUser={username:'ali', password:'password'};

    // Before each test load our getcentreAdmin module
    beforeEach(angular.mock.module('getcentreAdmin'));
    beforeEach(angular.mock.module('ngRoute'));

    // Before each test set our injected dashboardController service  and map (_dashboardController_) to our local dashboardController variable
    beforeEach(inject(function(_$controller_, _appActions_, _userData_, _$rootScope_, _$q_, _$httpBackend_) {
        $controller = _$controller_
        $scope = _$rootScope_.$new();
        $q=_$q_;
        $httpBackend=_$httpBackend_;
        appActions=_appActions_
        userData=_userData_
        dashboardController = $controller('dashboardController', {$scope:$scope, appActions:appActions, data:userData});
    }));

    it('dashboardController should exist', function() {
        expect(dashboardController).toBeDefined();
    });

    // A set of tests for our dashboardController methods
      describe('All modules under the dashboardController   ', function() {
        // A simple test to verify the method all exists
        it('should exist', function() {
          expect($scope.getAllTodos).toBeDefined();
          expect($scope.updateTodoStatus).toBeDefined();
          expect($scope.findTodo).toBeDefined();
          expect($scope.changeTodoStatus).toBeDefined();
          expect($scope.addOrUpdateTodo).toBeDefined();
          expect($scope.makeContentEditable).toBeDefined();
          expect($scope.addNewTodo).toBeDefined();
          expect($scope.deleteTodo).toBeDefined();
        });
      });

  });

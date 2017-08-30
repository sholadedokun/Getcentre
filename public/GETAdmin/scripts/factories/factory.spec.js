describe('Tests for apiRequests factory ', function() {
    var appActions ;


    // Before each test load our getcentreAdmin module
    beforeEach(angular.mock.module('getcentreAdmin'));

    // Before each test set our injected appActions service  and map (_appActions_) to our local appActions variable
    beforeEach(inject(function(_appActions_) {
        appActions = _appActions_;

    }));

    it('appActions service should exist', function() {
        expect(appActions).toBeDefined();

    });

    // A set of tests for our appActions methods
      describe('All modules under the factory\'s   ', function() {
        // A simple test to verify the method all exists
        it('should exist', function() {
          expect(appActions.apiRequest ).toBeDefined();
        });
      });

  });

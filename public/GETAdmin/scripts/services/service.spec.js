describe('User\'s data services', function() {
    var userData ;

    //sample object for our userData
    var userSample = {
        "_id" : '589a4b7920073b7bcb4bfd6a',
        "username" : "ali",
        "password" : "5f4dcc3b5aa765d61d8327deb882cf99",
        "activeSession" : "cHYZBdvMjWruvcIhHAsAwG1RUGOwonBX",
        "__v" : 0
    }

    // Before each test load our getcentreAdmin module
    beforeEach(angular.mock.module('getcentreAdmin'));
    // Before each test set our injected userData service (_userData_) to our local userData variable
    beforeEach(inject(function(_userData_) {
        userData = _userData_;

    }));

    it('userData service should exist', function() {
        expect(userData).toBeDefined();

    });

    // A set of tests for our userData methods
      describe('All modules under service', function() {
        // A simple test to verify the method all exists
        it('should exist', function() {
          expect(userData.checkLogin).toBeDefined();
          expect(userData.getData).toBeDefined();
          expect(userData.saveData ).toBeDefined();
        });
      });

  });

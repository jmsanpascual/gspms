'use strict'
var loginModule = angular.module('login', []);

loginModule.controller('LoginCtrl', function ($scope, $http, $window) {
    $scope.login = function () {
        $http.post('login', $scope.user).then(function (response) {
            if (response.data.status) {
                $window.location.href = 'welcome';
            } else {
                alert('Ivalid username or password');
            }
        });
    }
});

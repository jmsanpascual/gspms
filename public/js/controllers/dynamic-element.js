'use strict'
var appModule = angular.module('dynamicElement', []);

appModule.controller('DynamicElementCtrl', function ($scope) {
    $scope.fields = [{id: 1}];

    $scope.addField = function () {
        var id = $scope.fields.length + 1;
        $scope.fields.push({id: id});
    };

    $scope.removeField = function () {
        var index = $scope.fields.length - 1;
        $scope.fields.splice(index);
    };
});

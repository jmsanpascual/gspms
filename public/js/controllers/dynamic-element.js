'use strict'

angular.module('dynamicElement', [])

.controller('DynamicElementCtrl', function ($scope) {
    var arrayCount = getLen();
    $scope.fields = arrayCount.length <= 0 ? [{id: 0}] : arrayCount;

    $scope.addField = function () {
        var id = $scope.fields.length + 1;
        $scope.fields.push({id: id});
    };

    $scope.removeField = function () {
        var index = $scope.fields.length - 1;
        $scope.fields.splice(index);
        $scope.$parent.submitData.proj.objective.splice(index);
    };

    function getLen() {
        var arr = [];
        var ctr = 0;

        for(var obj in $scope.$parent.submitData.proj.objective) {
            arr.push({id: ctr++});
        }

        return arr;
    }
});

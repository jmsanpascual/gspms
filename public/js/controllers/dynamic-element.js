'use strict'

angular.module('dynamicElement', [])

.controller('DynamicElementCtrl', function ($scope) {
    var arrayCount = getLen();
    $scope.fields = arrayCount.length <= 0 ? [{id: 0}] : arrayCount;

    $scope.addField = function () {
        var id = $scope.fields.length + 1;
        $scope.fields.push({id: id});
    };

    $scope.removeField = function (index) {
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
})

.controller('DynamicElementTaskController', function ($scope, $rootScope) {
    var arrayCount = getLen();
    $scope.fields = arrayCount.length <= 0 ? [{id: 0}] : arrayCount;
    $scope.$parent.submitData.projAct.tasks = !$scope.$parent.submitData.projAct.tasks ? [] : $scope.$parent.submitData.projAct.tasks;

    $scope.addField = function () {
        var id = $scope.fields.length + 1;
        $scope.fields.push({id: id});
    };

    $scope.removeField = function (index) {
        $scope.fields.splice(index, 1);
        $scope.$parent.submitData.projAct.tasks.splice(index, 1);
    };

    $scope.doneAndUndoneTasks = function (task) {
        if (task.done == undefined) task.done = false;
        else task.done = !task.done;

        $rootScope.$emit('task-updated');
    };

    function getLen() {
        var arr = [];
        var ctr = 0;

        for(var obj in $scope.$parent.submitData.projAct.tasks) {
            arr.push({id: ctr++});
        }

        return arr;
    }
});

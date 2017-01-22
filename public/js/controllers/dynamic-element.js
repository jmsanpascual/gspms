'use strict'

angular.module('dynamicElement', ['volunteer'])

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

.controller('DynamicElementTaskController', function ($scope, $rootScope, $http, defaultModal, Volunteer) {
    var arrayCount = getLen();
    var volunteers = [];

    $scope.fields = arrayCount.length <= 0 ? [{id: 0}] : arrayCount;
    $scope.$parent.submitData.projAct.tasks = !$scope.$parent.submitData.projAct.tasks ? [] : $scope.$parent.submitData.projAct.tasks;

    activate();

    function activate() {
        getVolunteers();
    }

    function getVolunteers() {
        Volunteer.getVolunteers().then(function (newVolunteers) {
            console.log('Volunteers:', newVolunteers);
            volunteers = newVolunteers;
        }, function(error) {
            // toast.error('Unable to load volunteers')
            alert('Unable to load volunteers at the moment.');
            console.log('Error:', error);
        });
    }

    $scope.addField = function () {
        var id = $scope.fields.length + 1;
        $scope.fields.push({id: id});
    };

    $scope.removeField = function (index) {
        var task = $scope.$parent.submitData.projAct.tasks[index];
        $scope.fields.splice(index, 1);

        if (task.id) {
            $http.delete('../delete-task/' + task.id).then(function () {
                $scope.$parent.submitData.projAct.tasks.splice(index, 1);
                $rootScope.$on('update-percentage');
            }, function (error) {

            });
        } else {
            $scope.$parent.submitData.projAct.tasks.splice(index, 1);
        }
    };

    $scope.doneAndUndoneTasks = function (task) {
        if (task.done == undefined) task.done = false;
        else task.done = !task.done;

        $rootScope.$emit('task-updated');
    };

    $scope.addRemarks = function (task) {
        if (!task) return;

        var attrs = {
            size: 'md',
            templateUrl: '../add-task-remarks-view',
            action: 'Add',
            task: task
        };

        if (task.id) {
            attrs.saveUrl = '../update-task';
        }

        defaultModal.showModal(attrs).result.then(function(data){
            console.log('Remarks added successfully', data);
        });
    };

    $scope.assignTask = function (task) {
        if (!task) return;

        if (! task.user_id) task.user_id = volunteers[0].id;

        var attrs = {
            size: 'md',
            templateUrl: '../assign-task-view',
            action: 'Assign a',
            task: task,
            volunteers: volunteers
        };

        if (task.id) {
            attrs.saveUrl = '../update-task';
        }

        defaultModal.showModal(attrs).result.then(function(data){
            console.log('Volunteer was assigned successfully', data);
        });
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

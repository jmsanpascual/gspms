(function() {
    'use strict';

    angular
        .module('task')
        .factory('Task', Task)
        .factory('TaskRestApi', TaskRestApi);

    Task.$inject = ['TaskRestApi'];
    TaskRestApi.$inject = ['$resource'];

    /* @ngInject */
    function Task(TaskRestApi) {
        var getInstance = function (params) {
            return new TaskRestApi(params);
        };

        var getTask = function (params) {
            return TaskRestApi.get(params).$promise.then(function (persons) {
                return persons;
            });
        };

        var getTasks = function () {
            return TaskRestApi.query().$promise.then(function (persons) {
                return persons;
            });
        };

        var addTask = function (params) {
            var person = new TaskRestApi(params);

            return TaskRestApi.save(person).$promise.then(function (response) {
                return response;
            });
        };

        var update = function (params) {
            return TaskRestApi.update(params).$promise.then(function (response) {
                return response;
            });
        };

        return {
            getInstance: getInstance,
            getTask: getTask,
            getTasks: getTasks,
            addTask: addTask,
            update: update
        };
    }

    function TaskRestApi($resource) {
        var restApi = $resource('../tasks/:id', {id: '@id'}, {
            update : {
                url: '../tasks/update',
                method: 'POST'
            }
        });

        return restApi;
    }
})();

(function() {
    'use strict';

    angular
        .module('activityDependencies')
        .factory('Milestone', Milestone)
        .factory('MilestoneRestApi', MilestoneRestApi);

    Milestone.$inject = ['MilestoneRestApi'];
    MilestoneRestApi.$inject = ['$resource'];

    /* @ngInject */
    function Milestone(MilestoneRestApi) {
        var getInstance = function (params) {
            return new MilestoneRestApi(params);
        };

        var getMilestone = function (params) {
            return MilestoneRestApi.get(params).$promise.then(function (persons) {
                return persons;
            });
        };

        var getAll = function () {
            return MilestoneRestApi.query().$promise.then(function (persons) {
                return persons;
            });
        };

        var addMilestone = function (params) {
            var person = new MilestoneRestApi(params);

            return MilestoneRestApi.save(person).$promise.then(function (response) {
                return response;
            });
        };

        var update = function (params) {
            return MilestoneRestApi.update(params).$promise.then(function (response) {
                return response;
            });
        };

        return {
            getInstance: getInstance,
            getMilestone: getMilestone,
            getAll: getAll,
            addMilestone: addMilestone,
            update: update
        };
    }

    function MilestoneRestApi($resource) {
        var restApi = $resource('../milestone/:id', {id: '@id'}, {
            update : {
                url: '../milestone/update',
                method: 'PUT'
            }
        });

        return restApi;
    }
})();

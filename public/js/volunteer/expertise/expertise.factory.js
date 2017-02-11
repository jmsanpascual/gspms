(function() {
    'use strict';

    angular
        .module('volunteer')
        .factory('Expertise', Expertise)
        .factory('ExpertiseRestApi', ExpertiseRestApi);

    Expertise.$inject = ['ExpertiseRestApi'];
    ExpertiseRestApi.$inject = ['$resource'];

    /* @ngInject */
    function Expertise(ExpertiseRestApi) {
        var getInstance = function (params) {
            return new ExpertiseRestApi(params);
        };

        var getExpertise = function (params) {
            return ExpertiseRestApi.get(params).$promise.then(function (persons) {
                return persons;
            });
        };

        var getAll = function () {
            return ExpertiseRestApi.query().$promise.then(function (persons) {
                return persons;
            });
        };

        var addExpertise = function (params) {
            var person = new ExpertiseRestApi(params);

            return ExpertiseRestApi.save(person).$promise.then(function (response) {
                return response;
            });
        };

        var update = function (params) {
            return ExpertiseRestApi.update(params).$promise.then(function (response) {
                return response;
            });
        };

        return {
            getInstance: getInstance,
            getExpertise: getExpertise,
            getAll: getAll,
            addExpertise: addExpertise,
            update: update
        };
    }

    function ExpertiseRestApi($resource) {
        var restApi = $resource('../expertise/:id', {id: '@id'}, {
            update : {
                url: '../expertise/update',
                method: 'PUT'
            }
        });

        return restApi;
    }
})();

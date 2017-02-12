(function() {
    'use strict';

    angular
        .module('activityDependencies')
        .factory('Phase', Phase)
        .factory('PhaseRestApi', PhaseRestApi);

    Phase.$inject = ['PhaseRestApi'];
    PhaseRestApi.$inject = ['$resource'];

    /* @ngInject */
    function Phase(PhaseRestApi) {
        var getInstance = function (params) {
            return new PhaseRestApi(params);
        };

        var getPhase = function (params) {
            return PhaseRestApi.get(params).$promise.then(function (persons) {
                return persons;
            });
        };

        var getAll = function () {
            return PhaseRestApi.query().$promise.then(function (persons) {
                return persons;
            });
        };

        var addPhase = function (params) {
            var person = new PhaseRestApi(params);

            return PhaseRestApi.save(person).$promise.then(function (response) {
                return response;
            });
        };

        var update = function (params) {
            return PhaseRestApi.update(params).$promise.then(function (response) {
                return response;
            });
        };

        return {
            getInstance: getInstance,
            getPhase: getPhase,
            getAll: getAll,
            addPhase: addPhase,
            update: update
        };
    }

    function PhaseRestApi($resource) {
        var restApi = $resource('../phase/:id', {id: '@id'}, {
            update : {
                url: '../phase/update',
                method: 'PUT'
            }
        });

        return restApi;
    }
})();

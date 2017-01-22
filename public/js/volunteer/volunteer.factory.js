(function() {
    'use strict';

    angular
        .module('volunteer')
        .factory('Volunteer', Volunteer)
        .factory('VolunteerRestApi', VolunteerRestApi);

    Volunteer.$inject = ['VolunteerRestApi'];
    VolunteerRestApi.$inject = ['$resource'];

    /* @ngInject */
    function Volunteer(VolunteerRestApi) {
        var getInstance = function (params) {
            return new VolunteerRestApi(params);
        };

        var getVolunteer = function (params) {
            return VolunteerRestApi.get(params).$promise.then(function (persons) {
                return persons;
            });
        };

        var getVolunteers = function () {
            return VolunteerRestApi.query().$promise.then(function (persons) {
                return persons;
            });
        };

        var addVolunteer = function (params) {
            var person = new VolunteerRestApi(params);

            return VolunteerRestApi.save(person).$promise.then(function (response) {
                return response;
            });
        };

        var update = function (params) {
            return VolunteerRestApi.update(params).$promise.then(function (response) {
                return response;
            });
        };

        return {
            getInstance: getInstance,
            getVolunteer: getVolunteer,
            getVolunteers: getVolunteers,
            addVolunteer: addVolunteer,
            update: update
        };
    }

    function VolunteerRestApi($resource) {
        var restApi = $resource('../volunteers/:id', {id: '@id'}, {
            update : {
                url: '../volunteers/update',
                method: 'POST'
            }
        });

        return restApi;
    }
})();

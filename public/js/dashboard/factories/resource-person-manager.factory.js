(function() {
    'use strict';

    angular
        .module('dashboard')
        .factory('ResourcePersonManager', ResourcePersonManager);

    ResourcePersonManager.$inject = [];

    /* @ngInject */
    function ResourcePersonManager() {
        var persons = [];
        var service = {
            get: getPersons,
            set: setPersons,
        };

        return service;

        function getPersons() {
            return persons;
        }

        function setPersons(data) {
            persons = data;
        }
    }
})();

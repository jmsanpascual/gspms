(function() {
    'use strict';

    angular
        .module('resourcePersonService')
        .factory('ResourcePersonManager', ResourcePersonManager);

    ResourcePersonManager.$inject = [];

    /* @ngInject */
    function ResourcePersonManager() {
        var resourcePerson = [];
        var service = {
            get: getResourcePerson,
            set: setResourcePerson
        };

        return service;

        function getResourcePerson() {
            return resourcePerson;
        }

        function setResourcePerson(data) {
            resourcePerson = data;
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('dashboard')
        .factory('StatusManager', StatusManager);

    StatusManager.$inject = [];

    /* @ngInject */
    function StatusManager() {
        var status = [];
        var service = {
            get: getStatus,
            set: setStatus,
        };

        return service;

        function getStatus() {
            return status;
        }

        function setStatus(data) {
            status = data;
        }
    }
})();

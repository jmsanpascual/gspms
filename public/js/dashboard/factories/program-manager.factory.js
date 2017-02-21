(function() {
    'use strict';

    angular
        .module('dashboard')
        .factory('ProgramManager', ProgramManager);

    ProgramManager.$inject = [];

    /* @ngInject */
    function ProgramManager() {
        var programs = [];
        var service = {
            get: getPrograms,
            set: setPrograms,
        };

        return service;

        function getPrograms() {
            return programs;
        }

        function setPrograms(data) {
            programs = data;
        }
    }
})();

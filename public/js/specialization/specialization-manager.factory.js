/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('specialization')
        .factory('SpecializationManager', SpecializationManager);

    SpecializationManager.$inject = [];

    /* @ngInject */
    function SpecializationManager() {
        var specialization;
        var service = {
            get: getSpecialization,
            set: setSpecialization
        };

        return service;

        function getSpecialization() {
            return specialization;
        }

        function setSpecialization(data) {
            specialization = data;
        }
    }
})();

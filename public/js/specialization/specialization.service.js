/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('specialization')
        .service('SpecializationService', SpecializationService);

    SpecializationService.$inject = ['SpecializationManager'];

    /* @ngInject */
    function SpecializationService(SpecializationManager) {
        this.get = getSpecializationManager;
        this.set = setSpecializationManager;

        function getSpecializationManager() {
            return SpecializationManager.get();
        }

        function setSpecializationManager(data) {
            SpecializationManager.set(data);
        }
    }
})();

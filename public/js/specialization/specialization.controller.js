/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('specialization')
        .controller('SpecializationController', SpecializationController);

    SpecializationController.$inject = ['SpecializationManager', 'Specialization', 'SpecializationService'];

    /* @ngInject */
    function SpecializationController(SpecializationManager, Specialization, SpecializationService) {
        var vm = this;
        vm.specialization = [];

        activate();

        function activate() {

        }
    }
})();

/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('specialization')
        .controller('SpecializationController', SpecializationController);

    SpecializationController.$inject = [
        'SpecializationManager',
        'Specialization',
        'defaultModal',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        '$http'
    ];

    /* @ngInject */
    function SpecializationController(SpecializationManager, Specialization,
        defaultModal, DTOptionsBuilder, DTColumnDefBuilder, $http) {
        var vm = this;
        vm.resource_id;
        vm.programs = [];
        vm.specialization = [];

        vm.refresh = getSpecialization;
        vm.add = addSpecialization;
        vm.edit = editSpecialization;
        vm.delete = deleteSpecialization;

        activate();

        function activate() {
            vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');
            vm.dtColumnDefs = [
                DTColumnDefBuilder.newColumnDef(0),
                DTColumnDefBuilder.newColumnDef(1).notSortable()
            ];
            getPrograms();
        }

        function getPrograms() {
            $http.get('../programs').then(function(result) {
                result = result.data[0];
                vm.programs = result.program;
            });
        }

        function getSpecialization() {
            Specialization.get({resource_id: vm.resource_id}).$promise.then(function(result){
                SpecializationManager.set(result);
                vm.specialization = SpecializationManager.get();
            });
        }

        function addSpecialization() {
            var attr = {
                templateUrl: '../specialization/form/add',
                saveUrl: '../specialization',
                special: {
                    resource_id: vm.resource_id
                },
                programs: vm.programs
            };
            console.log('add specialization', attr)
            var modal = defaultModal.showModal(attr);

            onAdd(modal);
        }

        function onAdd(modal) {
            modal.result.then(function(result) {
                vm.refresh();
            });
        }

        function editSpecialization(data) {
            var attr = {
                templateUrl: '../specialization/form/edit',
                saveUrl: '../specialization/update',
                special: angular.copy(data),
                programs: vm.programs
            };

            var modal = defaultModal.showModal(attr);

            onEdit(modal);
        }

        function onEdit(modal) {
            modal.result.then(function(result){
                vm.refresh();
            });
        }

        function deleteSpecialization(data) {
            var confirm = window.confirm('Are you sure you want to delete this specialization');
            if(!confirm) return;

            Specialization.remove({id: data.id}).$promise.then(function(){
                vm.refresh();
            });
        }
    }
})();

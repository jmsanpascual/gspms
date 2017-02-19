

(function() {
    'use strict';

    angular
        .module('activityItemExpense')
        .controller('ActivityItemExpenseController', ActivityItemExpenseController);

    ActivityItemExpenseController.$inject = [
        'ActivityItemExpenseManager',
        'ActivityItemExpense',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal',
        'ProjectExpenseManager'
    ];

    /* @ngInject */
    function ActivityItemExpenseController(ActivityItemExpenseManager, ActivityItemExpense,
        DTOptionsBuilder, DTColumnDefBuilder, defaultModal, ProjectExpenseManager) {
        var vm = this;
        vm.activity_id;
        vm.activityitemexpense = [];

        vm.refresh = getActivity;
        vm.add = addActivity;
        vm.edit = editActivity;

        activate();

        function activate() {
            vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');
            vm.dtColumnDefs = [
                DTColumnDefBuilder.newColumnDef(0),
                DTColumnDefBuilder.newColumnDef(1),
                DTColumnDefBuilder.newColumnDef(2),
                DTColumnDefBuilder.newColumnDef(3),
                DTColumnDefBuilder.newColumnDef(4),
                DTColumnDefBuilder.newColumnDef(5).notSortable()
            ];
            vm.projectExpense = ProjectExpenseManager.get();
        }

        function getActivity() {
            ActivityItemExpense.get({activity_id: vm.activity_id}).$promise.then(function(result) {
                ActivityItemExpenseManager.set(result);
                vm.activityitemexpense = ActivityItemExpenseManager.get();
            });
        }

        function addActivity() {
            var attr = {
                templateUrl: '../activity-item-expense/form/add',
                saveUrl: '../activity-item-expense',
                data: {
                    activity_id: vm.activity_id
                },
                categories: vm.projectExpense
            };

            var modal = defaultModal.showModal(attr);

            onAdd(modal);
        }

        function onAdd(modal) {
            modal.result.then(function(result) {
                vm.refresh();
            });
        }

        function editActivity(data) {
            var attr = {
                templateUrl: '../activity-item-expense/form/edit',
                saveUrl: '../activity-item-expense/update',
                data: angular.copy(data),
                categories: vm.projectExpense
            };

            var modal = defaultModal.showModal(attr);

            onEdit(modal);
        }

        function onEdit(modal) {
            modal.result.then(function(result){
                vm.refresh();
            });
        }
    }
})();

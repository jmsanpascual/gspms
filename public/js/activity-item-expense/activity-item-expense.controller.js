

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
        'ProjectExpenseManager',
        'ProjectExpense'
    ];

    /* @ngInject */
    function ActivityItemExpenseController(ActivityItemExpenseManager, ActivityItemExpense,
        DTOptionsBuilder, DTColumnDefBuilder, defaultModal, ProjectExpenseManager, ProjectExpense) {
        var vm = this;
        vm.activity_id;
        vm.activityitemexpense = [];

        vm.refresh = getActivity;
        vm.add = addActivity;
        vm.edit = editActivity;
        vm.getProjectExpense = getProjectExpense;

        activate();

        function activate() {
            vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');
            vm.dtColumnDefs = [
                DTColumnDefBuilder.newColumnDef(0),
                DTColumnDefBuilder.newColumnDef(1),
                DTColumnDefBuilder.newColumnDef(2).withClass('right'),
                DTColumnDefBuilder.newColumnDef(3).withClass('right'),
                DTColumnDefBuilder.newColumnDef(4).withClass('right'),
                DTColumnDefBuilder.newColumnDef(5).notSortable()
            ];
            vm.projectExpense = ProjectExpenseManager.get();
        }

        function getProjectExpense(projId) {
            if (!vm.projectexpense) {
                console.log('Proj Id: ', projId);
                ProjectExpense.get({ proj_id: projId }).$promise.then(function(result){
                    console.log('expense: ', result);
                    ProjectExpenseManager.set(result.expense);
                    vm.projectExpense = result.expense;
                });
            }
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

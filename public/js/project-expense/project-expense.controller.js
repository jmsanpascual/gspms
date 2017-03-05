/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('projectExpense')
        .controller('ProjectExpenseController', ProjectExpenseController);

    ProjectExpenseController.$inject = [
        'ProjectExpenseManager',
        'ProjectExpense',
        'defaultModal',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'ExpenseManager'
    ];

    /* @ngInject */
    function ProjectExpenseController(ProjectExpenseManager, ProjectExpense,
        defaultModal, DTOptionsBuilder, DTColumnDefBuilder, ExpenseManager) {
        var vm = this;
        vm.proj_id;
        vm.projectexpense = [];

        vm.refresh = getProjectExpense;
        vm.add = addExpense;
        vm.edit = editExpense;

        activate();

        function activate() {
            // getProjectExpense();
            vm.expense = ExpenseManager.get();

            vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');
            vm.dtColumnDefs = [
                DTColumnDefBuilder.newColumnDef(0),
                DTColumnDefBuilder.newColumnDef(1),
                DTColumnDefBuilder.newColumnDef(2),
                DTColumnDefBuilder.newColumnDef(3).notSortable()
            ];
        }

        function getProjectExpense() {
            var data = {proj_id: vm.proj_id};
            console.log('expense - - - ', data);
            ProjectExpense.get(data).$promise.then(function(result){
                vm.expense.total = result.total_expense;
                ProjectExpenseManager.set(result.expense);
                vm.projectexpense = ProjectExpenseManager.get();
            });
        }

        function addExpense() {
            var attr = {
                templateUrl: '../project-expense/form/add',
                saveUrl: '../project-expense',
                expense: {
                    proj_id: vm.proj_id
                }
            };

            var modal = defaultModal.showModal(attr);

            onAdd(modal);
        }

        function onAdd(modal) {
            modal.result.then(function(result) {
                vm.expense.total = result.total_expense;
                vm.refresh();
            });
        }

        function editExpense(expense) {
            var attr = {
                templateUrl: '../project-expense/form/edit',
                saveUrl: '../project-expense/update',
                expense: angular.copy(expense)
            };

            var modal = defaultModal.showModal(attr);

            onEdit(modal);
        }

        function onEdit(modal) {
            modal.result.then(function(result){
                vm.expense.total = result.total_expense;
                vm.refresh();
            });
        }
    }
})();

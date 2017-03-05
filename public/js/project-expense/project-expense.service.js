/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('projectExpense')
        .service('ProjectExpenseService', ProjectExpenseService);

    ProjectExpenseService.$inject = ['ProjectExpenseManager'];

    /* @ngInject */
    function ProjectExpenseService(ProjectExpenseManager) {
        this.get = getProjectExpenseManager;
        this.set = setProjectExpenseManager;

        function getProjectExpenseManager() {
            return ProjectExpenseManager.get();
        }

        function setProjectExpenseManager(data) {
            ProjectExpenseManager.set(data);
        }
    }
})();

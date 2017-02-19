/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('projectExpense')
        .factory('ProjectExpenseManager', ProjectExpenseManager);

    ProjectExpenseManager.$inject = [];

    /* @ngInject */
    function ProjectExpenseManager() {
        var projectExpense;
        var service = {
            get: getProjectExpense,
            set: setProjectExpense
        };

        return service;

        function getProjectExpense() {
            return projectExpense;
        }

        function setProjectExpense(data) {
            projectExpense = data;
        }
    }
})();

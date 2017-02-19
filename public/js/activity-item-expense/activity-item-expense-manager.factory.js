

(function() {
    'use strict';

    angular
        .module('activityItemExpense')
        .factory('ActivityItemExpenseManager', ActivityItemExpenseManager);

    ActivityItemExpenseManager.$inject = [];

    /* @ngInject */
    function ActivityItemExpenseManager() {
        var activityItemExpense;
        var service = {
            get: getActivityItemExpense,
            set: setActivityItemExpense
        };

        return service;

        function getActivityItemExpense() {
            return activityItemExpense;
        }

        function setActivityItemExpense(data) {
            activityItemExpense = data;
        }
    }
})();

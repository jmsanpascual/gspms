'use strict'
angular.module('budgetRequestStatus.service', ['ngResource'])

.factory('BudgetRequestStatusRestApi', function ($resource) {
    return $resource('../budget-request-status');
});

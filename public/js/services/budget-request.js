'use strict'
angular.module('budgetRequest.service', ['ngResource'])

.factory('BudgetRequestRestApi', function ($resource) {
    return $resource('../budget-request/:id', {id : '@id'});
});

'use strict'
angular.module('items.service', ['ngResource'])
.factory('ExpenseManager', function() {
    var expense = {};

    function setExpense(expenseData) {
        expense = expenseData;
    }
    function setTotal(totalExpense) {
        expense.total = totalExpense;
    }

    function getExpense() {
        return expense;
    }

    return {
        set : setExpense,
        setTotal: setTotal,
        get : getExpense
    };
})
.factory('ItemsRestApi', function ($resource) {
    return $resource('../items/:id', {id : '@id'});
});

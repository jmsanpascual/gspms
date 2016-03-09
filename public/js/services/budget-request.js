'use strict'
angular.module('budgetRequest.service', ['ngResource'])

.factory('BudgetRequestRestApi', function ($resource) {
    return $resource('../budget-request/:id', {id : '@id'},
    	{request : {
    			method : 'POST',
    			url : '../budget-request/request',
    			params : {
    				id : '@id',
    				proj_id : '@proj_id',
    				br_id : '@br_id'
    			}
    		}
    	}
    );
});

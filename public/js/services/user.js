'use strict'
var projectStatusService = angular.module('user.service', ['ngResource']);

projectStatusService.factory('UserRestApi', function ($resource) {
    return $resource('../user', {}, {
    	'getChampion' : {
    		url : '../user/getChampion',
    		method: 'GET'
    	},
    	'getResourcePerson' : {
    		url : '../user/getResourcePerson',
    		method : 'GET'
    	}
    });
});

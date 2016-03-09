'use strict'

angular.module('schoolService', ['ngResource'])

.factory('SchoolRestApi', function ($resource) {
    var restApi = $resource('../schools');

    return restApi;
});

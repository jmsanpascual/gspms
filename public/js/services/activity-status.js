'use strict'
var activityStatus = angular.module('activityStatus.service', ['ngResource']);

activityStatus.factory('activityStatusRestApi', function ($resource) {
    return $resource('../activity-status');
});

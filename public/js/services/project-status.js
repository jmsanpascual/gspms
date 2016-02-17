'use strict'
var projectStatusService = angular.module('projectStatus.service', ['ngResource']);

projectStatusService.factory('ProjectStatusRestApi', function ($resource) {
    return $resource('../project-status');
});

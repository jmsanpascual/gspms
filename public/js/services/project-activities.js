'use strict'
var projectActivitiesService = angular.module('projectActivities.service', ['ngResource']);

projectActivitiesService.factory('ProjectActivities', function(ProjectActivitiesRestApi){
	var _self = this;
});

projectActivitiesService.factory('ProjectActivitiesRestApi', function ($resource) {
    return $resource('../project-activities/:activity_id', {activity_id : '@activity_id'});
});

'use strict'
angular.module('projectStatus.service', ['ngResource'])

.factory('ProjectStatusRestApi', function ($resource) {
    return $resource('../project-status');
});

'use strict'
var programService = angular.module('program.service', ['ngResource']);

programService.factory('ProgramRestApi', function ($resource) {
    return $resource('../programs');
});

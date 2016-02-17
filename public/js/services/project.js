'use strict'
var projectSrvc = angular.module('project.service', ['ngResource']);

projectSrvc.factory('Project', function (ProjRestApi) {
    var _self = this;
    var projects = null;

    var getProjects = function () {
        return ProjRestApi.query().$promise.then(function (projects) {
            projects = cleanRestResponse(projects);
            return projects;
        });
    };

    var addProject = function (params) {
        var project = new ProjRestApi(params);

        return ProjRestApi.save(project).$promise.then(function (response) {
            return response;
        });
    };

    var cleanRestResponse = function (obj) {
        return JSON.parse(angular.toJson(obj));
    };

    return {
        getProjects: getProjects,
        addProject: addProject
    };
});

projectSrvc.factory('ProjRestApi', function ($resource) {
    var restApi = $resource('../projects');

    return restApi;
});

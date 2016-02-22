'use strict'
var projectService = angular.module('project.service', ['ngResource']);

projectService.factory('Project', function (ProjRestApi) {
    var _self = this;
    var projects = null;

    var getProjects = function () {
        return ProjRestApi.query().$promise.then(function (projects) {
            return projects;
        });
    };

    var addProject = function (params) {
        var project = new ProjRestApi(params);

        return ProjRestApi.save(project).$promise.then(function (response) {
            return response;
        });
    };

    var fetchProject = function(params) {

        return ProjRestApi.fetchProj(params).$promise.then(function(response){
            return response;
        });
    };

    return {
        getProjects: getProjects,
        addProject: addProject,
        fetchProject : fetchProject
    };
});

projectService.factory('ProjRestApi', function ($resource) {
    var restApi = $resource('../projects/:id', {id:'@id'},
        {
            fetchProj: {
                method: 'GET',
                params: '@id',
                url: '../projects/fetch/:id'
            }

        });

    return restApi;
});

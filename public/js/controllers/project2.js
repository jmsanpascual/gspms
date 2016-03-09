'use strict'
var projectCtrl = angular.module('project.controller', [
    'project.service',
    'program.service',
    'projectStatus.service',
    'dynamicElement'
]);

projectCtrl.controller('ProjectCtrl', function ($scope, Project, ProgramRestApi, ProjectStatusRestApi) {
    $scope.projects = {};

    Project.getProjects().then(function (projects) {
        console.log('Projects:', projects);
        $scope.projects = projects;
    });

    ProgramRestApi.query().$promise.then(function (programs) {
        console.log('Programs:', programs);
        $scope.programs = programs;
        $scope.program = $scope.programs[0];
    });

    ProjectStatusRestApi.query().$promise.then(function (projectStatus) {
        console.log('Project Status:', projectStatus);
        $scope.projectStatus = projectStatus;
        $scope.status = $scope.projectStatus[0];
    });

    $scope.saveProject = function () {
        $scope.project.program_id = $scope.program.id;
        $scope.project.proj_status_id = $scope.status.id;

        Project.addProject($scope.project).then(function (response) {
            alert($scope.project.name + ' was succesfully added');
        });
    };
});

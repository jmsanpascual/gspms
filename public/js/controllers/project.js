'use strict'
var projectCtrl = angular.module('project.controller', ['project.service', 'dynamicElement']);

projectCtrl.controller('ProjectCtrl', function ($scope, Project) {
    Project.getProjects().then(function (projects) {
        $scope.projects = projects;
        console.log(projects);
    });

    $scope.saveProject = function () {
        Project.addProject($scope.project).then(function (response) {
            alert($scope.project.name + ' was succesfully added');
        });
    };
});

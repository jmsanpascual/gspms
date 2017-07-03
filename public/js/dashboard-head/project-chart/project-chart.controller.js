(function() {
    'use strict';

    angular
        .module('projectChart')
        .controller('ProjectChartController', ProjectChartController);

    ProjectChartController.$inject = ['ProjectChartManager', '$http'];

    /* @ngInject */
    function ProjectChartController(ProjectChartManager, $http) {
        var vm = this;
        vm.projects = [];
        vm.projectStatus = [];

        vm.chart;
        activate();

        function activate() {
            $http.get('../project-chart').then(function(result) {
                ProjectChartManager.set(result.data);
                vm.projects = ProjectChartManager.get();
                var ctx = document.getElementById("doughnut3").getContext("2d");
                vm.chart = new window.Chart(ctx, vm.projects);
            });

            $http.get('../project-status-chart').then(function(result) {
                vm.projectStatus = result.data
                var ctx = document.getElementById("doughnut1").getContext("2d");
                vm.chartStatus = new window.Chart(ctx, vm.projectStatus);
            });
        }
    }
})();

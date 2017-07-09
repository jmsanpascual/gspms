(function() {
    'use strict';

    angular
        .module('projectChart')
        .factory('ProjectChartManager', ProjectChartManager);

    ProjectChartManager.$inject = [];

    /* @ngInject */
    function ProjectChartManager() {
        var chart = [];
        var service = {
            get: getProjectChart,
            set: setProjectChart
        };

        return service;

        function getProjectChart() {
            return chart;
        }

        function setProjectChart(chartData) {
            chart = chartData;
        }
    }
})();

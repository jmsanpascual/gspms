(function() {
    'use strict';

    angular
        .module('activityChart')
        .factory('ActivityChartManager', ActivityChartManager);

    ActivityChartManager.$inject = [];

    /* @ngInject */
    function ActivityChartManager() {
        var chart = [];
        var service = {
            get: getActivityChart,
            set: setActivityChart
        };

        return service;

        function getActivityChart() {
            return chart;
        }

        function setActivityChart(chartData) {
            chart = chartData;
        }
    }
})();


(function() {
    'use strict';

    angular
        .module('dashboard')
        .factory('DashboardManager', DashboardManager);

    DashboardManager.$inject = [];

    /* @ngInject */
    function DashboardManager() {
        var dashboard;
        var service = {
            get: getDashboard,
            set: setDashboard
        };

        return service;

        function getDashboard() {
            return dashboard;
        }

        function setDashboard(data) {
            dashboard = data;
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('activityChart')
        .controller('ActivityChartController', ActivityChartController);

    ActivityChartController.$inject = ['ActivityChartManager', '$http'];

    /* @ngInject */
    function ActivityChartController(ActivityChartManager, $http) {
        var vm = this;
        vm.activities = [];
        activate();

        function activate() {
            $http.get('../activity-chart').then(function(result) {
                ActivityChartManager.set(result.data);
                vm.activities = ActivityChartManager.get();

                var ctx2 = document.getElementById("doughnut2").getContext("2d");
                var myDoughnut2 = new window.Chart(ctx2, vm.activities);
            });
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('fundLogs', ['datatables'])
        .controller('FundLogsCtrl', FundLogsCtrl);

    FundLogsCtrl.$inject = ['$http', 'DTOptionsBuilder', 'DTColumnDefBuilder'];

    /* @ngInject */
    function FundLogsCtrl($http, DTOptionsBuilder, DTColumnDefBuilder) {
        var vm = this;

        vm.dtInstance = {};
        vm.schoolFunds = [];

        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');
        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2)
        ];

        activate();

        function activate() {
            $http.get('../funds/school-funds').then(function (result) {
                vm.schoolFunds = result.data;
            });
        }
    }
})();

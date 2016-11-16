(function() {
    'use strict';

    angular
        .module('funds')
        .controller('ViewFundCtrl', ViewFundCtrl);

    ViewFundCtrl.$inject = ['fund'];

    /* @ngInject */
    function ViewFundCtrl(fund) {
        var vm = this;

        activate();

        function activate() {
            fund.query().then(function (funds) {
                vm.funds = funds;
                vm.fund = funds[0];
            });
        }
    }
})();

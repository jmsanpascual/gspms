(function() {
    'use strict';

    angular
        .module('task', [
            'datatables',
            'common.service',
            'ui.bootstrap',
            'ngResource',
            'items.service',
            'activityItemExpense',
            'projectExpense'
        ]);
})();

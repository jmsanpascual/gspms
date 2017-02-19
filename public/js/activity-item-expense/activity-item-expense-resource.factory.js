

(function() {
    'use strict';

    angular
        .module('activityItemExpense')
        .factory('ActivityItemExpense', ActivityItemExpense);

    ActivityItemExpense.$inject = ['$resource'];

    /* @ngInject */
    function ActivityItemExpense($resource) {
        var otherMethods = {
            update: {
                'method': 'POST',
                'params': {
                    'id': '@id'
                }
            },
            get: {
                isArray: true
            }
        };

        return $resource('../activity-item-expense/:id', {id: '@id'}, otherMethods);
    }
})();

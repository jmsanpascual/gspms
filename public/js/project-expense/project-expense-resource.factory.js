/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('projectExpense')
        .factory('ProjectExpense', ProjectExpense);

    ProjectExpense.$inject = ['$resource'];

    /* @ngInject */
    function ProjectExpense($resource) {
        var otherMethods = {
            update: {
                'method': 'POST',
                'params': {
                    'id': '@id'
                }
            }
        };

        return $resource('../project-expense/:id', {id: '@id'}, otherMethods);
    }
})();

/**
 * @author TMJP Engineering Team
 * @copyright 2017
 */

(function() {
    'use strict';

    angular
        .module('specialization')
        .factory('Specialization', Specialization);

    Specialization.$inject = ['$resource'];

    /* @ngInject */
    function Specialization($resource) {
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

        return $resource('../specialization/:id', {id: '@id'}, otherMethods);
    }
})();

(function() {
    'use strict';

    angular
        .module('school')
        .factory('School', School);

    School.$inject = ['$resource'];

    /* @ngInject */
    function School($resource) {
        var resource = new $resource('../schools/:id', {id: '@id'});

        return resource;
    }
})();

(function() {
    'use strict';

    angular
        .module('notification')
        .factory('Notification', Notification);

    Notification.$inject = ['$resource'];

    /* @ngInject */
    function Notification($resource) {
        return $resource('/gspms/public/notifications/:id', {id : '@id'});
    }
})();

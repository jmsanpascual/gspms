(function() {
    'use strict';

    angular
        .module('notification')
        .factory('Notification', Notification);

    Notification.$inject = ['$resource'];

    /* @ngInject */
    function Notification($resource) {
        var otherMethods = {
            query: {
                isArray: false
            },
            getAllNotif: {
                method: 'GET',
                url: '/gspms/public/notifications/getAllNotif',
                isArray:true
            }
        }
        return $resource('/gspms/public/notifications/:id', {id : '@id'}, otherMethods);
    }
})();

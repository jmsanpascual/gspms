(function() {
    'use strict';

    angular
        .module('notification')
        .factory('NotificationManager', NotificationManager);

    NotificationManager.$inject = [];

    /* @ngInject */
    function NotificationManager() {
        var notif = [];
        var service = {
            get: getNotif,
            set: setNotif
        };

        return service;

        function getNotif() {
            return notif;
        }

        function setNotif(data) {
            notif = data;
        }
    }
})();

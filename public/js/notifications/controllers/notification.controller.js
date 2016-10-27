(function() {
    'use strict';

    angular
        .module('notification')
        .controller('NotificationController', NotificationController);

    NotificationController.$inject = ['Notification', 'NotificationManager'];

    /* @ngInject */
    function NotificationController(Notification, NotificationManager) {
        var vm = this;
        vm.notifications = [];

        activate();
        function activate() {
            getNotif();
        }

        function getNotif() {
            Notification.query().$promise.then(function(result) {
                NotificationManager.set(result);
                vm.notifications = NotificationManager.get();
            });
        }
    }
})();

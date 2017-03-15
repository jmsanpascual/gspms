(function() {
    'use strict';

    angular
        .module('notification')
        .controller('NotificationController', NotificationController)
        .controller('NotificationListController', NotificationListController);

    NotificationController.$inject = [
        'Notification',
        'NotificationManager',
        'ProgramRestApi',
        'ProjectStatusRestApi',
        'UserRestApi',
        'ResourcePerson',
        '$scope',
        'defaultModal',
        '$http'
    ];

    /* @ngInject */
    function NotificationController(Notification, NotificationManager, ProgramRestApi,
        ProjectStatusRestApi, UserRestApi, ResourcePerson, $scope, defaultModal, $http) {
        var vm = this;
        vm.notifications = [];

        vm.count = 0;
        // vm.showNotif = showNotif;
        vm.read = read;

        activate();
        function activate() {
            getNotif();


        }

        function getNotif() {
            Notification.query().$promise.then(function(result) {
                vm.count = result.count;
                NotificationManager.set(result.notif);
                vm.notifications = NotificationManager.get();
            });
        }

        function read(editProjCallback, notif, index) {
            editProjCallback.then(function(){
                $http.get('../readNotif/'+notif.userNotifId).then(function(result){
                    result = result.data;
                    if(!result.status) return alert(result.msg);

                    vm.notifications.splice(index,1);
                    --vm.count;
                });
            });
        }

    }

    NotificationListController.$inject = [
        'Notification',
        'NotificationManager',
        'ProgramRestApi',
        'ProjectStatusRestApi',
        'UserRestApi',
        'ResourcePerson',
        '$scope',
        'defaultModal',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        '$http'
    ];

    /* @ngInject */
    function NotificationListController(Notification, NotificationManager, ProgramRestApi,
        ProjectStatusRestApi, UserRestApi, ResourcePerson, $scope, defaultModal,
        DTOptionsBuilder, DTColumnDefBuilder, $http) {
        var vm = this;
        vm.notifications = [];
        vm.getNotif = getNotif;
        vm.read = read;

        activate();
        function activate() {
            getNotif();
        }

        function getNotif() {
            Notification.getAllNotif().$promise.then(function(result) {
                NotificationManager.set(result);
                vm.notifications = NotificationManager.get();
            });
        }


        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3),
            DTColumnDefBuilder.newColumnDef(5).notSortable()
        ];

        function read(editProjCallback, notif, index) {
            editProjCallback.then(function(){
                $http.get('../readNotif/'+notif.userNotifId).then(function(result){
                    result = result.data;
                    if(!result.status) return alert(result.msg);

                    notif.read_flag = 1;
                });
            });
        }
    }

})();

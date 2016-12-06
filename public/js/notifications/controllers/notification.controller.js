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
    ];

    /* @ngInject */
    function NotificationController(Notification, NotificationManager, ProgramRestApi,
        ProjectStatusRestApi, UserRestApi, ResourcePerson, $scope, defaultModal) {
        var vm = this;
        vm.notifications = [];

        vm.count = 0;
        vm.showNotif = showNotif;

        activate();
        function activate() {
            getNotif();

            ResourcePerson.getResourcePersons().then(function (resourcePersons) {
                console.log('Resource Persons:', resourcePersons);
                $scope.resourcePersons = resourcePersons;
                $scope.resourcePersons.unshift({id:'NA', name: 'No Resource Person'});

            });

            // instantiate program
            ProgramRestApi.query().$promise.then(function (programs) {
               var result = programs[0];
               console.log('Programs:', result);

               if (result.status) {
                   $scope.program = result.program;
               } else {
                   console.log(result.msg);
               }
            });

            // instantiate project status
            ProjectStatusRestApi.query().$promise.then(function (projectStatus) {
                var result = projectStatus[0];
                console.log('Project Status:', result);

                if (result.status) {
                    $scope.status = result.projectStatus;
                } else {
                    console.log(result.msg);
                }
            });

            UserRestApi.getChampion().$promise.then(function (result) {
                if (result.status) {
                    $scope.champions = result.champions;
                } else {
                    console.log(result.msg);
                }
            });
        }

        function getNotif() {
            Notification.query().$promise.then(function(result) {
                vm.count = result.count;
                NotificationManager.set(result.notif);
                vm.notifications = NotificationManager.get();
            });
        }

        function showNotif(notif, index) {
            var attr = {
                size: 'lg',
                templateUrl : '../notifications/projects/'+notif.project_id+'/'+notif.userNotifId,
                saveUrl: '../projects/update',
                action: 'Edit',
                // keepOpen : true, // keep open even after save
                programs : $scope.program,
                // program: {id: proj.program_id},
                status : $scope.status,
                champions : $scope.champions,
                // champion: {id: proj.champion_id},
                resource_person : $scope.resourcePersons,
                // resource: {id: proj.resource_person_id},
                // proj : angular.copy(proj)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                vm.notifications.splice(index,1);
                vm.count -= 1;
            }, function(){
                vm.notifications.splice(index,1);
                vm.count -= 1;
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
        'DTColumnDefBuilder'
    ];

    /* @ngInject */
    function NotificationListController(Notification, NotificationManager, ProgramRestApi,
        ProjectStatusRestApi, UserRestApi, ResourcePerson, $scope, defaultModal, DTOptionsBuilder, DTColumnDefBuilder) {
        var vm = this;
        vm.notifications = [];
        vm.showNotif = showNotif;
        vm.getNotif = getNotif;
        activate();
        function activate() {
            getNotif();

            ResourcePerson.getResourcePersons().then(function (resourcePersons) {
                console.log('Resource Persons:', resourcePersons);
                $scope.resourcePersons = resourcePersons;
                $scope.resourcePersons.unshift({id:'NA', name: 'No Resource Person'});
            });

            // instantiate program
            ProgramRestApi.query().$promise.then(function (programs) {
               var result = programs[0];
               console.log('Programs:', result);

               if (result.status) {
                   $scope.program = result.program;
               } else {
                   console.log(result.msg);
               }
            });

            // instantiate project status
            ProjectStatusRestApi.query().$promise.then(function (projectStatus) {
                var result = projectStatus[0];
                console.log('Project Status:', result);

                if (result.status) {
                    $scope.status = result.projectStatus;
                } else {
                    console.log(result.msg);
                }
            });

            UserRestApi.getChampion().$promise.then(function (result) {
                if (result.status) {
                    $scope.champions = result.champions;
                } else {
                    console.log(result.msg);
                }
            });
        }

        function getNotif() {
            Notification.getAllNotif().$promise.then(function(result) {
                NotificationManager.set(result);
                vm.notifications = NotificationManager.get();
            });
        }

        function showNotif(notif) {
            var attr = {
                size: 'lg',
                templateUrl : '../notifications/projects/'+notif.project_id+'/'+ notif.userNotifId,
                saveUrl: '../projects/update',
                action: 'Edit',
                // keepOpen : true, // keep open even after save
                programs : $scope.program,
                // program: {id: proj.program_id},
                status : $scope.status,
                champions : $scope.champions,
                // champion: {id: proj.champion_id},
                resource_person : $scope.resourcePersons,
                // resource: {id: proj.resource_person_id},
                // proj : angular.copy(proj)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                notif.read_flag = 1;
            }, function(){
                notif.read_flag = 1;
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
    }

})();

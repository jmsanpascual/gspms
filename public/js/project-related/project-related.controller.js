(function() {
    'use strict';

    angular
        .module('project-related')
        .controller('ProjectRelatedController', ProjectRelatedController);

    ProjectRelatedController.$inject = [
        '$scope',
        'defaultModal',
        'ProjRestApi',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'UserRestApi',
        'ResourcePerson',
        'ProgramRestApi',
        'ProjectStatusRestApi'
    ];

    /* @ngInject */
    function ProjectRelatedController($scope, defaultModal, ProjRestApi, DTOptionsBuilder, DTColumnDefBuilder
      , UserRestApi, ResourcePerson, ProgramRestApi, ProjectStatusRestApi) {
        var vm = this;
        vm.related = [];
        vm.refresh = refresh;
        vm.message = '';
        vm.edit = edit;
        vm.dtInstance = {};
        vm.attachments = [];
        vm.ave_budget = 0;
        vm.min_budget = 0;
        vm.max_budget = 0;

        function refresh() {
            ProjRestApi.related({proj_id : vm.proj_id}).$promise.then(function(result){
                if (result.status) {
                    vm.related = result.related;
                    //compute avg
                    var total_budget = 0;
                    for(var key in result.related) {
                        total_budget = result.related[key].total_budget;
                        vm.ave_budget += total_budget;
                        // if total budget is lower than the current min budget or no value yet
                        vm.min_budget = (!vm.min_budget || vm.min_budget > total_budget) ? total_budget : vm.min_budget;
                        vm.max_budget = (!vm.max_budget || vm.max_budget < total_budget) ? total_budget : vm.max_budget;
                    }
                    // console.log(result.related);
                    // console.log(vm.ave_budget);
                    // console.log(result.related.length);
                    vm.ave_budget = vm.ave_budget/ result.related.length;
                } else {
                    alert('Unable to load datatable');
                }
            });
        }

        ResourcePerson.getResourcePersons().then(function (resourcePersons) {
            console.log('Resource Persons:', resourcePersons);
            $scope.resourcePersons = resourcePersons;
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

        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3).notSortable()
        ];


        function edit(index, proj) {
            var attr = {
                size: 'lg',
                templateUrl : 'projects',
                saveUrl: '../projects/update',
                action: 'Edit',
                // keepOpen : true, // keep open even after save
                programs : $scope.program,
                program: {id: proj.program_id},
                status : $scope.status,
                champions : $scope.champions,
                champion: {id: proj.champion_id},
                resource_person : $scope.resourcePersons,
                resource: {id: proj.resource_person_id},
                proj : angular.copy(proj)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                vm.projects.splice(index, 1, angular.copy(data.proj));
            });
        }
    }
})();

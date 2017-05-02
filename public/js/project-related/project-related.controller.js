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
        vm.min_duration = 0;
        vm.max_duration = 0;
        vm.ave_duration = 0;
        vm.orig_proj = {};

        function refresh() {
            ProjRestApi.related({proj_id : vm.orig_proj.id}).$promise.then(function(result){
                if (result.status) {
                    console.log(result);
                    vm.related = result.related;
                    vm.ave_duration = result.others.ave_duration;
                    vm.min_duration = result.others.min_duration;
                    vm.max_duration = result.others.max_duration;
                    //compute avg
                    var total_budget = 0;
                    // var total_duration = 0;
                    for(var key in result.related) {
                        var budget = parseInt(result.related[key].total_budget),
                        duration = parseInt(result.related[key].duration);
                        total_budget += budget;
                        // total_duration += duration;
                        // vm.ave_budget += total_budget;
                        // if total budget is lower than the current min budget or no value yet
                        vm.min_budget = (!vm.min_budget || vm.min_budget > budget) ? budget : vm.min_budget;
                        vm.max_budget = (!vm.max_budget || vm.max_budget < budget) ? budget : vm.max_budget;
                        // duration
                        // vm.min_duration = parseInt(vm.min_duration);
                        // vm.max_duration = parseInt(vm.max_duration);

                        // vm.min_duration = ((!vm.min_duration || vm.min_duration > duration) ? duration : vm.min_duration) + ' year(s)';
                        // vm.max_duration = ((!vm.max_duration || vm.max_duration < duration) ? duration : vm.max_duration) + ' year(s)';
                    }
                    // console.log(total_budget);
                    // console.log(total_duration);
                    // console.log(result.related.length);
                    vm.ave_budget = (result.related.length) ? (total_budget/ result.related.length).toFixed(2) : 0;
                    // vm.ave_duration = ((result.related.length) ? total_duration/ result.related.length : 0).toFixed(2) + ' year(s)';
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
                size: 'eighty',
                templateUrl : '../projects/compare',
                action: 'Compare',
                // keepOpen : true, // keep open even after save
                programs : $scope.program,
                program: {id: proj.program_id},
                status : $scope.status,
                champions : $scope.champions,
                champion: {id: proj.champion_id},
                resource_person : $scope.resourcePersons,
                resource: {id: proj.resource_person_id},
                proj : angular.copy(proj),
                old_proj: angular.copy(vm.orig_proj)
            };
            console.log(proj);
            console.log(vm.orig_proj);
            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                vm.projects.splice(index, 1, angular.copy(data.proj));
            });
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('activityDependencies')
        .controller('MilestoneController', MilestoneController);

    MilestoneController.$inject = ['Milestone', 'defaultModal'];

    /* @ngInject */
    function MilestoneController(Milestone, defaultModal) {
        var vm = this;

        vm.milestone = {};
        vm.milestoneDates = {};
        vm.activitiesCtrl = {};

        vm.activate = activate;
        vm.add = add;
        vm.view = view;

        function activate(project, activitiesCtrl) {
            console.log('Project: ', project);
            console.log('Activities Ctrl: ', activitiesCtrl);
            vm.milestone.project_id = project.id;
            vm.milestone.phase_3 = project.end_date;
            vm.activitiesCtrl = activitiesCtrl;

            Milestone.getMilestone({ id: project.id }).then(function (milestone) {
                console.log('Milestone: ', milestone);
                vm.milestoneDates = milestone;
                vm.milestone.id = milestone.id;
                vm.milestone.phase_1 = milestone.phase_1;
                vm.milestone.phase_2 = milestone.phase_2;
            });
        }

        function add() {
            // Inform the the milestone will save using Angular Resource
            vm.milestone.resource = true;

            var attr = {
                size: 'md',
                templateUrl : '../milestone/create',
                resource: true,
                action: 'Add',
                milestone: angular.copy(vm.milestone)
            };

            var modal = defaultModal.showModal(attr);

            modal.result.then(function (data) {
                delete data.resource;

                var request = {
                    milestone: data
                };

                Milestone.addMilestone(request).then(function (response) {
                    console.log('Result', response);
                    data.id = response.id;

                    var milestone = Milestone.getInstance(data);
                    vm.milestone = milestone;
                });
            });
        }

        function view() {
            var attr = {
                size: 'md',
                templateUrl : '../milestone-graph',
                milestone: angular.copy(vm.milestone),
                milestoneDates: vm.milestoneDates,
                phase1: vm.activitiesCtrl.phasesPercentages[0],
                phase2: vm.activitiesCtrl.phasesPercentages[1],
                phase3: vm.activitiesCtrl.phasesPercentages[2]
            };

            var modal = defaultModal.showModal(attr);
        }
    }
})();

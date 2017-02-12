(function() {
    'use strict';

    angular
        .module('volunteer')
        .controller('ExpertiseController', ExpertiseController);

    ExpertiseController.$inject = [
        'Expertise',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal'
    ];

    /* @ngInject */
    function ExpertiseController(Expertise, DTOptionsBuilder,
        DTColumnDefBuilder, defaultModal) {

        var vm = this;

        vm.message = '';
        vm.dtInstance = {};
        vm.tasks = [];

        vm.add = add;
        vm.edit = edit;
        vm.remove = remove;

        activate();

        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2).notSortable()
        ];

        function activate() {
            getAllExpertise();
        }

        function getAllExpertise() {
            Expertise.getAll().then(function (expertises) {
                console.log('Expertises:', expertises);
                vm.expertises = expertises;
            }, function(error) {
                // toast.error('Unable to load tasks')
                alert('Unable to load expertise at the moment.');
                console.log('Error:', error);
            });
        }

        function add() {
            var attr = {
                size: 'md',
                templateUrl : '../expertise/create',
                resource: true,
                action: 'Add'
            };

            var modal = defaultModal.showModal(attr);

            modal.result.then(function (data) {
                console.log('Expertise:', data);
                var request = {
                    expertise: data.expertise
                };

                Expertise.addExpertise(request).then(function (response) {
                    console.log('Result', response);
                    data.expertise.id = response.id;

                    var expertise = Expertise.getInstance(data.expertise);
                    vm.expertises.push(expertise);
                });
            });
        }

        function edit(index, expertise) {
            var attr = {
                size: 'md',
                templateUrl : '../expertise/create',
                action: 'View',
                resource: true,
                expertise: angular.copy(expertise)
            };

            var modal = defaultModal.showModal(attr);

            modal.result.then(function (data) {
                console.log('Expertise:', data);
                var request = {
                    expertise: data.expertise
                };

                Expertise.update(request).then(function (result) {
                    expertise.name = result.expertise.name;
                    console.log('Update successful:', result);
                });
            });
        }

        function remove(index, expertise) {
            var attr = {
                deleteName : 'The ' + expertise.name + ' Expertise'
            };
            var modal = defaultModal.delConfirm(attr);

            modal.result.then(function () {
                expertise.$delete(function () {
                    vm.expertises.splice(index, 1);
                });
            });
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('volunteer')
        .controller('VolunteerController', VolunteerController);

    VolunteerController.$inject = [
        'Volunteer',
        'Expertise',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal'
    ];

    /* @ngInject */
    function VolunteerController(Volunteer, Expertise, DTOptionsBuilder,
        DTColumnDefBuilder, defaultModal) {

        var vm = this;

        vm.message = '';
        vm.dtInstance = {};
        vm.volunteers = [];
        vm.expertises = [];

        vm.add = add;
        vm.edit = edit;
        // vm.remove = remove;

        activate();

        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3),
            DTColumnDefBuilder.newColumnDef(4).notSortable()
        ];

        function activate() {
            getVolunteers();
            getAllExpertise();
        }

        function getVolunteers() {
            Volunteer.getVolunteers().then(function (volunteers) {
                console.log('Volunteers:', volunteers);
                vm.volunteers = volunteers;
            }, function(error) {
                // toast.error('Unable to load volunteers')
                alert('Unable to load volunteers at the moment.');
                console.log('Error:', error);
            });
        }

        function getAllExpertise() {
            Expertise.getAll().then(function (expertise) {
                console.log('Expertise:', expertise);
                vm.expertises = expertise;
            }, function(error) {
                // toast.error('Unable to load volunteers')
                alert('Unable to load expertise at the moment.');
                console.log('Error:', error);
            });
        }

        function add() {
            var attr = {
                size: 'md',
                templateUrl : 'create',
                resource: true,
                action: 'Add',
                expertises: vm.expertises,
                volunteer: {
                    expertise: {
                        id: (vm.expertises.length) ? vm.expertises[0].id : ''
                    }
                }
            };

            var modal = defaultModal.showModal(attr);

            modal.result.then(function (data) {
                console.log('Volunteer:', data);
                var request = {
                    volunteer: data.volunteer
                };

                Volunteer.addVolunteer(request).then(function (response) {
                    console.log('Result', response);
                    data.volunteer.id = response.volunteerId;
                    data.volunteer.info.id = response.personalInfoId;

                    for (var index in vm.expertises) {
                        if (data.volunteer.expertise.id == vm.expertises[index].id) {
                            data.volunteer.expertise.name = vm.expertises[index].name;
                        }
                    }

                    var volunteer = Volunteer.getInstance(data.volunteer);
                    vm.volunteers.push(volunteer);
                });
            });
        }

        function edit(index, volunteer) {
            var attr = {
                size: 'md',
                templateUrl : 'create',
                action: 'Edit',
                resource: true,
                volunteer: volunteer,
                expertises: vm.expertises
            };

            var modal = defaultModal.showModal(attr);

            // when the modal opens
            modal.result.then(function (data) {
                console.log('Volunteer:', data);
                var request = {
                    volunteer: data.volunteer
                };

                Volunteer.update(request).then(function (result) {
                    console.log('Update successful:', result);
                });
            });

        }

        // function remove(index, volunteer) {
        //     var attr = {
        //         deleteName : volunteer.name
        //     };
        //     var modal = defaultModal.delConfirm(attr);
        //
        //     modal.result.then(function () {
        //         volunteer.$delete(function () {
        //             vm.volunteers.splice(index, 1);
        //         });
        //     });
        // }
    }
})();

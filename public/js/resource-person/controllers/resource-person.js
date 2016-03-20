'use strict'

angular.module('resourcePersons', [
    'datatables',
    'common.service',
    'ui.bootstrap',
    'resourcePersonService',
    'schoolService'
])

.controller('resourcePersonDTCtrl', function($scope, $compile, ResourcePerson, SchoolRestApi,
    DTOptionsBuilder, DTColumnDefBuilder, defaultModal) {

    var rp = this;
    rp.message = '';
    rp.dtInstance = {};
    rp.persons = [];

    rp.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

    rp.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4),
        DTColumnDefBuilder.newColumnDef(5).notSortable()
    ];

    ResourcePerson.getResourcePersons().then(function (resourcePersons) {
        console.log('Resource Persons:', resourcePersons);
        rp.persons = resourcePersons;
    }, function(error){
        alert('Unable to load resource persons');
        console.log('Error:', err);
    });

    SchoolRestApi.query().$promise.then(function (schools) {
        console.log('Schools:', schools);
        rp.schools = schools;
        rp.school = rp.schools[0];
    }, function (error) {
        alert('Unable to load schools');
        console.log('Error:', err);
    });

    rp.add = function () {
        var attr = {
            size: 'md',
            templateUrl : 'create',
            resource: true,
            action: 'Add',
            school: rp.schools[0],
            schools : rp.schools
        };
        var modal = defaultModal.showModal(attr);

        modal.result.then(function (data) {
            console.log("Resource person:", data);
            var request = {
                personalInfo: data.person,
                resourcePerson: {
                    'school_id': data.resourcePerson.school.id,
                    'profession': data.resourcePerson.profession
                }
            };

            ResourcePerson.addResourcePerson(request).then(function (response) {
                console.log('Add:', response);
                var person = data.person;
                person.profession = data.resourcePerson.profession;
                person.name = person.first_name + " " + person.last_name;
                person.school = data.resourcePerson.school.name;
                person.id = response.id;
                person.personal_info_id = response.personal_info_id;
                rp.persons.push(person);
                //  alert(resourcePerson.first_name + ' was succesfully added');
            });
        });
    };

    rp.edit = function (index, resourcePerson) {
        var attr = {
            size: 'md',
            templateUrl : 'create',
            action: 'Edit',
            resource: true,
            person: resourcePerson,
            schools : rp.schools,
            school: getSchool(),
            // school: {
            //     id: resourcePerson.school_id,
            //     name: resourcePerson.school
            // },
            resourcePerson: {
                profession: resourcePerson.profession
            }
        };


            console.log(attr.school);

        function getSchool() {
            var len = rp.schools.length;
            var school;

            for (var i = 0; i < len; i++) {
                if (rp.schools[i].name == resourcePerson.school)
                    return rp.schools[i];
            }
        }

        console.log('Resource Person:', resourcePerson);

        var userModal = defaultModal.showModal(attr);

        // when the modal opens
        userModal.result.then(function (data) {
            var request = {
                personalInfo: data.person,
                resourcePerson: {
                    'school_id': data.resourcePerson.school.id,
                    'profession': data.resourcePerson.profession
                }
            };

            ResourcePerson.update(request).then(function (result) {
                console.log('Update yeah!', result);
                var person = data.person;
                person.profession = data.resourcePerson.profession;
                person.name = person.first_name + " " + person.last_name;
                person.school = data.resourcePerson.school.name;
            });
        });
    }

    rp.delete = function (index, resourcePerson) {
        var attr = {
            deleteName : resourcePerson.name
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function () {
            if (!resourcePerson.$delete) {
                ResourcePerson.getResourcePerson({id: resourcePerson.id})
                    .then(function (resource) {
                        resource.$delete(function () {
                            rp.persons.splice(index, 1);
                        });
                }, function (err) {
                    console.log(err);
                });
            } else {
                resourcePerson.$delete(function () {
                    rp.persons.splice(index, 1);
                });
            }
        });
    }
});

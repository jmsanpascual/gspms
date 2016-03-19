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
            size: 'lg',
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
                //  alert(resourcePerson.first_name + ' was succesfully added');
                var person = data.person;
                person.profession = data.resourcePerson.profession;
                person.name = person.first_name + " " + person.last_name;
                person.school = data.resourcePerson.school.name;
                person.id = response.id;
                rp.persons.push(person);
            });
        });
    };

    rp.edit = function (resourcePerson) {
        var attr = {
            size: 'md',
            templateUrl : 'addUser',
            saveUrl: 'editUser'
        };

        console.log('Resource Person:', resourcePerson);

        var openModal = function (attr) {
            var userModal = defaultModal.showModal(attr);

            // when the modal opens
            userModal.result.then(function (data) {
                console.log(data);
                console.log('updating');
                rp.dtInstance.reloadData();
            });
        }

        // call open modal
        // showUserDetails
        reqDef.get('showUserDetails/' + person.id).then(function(result){
            console.log(result);
            console.log('show user details');
            if(result.roles != undefined)
                attr.roles = result.roles;

            if(result.users != undefined)
                attr.users = result.users;

            openModal(attr);
        }, function(err){
            openModal(attr);
        });

        // Edit some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
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

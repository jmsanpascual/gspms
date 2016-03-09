'use strict'

angular.module('resourcePerson', ['resourcePersonService', 'schoolService'])

.controller('CreateResourcePersonCtrl', function (ResourcePerson, SchoolRestApi) {
    var crp = this;
    crp.person = {};

    ResourcePerson.getResourcePersons().then(function (resourcePerson) {
        console.log(resourcePerson);
    });

    SchoolRestApi.query().$promise.then(function (schools) {
        console.log('Schools:', schools);
        crp.schools = schools;
        crp.school = crp.schools[0];
    });

    crp.saveResourcePerson = function () {
        var request = {
            personalInfo: crp.person,
            resourcePerson: {
                'school_id': crp.school.id,
                'profession': crp.profession
            }
        };

        ResourcePerson.addResourcePerson(request).then(function (response) {
            alert(crp.person.first_name + ' was succesfully added');
        });
    };
});

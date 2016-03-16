'use strict'

angular.module('resourcePersonService', ['ngResource'])

.factory('ResourcePerson', function (ResourcePersonApi) {
    var _self = this;

    var getResourcePerson = function (params) {
        return ResourcePersonApi.get(params).$promise.then(function (persons) {
            return persons;
        });
    };

    var getResourcePersons = function () {
        return ResourcePersonApi.query().$promise.then(function (persons) {
            return persons;
        });
    };

    var addResourcePerson = function (params) {
        var person = new ResourcePersonApi(params);

        return ResourcePersonApi.save(person).$promise.then(function (id) {
            return id;
        });
    };

    return {
        getResourcePerson: getResourcePerson,
        getResourcePersons: getResourcePersons,
        addResourcePerson: addResourcePerson
    };
})

.factory('ResourcePersonApi', function ($resource) {
    var restApi = $resource('../resource-persons/:id', {id: '@id'});

    return restApi;
});

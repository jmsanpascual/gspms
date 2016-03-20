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

        return ResourcePersonApi.save(person).$promise.then(function (response) {
            return response;
        });
    };

    var update = function (params) {
        return ResourcePersonApi.update(params).$promise.then(function (response) {
            return response;
        });
    }

    return {
        getResourcePerson: getResourcePerson,
        getResourcePersons: getResourcePersons,
        addResourcePerson: addResourcePerson,
        update: update
    };
})

.factory('ResourcePersonApi', function ($resource) {
    var restApi = $resource('../resource-persons/:id', {id: '@id'}, {
        update : {
            url: '../resource-persons/update',
            method: 'POST'
        }
    });

    return restApi;
});

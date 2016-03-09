'use strict'

angular.module('resourcePersonService', ['ngResource'])

.factory('ResourcePerson', function (ResourcePersonApi) {
    var _self = this;
    var projects = null;

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

    return {
        getResourcePersons: getResourcePersons,
        addResourcePerson: addResourcePerson
    };
})

.factory('ResourcePersonApi', function ($resource) {
    var restApi = $resource('../resource-persons');

    return restApi;
});

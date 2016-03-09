'use strict'
angular.module('roles.service', ['ngResource'])

.factory('rolesRestApi', function ($resource) {
    return $resource('roles');
});

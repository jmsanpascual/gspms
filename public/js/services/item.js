'use strict'
angular.module('items.service', ['ngResource'])

.factory('ItemsRestApi', function ($resource) {
    return $resource('../items/:id', {id : '@id'});
});

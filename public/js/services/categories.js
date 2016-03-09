'use strict'
angular.module('categories.service', ['ngResource'])

.factory('CategoriesRestApi', function ($resource) {
    return $resource('../categories/:id', {id : '@id'});
});

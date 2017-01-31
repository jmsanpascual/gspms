(function() {
    'use strict';

    angular
        .module('items.controller')
        .factory('ItemManager', ItemManager);

    ItemManager.$inject = [];

    /* @ngInject */
    function ItemManager() {
        var items = [];
        var service = {
            get: getItems,
            set: setItems
        };

        return service;

        function getItems() {
            return items;
        }

        function setItems(data) {
            items = data;
        }
    }
})();

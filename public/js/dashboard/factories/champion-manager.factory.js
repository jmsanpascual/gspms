(function() {
    'use strict';

    angular
        .module('dashboard')
        .factory('ChampionManager', ChampionManager);

    ChampionManager.$inject = [];

    /* @ngInject */
    function ChampionManager() {
        var champions = [];
        var service = {
            get: getChampion,
            set: setChampion,
        };

        return service;

        function getChampion() {
            return champions;
        }

        function setChampion(data) {
            champions = data;
        }
    }
})();

(function() {
    'use strict';

    angular
        .module('dashboard')
        .run(dashboardRun);

    dashboardRun.$inject = [
        'ProgramManager',
        'StatusManager',
        'ChampionManager',
        'ResourcePersonManager',
        '$http'
    ];

    function dashboardRun(ProgramManager, StatusManager, ChampionManager
        , ResourcePersonManager, $http) {

        activate();

        function activate() {
            getPrograms();
            getResourcePerson();
            getChampion();
        }

        function getPrograms() {
            $http.get('programs').then(function(result) {
                var programs = result[0];
                ProgramManager.set(programs);
            });
        }

        function getStatus() {
            $http.get('project-status').then(function(result) {
                var status = result[0];
                StatusManager.set(status);
            });
        }

        function getChampion() {
            $http.get('user/getChampion').then(function(result) {
                ChampionManager.set(result.champions);
            });
        }

        function getResourcePerson() {
            $http.get('resource-persons').then(function(result){
                ResourcePersonManager.set(result);
            });
        }
    }
})();

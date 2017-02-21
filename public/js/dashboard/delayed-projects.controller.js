
(function() {
	angular.module('dashboard')
		.controller('DelayedProjectController', DelayedProjectController);

	DelayedProjectController.$inject = [
		'ProgramManager',
		'StatusManager',
		'ChampionManager',
		'ResourcePersonManager',
		'$http'
	];

	function DelayedProjectController(ProgramManager, StatusManager, ChampionManager
		, ResourcePersonManager, $http) {

		var vm = this;

		vm.projects = [];
		vm.programs = [];
		vm.status = [];
		vm.champions = [];
		vm.resourcePersons =[];

		vm.get = getProjects;
		vm.show = showProjects;

		activate();

		function activate() {
			getProjects();
			vm.programs = ProgramManager.get();
			vm.status = StatusManager.get();
			vm.champions = ChampionManager.get();
			vm.resourcePersons = ResourcePersonManager.get();
		}

		function getProjects() {
			$http.get('delayed?delayed=true').then(function(result){
				var result = result.data;
				vm.projects = result;
			});
		}

		function showProjects (project) {
			var attr = {
                size: 'lg',
                templateUrl : '../notifications/projects/'+notif.project_id+'/'+notif.userNotifId,
                saveUrl: '../projects/update',
                action: 'Edit',
                keepOpen : true, // keep open even after save
                programs : vm.programs,
                // program: {id: proj.program_id},
                status : vm.status,
                champions : vm.champions,
                // champion: {id: proj.champion_id},
                resource_person : vm.resourcePersons,
                // resource: {id: proj.resource_person_id},
                // proj : angular.copy(proj)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                getProjects();
            }, function(){
				getProjects();
            });
		}
	}
})();

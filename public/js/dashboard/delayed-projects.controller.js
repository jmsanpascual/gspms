
(function() {
	angular.module('dashboard')
		.controller('DelayedProjectController', DelayedProjectController);

	DelayedProjectController.$inject = [
		'$http'
	];

	function DelayedProjectController($http) {

		var vm = this;

		vm.projects = [];

		vm.get = getProjects;

		activate();

		function activate() {
			getProjects();
			// vm.resourcePersons = ResourcePersonManager.get();
		}

		function getProjects() {
			$http.get('../delayed').then(function(result){
				var result = result.data;
				vm.projects = result.proj;
			});
		}
	}
})();

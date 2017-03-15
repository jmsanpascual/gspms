
(function() {
	angular.module('dashboard')
		.controller('UpcomingController', UpcomingController);

	UpcomingController.$inject = ['$http'];

	function UpcomingController($http) {
		var vm = this;

		vm.upcomings = [];

		vm.get = getProjects;

		activate();

		function activate() {
			getProjects();
		}

		function getProjects() {
			console.log('upcoming - - - ');
			$http.get('../upcoming').then(function(result){
				var result = result.data;
				vm.upcomings = result.proj;
			});
		}

	}
})();

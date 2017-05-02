
(function() {
	angular.module('dashboard')
		.controller('DelayedProjectController', DelayedProjectController);

	DelayedProjectController.$inject = [
		'$http',
		'DTOptionsBuilder',
		'DTColumnDefBuilder'
	];

	function DelayedProjectController($http, DTOptionsBuilder, DTColumnDefBuilder) {

		var vm = this;

		vm.projects = [];

		vm.get = getProjects;
		vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('aaSorting', [1, 'desc'])
            .withPaginationType('full_numbers');

		vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3),
            DTColumnDefBuilder.newColumnDef(4),
            DTColumnDefBuilder.newColumnDef(5).notSortable()
        ];

		activate();

		function activate() {
			getProjects();
			// vm.resourcePersons = ResourcePersonManager.get();
		}

		function getProjects() {
			$http.get('../delayed').then(function(result){
				var result = result.data;
				vm.projects = result;
				console.log('delayed', vm.projects);
			});
		}
	}
})();

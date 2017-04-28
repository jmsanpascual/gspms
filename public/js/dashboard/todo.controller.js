
(function() {
	angular.module('dashboard')
		.controller('TodoController', TodoController);

	TodoController.$inject = [
		'$http',
		'DTOptionsBuilder',
		'DTColumnDefBuilder'
	];

	function TodoController($http, DTOptionsBuilder, DTColumnDefBuilder) {
		var vm = this;

		vm.todos = [];

		vm.get = getTodos;
		vm.show = showTodos;
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
			getTodos();
		}

		function getTodos() {
			$http.get('../todo').then(function(result) {
				var result = result.data;
				if(!result.status) return alert(result.msg);

				vm.todos = result.todo;
			});
		}

		function showTodos() {

		}
	}
})();

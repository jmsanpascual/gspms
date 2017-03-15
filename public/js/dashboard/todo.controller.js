
(function() {
	angular.module('dashboard')
		.controller('TodoController', TodoController);

	TodoController.$inject = ['$http'];

	function TodoController($http) {
		var vm = this;

		vm.todos = [];

		vm.get = getTodos;
		vm.show = showTodos;

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


(function() {
	angular.module('dashboard')
		.controller('UpcomingController', UpcomingController);

	UpcomingController.$inject = [];

	function UpcomingController() {
		var vm = this;

		vm.upcomings = [];

		activate();

		function activate() {

		}
	}
})();

(function() {
    'use strict';

    angular
        .module('task')
        .controller('TaskController', TaskController);

    TaskController.$inject = [
        'Task',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal'
    ];

    /* @ngInject */
    function TaskController(Task, DTOptionsBuilder,
        DTColumnDefBuilder, defaultModal) {

        var vm = this;

        vm.message = '';
        vm.dtInstance = {};
        vm.tasks = [];

        // vm.add = add;
        vm.edit = edit;
        // vm.update = update;

        activate();

        vm.dtOptions = DTOptionsBuilder.newOptions()
            .withOption('aaSorting', [2, 'desc'])
            .withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(2),
            DTColumnDefBuilder.newColumnDef(3),
            DTColumnDefBuilder.newColumnDef(4).notSortable()
        ];

        function activate() {
            getTasks();
        }

        function getTasks() {
            Task.getTasks().then(function (tasks) {
                console.log('Tasks:', tasks);
                vm.tasks = tasks;
            }, function(error) {
                // toast.error('Unable to load tasks')
                alert('Unable to load tasks at the moment.');
                console.log('Error:', error);
            });
        }

        // function add() {
        //     var attr = {
        //         size: 'md',
        //         templateUrl : 'create',
        //         resource: true,
        //         action: 'Add'
        //     };
        //
        //     var modal = defaultModal.showModal(attr);
        //
        //     modal.result.then(function (data) {
        //         console.log('Task:', data);
        //         var request = {
        //             task: data.task
        //         };
        //
        //         Task.addTask(request).then(function (response) {
        //             console.log('Result', response);
        //             data.task.id = response.taskId;
        //             data.task.info.id = response.personalInfoId;
        //
        //             var task = Task.getInstance(data.task);
        //             vm.tasks.push(task);
        //         });
        //     });
        // }

        function edit(index, task) {
            console.log('Tuawsk:', task);
            var attr = {
                size: 'md',
                templateUrl : 'create',
                action: 'View',
                resource: true,
                task: angular.copy(task)
            };

            var modal = defaultModal.showModal(attr);

            // when the modal opens
            modal.result.then(function (data) {
                console.log('Task:', data);
                task.done = !task.done;

                var request = {
                    task: task
                };

                Task.update(request).then(function (result) {
                    console.log('Update successful:', result);
                });
            });
        }

        // function update(index, task) {
        //     console.log('mike test one two');
        //     var request = {
        //         task: task
        //     };
        //
        //     Task.update(request).then(function (result) {
        //         console.log('Update successful:', result);
        //     });
        // }
    }
})();

(function() {
    'use strict';

    angular
        .module('project.attachment')
        .controller('ProjectAttachmentController', ProjectAttachmentController);

    ProjectAttachmentController.$inject = [
        'ProjectAttachment',
        '$scope',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal',
    ];

    /* @ngInject */
    function ProjectAttachmentController(ProjectAttachment, $scope,
        DTOptionsBuilder, DTColumnDefBuilder, defaultModal) {
        var vm = this;
        vm.message = '';
        vm.edit = edit;
        vm.delete = deleteRow;
        vm.dtInstance = {};
        vm.attachments = [];

        this.refresh = function()
        {
            ProjectAttachment.query({proj_id : vm.proj_id}).$promise.then(function (result) {
                result = result[0];
                if (result.status) {
                    vm.attachments = result.attachment;
                } else {
                    alert('Unable to load datatable');
                }
             });
        }

        vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

        vm.dtColumnDefs = [
            DTColumnDefBuilder.newColumnDef(0),
            DTColumnDefBuilder.newColumnDef(1),
            DTColumnDefBuilder.newColumnDef(5).notSortable()
        ];

        this.add = function () {
            var attr = {
                size: 'lg',
                templateUrl : '../project-attachments/add',
                saveUrl: '../project-attachments',
                action: 'Add',
                keepOpen : true, // keep open even after save
            };
            var modal = defaultModal.showModal(attr);

            // Add to datatable
            modal.result.then(function(data){
                vm.attachments.push(data);
            });
        }

        function edit(index, attachment) {
            console.log(attachment);
            var attr = {
                size: 'lg',
                templateUrl : '../project-attachments/add',
                saveUrl: '../project-attachments/update',
                action: 'Edit',
                // keepOpen : true, // keep open even after save
                proj : angular.copy(attachment)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                vm.attachments.splice(index, 1, angular.copy(data.attachment));
            });
        }

        function deleteRow(index, attachment) {
            // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
            // Delete some data and call server to make changes...
            // Then reload the data so that DT is refreshed
            // vm.dtInstance.reloadData();
            var attr = {
                deleteName : attachment.subject,
                deletedKey : attachment.id
            }
            var del = defaultModal.delConfirm(attr);

            del.result.then(function(id){
                ProjectAttachment.remove({id: id}).then(function(result){
                    if(result.status)
                    {
                        console.log('successfully deleted');
                        vm.attachments.splice(index, 1);
                    }
                    else
                    {
                        console.log('not deleted');
                    }
                });
            });
        }
    }
})();

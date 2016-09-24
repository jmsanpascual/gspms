(function() {
    'use strict';

    angular
        .module('project.attachment')
        .controller('ProjectAttachmentController', ProjectAttachmentController)
        .controller('ProjectAttachmentFormController', ProjectAttachmentFormController);

    ProjectAttachmentController.$inject = [
        'ProjectAttachment',
        '$scope',
        'DTOptionsBuilder',
        'DTColumnDefBuilder',
        'defaultModal',
        'toast'
    ];

    /* @ngInject */
    function ProjectAttachmentController(ProjectAttachment, $scope,
        DTOptionsBuilder, DTColumnDefBuilder, defaultModal, toast) {
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
                // keepOpen : true, // keep open even after save
                attachment : {
                    project_id : vm.proj_id
                }
            };
            var modal = defaultModal.showModal(attr);

            // Add to datatable
            modal.result.then(function(data){
                toast.success(data.msg);
                vm.attachments.push(data.attachment);
            });
        }

        function edit(index, attachment) {
            var attr = {
                size: 'lg',
                templateUrl : '../project-attachments/add',
                saveUrl: '../project-attachments/update',
                action: 'Edit',
                // keepOpen : true, // keep open even after save
                attachment : angular.copy(attachment)
            };

            var modal = defaultModal.showModal(attr);
            modal.result.then(function (data) {
                toast.success(data.msg);
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
                ProjectAttachment.remove({id: id}).$promise.then(function(result){
                    if(result.status)
                    {
                        console.log('successfully deleted');
                        toast.success(result.msg);
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

    ProjectAttachmentFormController.$inject = [
        'toast',
        'ProjectAttachment',
        'defaultModal'
    ];

    function ProjectAttachmentFormController(toast, ProjectAttachment, defaultModal) {
        var vm = this;

        vm.delete = function(files, file, index) {
            var attr = {
                deleteName : file.name,
                deletedKey : file.id
            }
            var del = defaultModal.delConfirm(attr);

            del.result.then(function(id){
                // delete file;
                ProjectAttachment.deleteFile({id : file.id}).$promise.then(function(result){
                    if(!result.status) return;

                    toast.success(result.msg);
                    files.splice(index, 1);
                });
            });
        }
    }
})();

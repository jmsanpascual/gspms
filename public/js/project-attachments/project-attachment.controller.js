(function() {
    'use strict';

    angular
        .module('project.attachment')
        .controller('ProjectAttachmentController', ProjectAttachmentController)
        .controller('ProjectAttachmentFormController', ProjectAttachmentFormController)
        .controller('ProjItemController', ProjItemController);

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
            DTColumnDefBuilder.newColumnDef(2).notSortable()
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
                if(data.action == 'insert')
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
        'defaultModal',
        '$http',
        'ProjectAttachmentManager'
    ];

    function ProjectAttachmentFormController(toast, ProjectAttachment, defaultModal, $http, ProjectAttachmentManager) {
        var vm = this;
        vm.delete = deleteFile;
        vm.showFiles = showFiles;
        vm.files = [];

        function showFiles(proj_attachment_id) {
            $http.get('../project-attachments/showFiles/'+ proj_attachment_id).then(function(result){
                result = result.data;
                ProjectAttachmentManager.set(result.files);
                vm.files = ProjectAttachmentManager.get();
            });
        }

        function deleteFile(files, file, index) {
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

    ProjItemController.$inject = ['$http', 'ProjectAttachmentManager', '$scope'];

    function ProjItemController($http, ProjectAttachmentManager, $scope) {
        var vm = this;
        vm.items = [];
        vm.files = [];
        vm.getItemList = getItemList;
        vm.getAttachment = getAttachment;

        getItemList();

        function getItemList() {
            var proj_id = $scope.submitData.attachment.project_id;
            $http.get('../items/getItemCategoryList/' + proj_id).then(function(result) {
                result = result.data;
                vm.items = result.items
                vm.items.unshift({id:'', item_name:'N/A'});
            });
        }

        // function getItemList(proj_id) {
        //    // vm.project_id = $scope.submitData.attachment.project_id;
        //     $http.get('../items/getItemCategoryList/' + proj_id).then(function(result) {
        //         result = result.data;
        //         console.log(result);
        //         console.log(result.items);
        //         vm.items = result.items
        //         vm.items.unshift({id:'', item_name:'N/A'});
        //     });
        // }

        function getAttachment(submitData) {
            var attachment = submitData.attachment;
            if(!attachment.proj_item_category_id) {
                submitData.saveUrl = '../project-attachments/save';
                submitData.action = 'Add';

                attachment.id = '';
                attachment.subject = '';
                attachment.description = '';
                return;
            }

            $http.get('../project-attachments/find/'+ attachment.proj_item_category_id).then(function(result) {
                result= result.data;

                result = result.attachment || {};
                attachment.id = result.id || '';
                attachment.subject = result.subject || '';
                attachment.description = result.description || '';

                submitData.saveUrl = (attachment.id) ? '../project-attachments/update' : '../project-attachments/save';
                submitData.action = (attachment.id) ? 'Edit' : 'Add';

                // if(!attachment.id) return;
                // //get files
                // $http.get('../project-attachments/showFiles/'+ attachment.id).then(function(result){
                //     result = result.data;// result.files
                //     vm.files = ProjectAttachmentManager.get();
                //     for(var key in result.files) {
                //         vm.files.push(result.files[key]);
                //     }
                // });
            });
        }
    }
})();

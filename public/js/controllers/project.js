'use strict'
angular.module('project.controller', [
    'project.service',
    'program.service',
    'projectStatus.service',
    'dynamicElement',
    'user.service',
    'datatables',
    'common.service',
    'ui.bootstrap',
    'project.activites.controller',
    'budget.request.controller',
    'items.controller'
])

.controller('projDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnDefBuilder,
  reqDef, defaultModal, Project, ProgramRestApi, ProjectStatusRestApi, UserRestApi) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.projects = [];

    Project.getProjects().then(function (result) {
         result = result[0];
        if (result.status) {
          console.log(result.proj);
            vm.projects = result.proj;
        } else {
            alert('Unable to load datatable');
        }

     });

    // instantiate program
    ProgramRestApi.query().$promise.then(function (programs) {
       var result = programs[0];
       console.log('Programs:', result);
       if(result.status)
       {
          $scope.program = result.program;
       }
       else
       {
        console.log(result.msg);
       }
    });

    // instantiate project status
    ProjectStatusRestApi.query().$promise.then(function (projectStatus) {
       var result = projectStatus[0];
       console.log('Project Status:', result);
       if(result.status)
       {
          $scope.status = result.projectStatus;
       }
       else
       {
          console.log(result.msg);
       }
    });

    UserRestApi.getChampion().$promise.then(function(result){
        if(result.status)
        {
          $scope.champions = result.champions;
        }
        else
        {
          console.log(result.msg);
        }
    });

    UserRestApi.getResourcePerson().$promise.then(function(result){
        if(result.status)
        {
          $scope.resource_person = result.resource_persons;
        }
        else
        {
          console.log(result.msg);
        }
    });

    vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

    vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4),
        DTColumnDefBuilder.newColumnDef(5).notSortable()
    ];

    this.add = function()
    {
        var attr = {
            size: 'lg',
            templateUrl : 'projects',
            saveUrl: '../projects',
            action: 'Add',
            keepOpen : true, // keep open even after save
            programs : $scope.program,
            status : $scope.status,
            champions : $scope.champions,
            resource_person : $scope.resource_person
        };
        var modal = defaultModal.showModal(attr);
        // add to datatable
        modal.result.then(function(data){
          vm.projects.push(data);
        });
    }

    function edit(index, proj) {
       var attr = {
            size: 'lg',
            templateUrl : 'projects',
            saveUrl: '../projects/update',
            action: 'Edit',
            // keepOpen : true, // keep open even after save
            programs : $scope.program,
            status : $scope.status,
            champions : $scope.champions,
            resource_person : $scope.resource_person,
            proj : angular.copy(proj)
        };

        var modal = defaultModal.showModal(attr);
        modal.result.then(function(data){
          vm.projects.splice(index, 1, angular.copy(data.proj));
        });
    }


    function deleteRow(index, proj) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : proj.name,
            deletedKey : proj.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id){
            Project.remove({id: id}).then(function(result){
                if(result.status)
                {
                    console.log('successfully deleted');
                    vm.projects.splice(index, 1);
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }

});

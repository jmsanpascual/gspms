'use strict'
var projectCtrl = angular.module('project.controller', [
   'project.service',
   'program.service',
   'projectStatus.service',
   'dynamicElement',
   'user.service',
   'datatables',
   'common.service', 
   'ui.bootstrap',
   'project.activites.controller',
 ]);


projectCtrl.controller('ProjectCtrl', function ($scope, User, Project, ProgramRestApi, ProjectStatusRestApi) {
    $scope.projects = {};

    User.getUsers().then(function (result) {
        console.log('Users:', result.users);
        $scope.users = result.users;
        $scope.champion = $scope.users[0];
    });

    Project.getProjects().then(function (projects) {
        console.log('Projects:', projects);
        $scope.projects = projects;
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
    

  });

  projectCtrl.controller('projDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnBuilder, 
  reqDef, defaultModal, Project, ProgramRestApi, ProjectStatusRestApi, UserRestApi) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.projects = {};


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

    vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
            return Project.getProjects().then(function (result) {
                       result = result[0];
                      if (result.status) {
                          console.log('proj');
                          console.log(result.proj);
                          return result.proj;
                      } else {
                          alert('Unable to load datatable');
                      }

                   });
       }).withPaginationType('full_numbers')
        .withOption('createdRow', createdRow);

    vm.dtColumns = [
        DTColumnBuilder.newColumn('name').withTitle('Project Title'),
        DTColumnBuilder.newColumn('start_date').withTitle('Start Date'),
        DTColumnBuilder.newColumn('end_date').withTitle('End Date'),
        DTColumnBuilder.newColumn('total_budget').withTitle('Total Budget'),
        DTColumnBuilder.newColumn('status').withTitle('Status'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
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
    }

    function edit(proj) {
       var attr = {
            size: 'lg',
            templateUrl : 'projects',
            saveUrl: '../projects/update',
            action: 'Edit',
            // keepOpen : true, // keep open even after save
            programs : $scope.program,
            status : $scope.status,
            champions : $scope.champions,
            resource_person : $scope.resource_person
        };

        var openModal = function(){
          var modal = defaultModal.showModal(attr); 
        }
        //fetch url fix it
        // var data = {id : };
        console.log(proj);
        Project.fetchProject({id : proj.id}).then(function(result){
            if(result.status)
            {
                attr.proj = result.proj;
                openModal();
            }
            else
            {
              console.log(result.msg);
            }
        });
    }
        

    function deleteRow(proj) {
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
            reqDef.delete('projects/'+id).then(function(result){
                if(result.status)
                {
                    console.log('successfully deleted');
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }

    function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }

    function actionsHtml(data, type, full, meta) {
        vm.projects[data.id] = data;
        return '<button class="btn btn-warning" ng-click="proj.edit(proj.projects[' + data.id + '])">' +
            '   <i class="fa fa-edit"></i>' +
            '</button>&nbsp;' +
            '<button class="btn btn-danger" ng-click="proj.delete(proj.projects[' + data.id + '])" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
    }

});

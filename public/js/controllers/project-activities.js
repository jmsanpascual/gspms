'use strict'
angular.module('project.activites.controller', 
    [
    'projectActivities.service', 
    'datatables', 
    'common.service', 
    'ui.bootstrap',
    'activityStatus.service'
    ])
  
.controller('projActDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnDefBuilder, 
    reqDef, defaultModal, ProjectActivitiesRestApi, activityStatusRestApi) {
    // $scope.proj_id = 1; //declared in modals/projects.blade.php
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.project_activities = [];

    $scope.getProjActivities = function(proj_id)
    {
        ProjectActivitiesRestApi.query({proj_id : $scope.proj_id}).$promise.then(function (result) {
           result = result[0];
          if (result.status) {
              console.log('proj');
              console.log(result.proj);
              vm.project_activities =  result.proj_activities;
          } else {
              alert('Unable to load datatable');
          }
       });
    }

    $scope.status = {};

    activityStatusRestApi.query().$promise.then(function(result){
        var result = result[0];
        if(result.status)
        {
            $scope.status = result.activity_status;
        }
        else
        {
            alert(result.status);
        }
    });

    // .fromSource('js/controllers/data.json')
    vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

    vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4).notSortable()
    ];


    this.add = function()
    {
        var attr = {
            size: 'md',
            templateUrl : '../project-activities/project-activities',
            saveUrl: '../project-activities',
            action: 'Add',
            status : $scope.status,
            projAct : {proj_id : $scope.proj_id}

        };
        
        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.project_activities.push(data.projAct);
        });      

    }

    function edit(index, act) {
        var attr = {
            size: 'md',
            templateUrl : '../project-activities/project-activities',
            saveUrl: '../project-activities/update',
            action: 'Edit',
            status : $scope.status,
            projAct : angular.copy(act)
        };
        attr.projAct.proj_id = $scope.proj_id;
        
        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.project_activities.splice(index, 1, angular.copy(data.projAct));
        });   
    }

    function deleteRow(index, act) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : act.name,
            deletedKey : act.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id){
            ProjectActivitiesRestApi.remove({activity_id : act.id}).$promise.then(function(result){
                if(result.status)
                {
                    console.log('successfully deleted');
                    vm.project_activities.splice(index, 1);
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
        vm.project_activities[data.id] = data;
        return '<button class="btn btn-warning" ng-click="padtc.edit(padtc.project_activities[' + data.id + '])">' +
            '   <i class="fa fa-edit"></i>' +
            '</button>&nbsp;' +
            '<button class="btn btn-danger" ng-click="padtc.delete(padtc.project_activities[' + data.id + '])" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
    }

});

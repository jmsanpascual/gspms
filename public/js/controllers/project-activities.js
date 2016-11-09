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
    var vm = this,
        completedActivityId = 4,
        approvedActivityCount = 0;

    vm.message = '';
    vm.percentage = '0%';

    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.project_activities = [];

    // Watch the length of activities to update the percentage of progress bar
    $scope.$watch('padtc.project_activities.length', function (newVal, oldVal) {
        if (newVal == oldVal) return;
        vm.percentage = (Math.round((approvedActivityCount / newVal) * 100)) + '%';
    });

    this.getProjActivities = function(proj_id)
    {
        ProjectActivitiesRestApi.query({proj_id : $scope.proj_id}).$promise.then(function (result) {
           result = result[0];
           console.log('Tasks:', result);
          if (result.status) {
              console.log('proj');
              console.log(result.proj);

              vm.project_activities =  result.proj_activities;
              var activitiesLen = result.proj_activities.length;

              for (var i = 0; i < activitiesLen; i++) {
                  if (result.proj_activities[i].status_id == completedActivityId) {
                      approvedActivityCount++;
                  }
              }

              if (approvedActivityCount > 0) {
                  vm.percentage = (Math.round((approvedActivityCount / activitiesLen) * 100)) + '%';
              } else {
                  vm.percentage = '0%';
              }
          } else {
              alert('Unable to load datatable');
          }
       });
    }

    // $scope.status = {};

    // activityStatusRestApi.query().$promise.then(function(result){
    //     var result = result[0];
    //     if(result.status)
    //     {
    //         $scope.status = result.activity_status;
    //     }
    //     else
    //     {
    //         alert(result.status);
    //     }
    // });

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
            // status : $scope.status,
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
            // status : $scope.status,
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


})

.controller('ActivityTaskController', function ($scope, $rootScope) {
    var tasks =  $scope.submitData.projAct.tasks,
        taskLen = !tasks ? 0 : tasks.length,
        approvedTaskCount = 0;

    $scope.percentage = '0%';

    for (var i = 0; i < taskLen; i++) {
        if (tasks[i].done) {
            approvedTaskCount++;
        }
    }

    if (approvedTaskCount > 0) {
        $scope.percentage = (Math.round((approvedTaskCount / taskLen) * 100)) + '%';
    }

    // Watch the length of activity tasks to update the percentage of progress bar
    $scope.$watch('submitData.projAct.tasks.length', function (newVal, oldVal) {
        if (newVal == oldVal) return;

        approvedTaskCount = 0;
        tasks = $scope.submitData.projAct.tasks;
        taskLen = newVal;
        $scope.percentage = '0%';

        for (var i = 0; i < taskLen; i++) {
            if (tasks[i].done) {
                approvedTaskCount++;
            }
        }

        if (approvedTaskCount > 0) {
            $scope.percentage = (Math.round((approvedTaskCount / taskLen) * 100)) + '%';
        }
    });

    $rootScope.$on('task-updated', function () {
        approvedTaskCount = 0;
        $scope.percentage = '0%';

        for (var i = 0; i < taskLen; i++) {
            if (tasks[i].done) {
                approvedTaskCount++;
            }
        }

        if (approvedTaskCount > 0) {
            $scope.percentage = (Math.round((approvedTaskCount / taskLen) * 100)) + '%';
        }
    });
})

.constant('actStatus', {
    ACT_STAT_APPROVED : 2,
    ACT_STAT_DISAPPROVED : 3,
    ACT_STAT_COMPLETED : 4
})

.controller('ActivityStatusCtrl', function($scope, ProjectActivitiesRestApi, actStatus){
    // this.proj_id;
    var _self = this;
    _self.data = {};
    _self.data.remarks = $scope.submitData.projAct.remarks
    var changeStatus = function()
    {
        ProjectActivitiesRestApi.request(_self.data).$promise.then(function(result){
            if(!result.status)
            {
                alert(result.msg);
                return;
            }
            // alert('approved');
            // from modal scope
            console.log(result);
            $scope.submitData.projAct.status_id = result.stat.id;
            $scope.submitData.projAct.status = result.stat.name;
            console.log('status');
            console.log($scope.submitData);
            $scope.closeSubmit($scope.submitData);
        });
    }

    _self.approve = function()
    {
        _self.data.id = actStatus.ACT_STAT_APPROVED; // approved
        console.log(_self.data);
        changeStatus();
    }

    _self.disapprove = function()
    {
        _self.data.id = actStatus.ACT_STAT_DISAPPROVED; // approved
        changeStatus();
    }

    _self.completed = function()
    {
        _self.data.id = actStatus.ACT_STAT_COMPLETED; // completed
        changeStatus();
    }
})

.constant('projStatus', {
    PROJ_STAT_ONGOING : 1,
    PROJ_STAT_FOR_APPROVAL : 2,
    PROJ_STAT_COMPLETED : 3,
    PROJ_STAT_DISAPPROVED : 4,
    PROJ_STAT_APPROVED: 5
})

.controller('btnCtrl', function($scope, defaultModal, ProjRestApi, projStatus, $window){
    var _self = this;
    _self.data = {};
    _self.data.remarks = $scope.submitData.proj.remarks
    var changeStatus = function()
    {
        // if(!confirm('Are you sure you want to '))
        //     return;

        ProjRestApi.request(_self.data).$promise.then(function(result){
            if(!result.status)
            {
                alert(result.msg);
                return;
            }
            // alert('approved');
            // from modal scope
            console.log(result);
            $scope.submitData.proj.proj_status_id = result.stat.id;
            $scope.submitData.proj.status = result.stat.name;
            console.log('status');
            console.log($scope.submitData);
            $scope.closeSubmit($scope.submitData);
        });
    }

    _self.approve = function()
    {
        _self.data.id = projStatus.PROJ_STAT_APPROVED; // approved
        console.log(_self.data);
        changeStatus();
    }

    _self.disapprove = function()
    {
        _self.data.id = projStatus.PROJ_STAT_DISAPPROVED; // approved
        changeStatus();
    }

    _self.completed = function()
    {
        _self.data.id = projStatus.PROJ_STAT_COMPLETED; // completed
        changeStatus();
    }

    _self.showItem = function()
    {
        var attr = {
            size: 'lg',
            templateUrl : '../items/items',
            proj_id : _self.data.proj_id
        };

        defaultModal.showModal(attr);
    }

    _self.showReqBudget = function()
    {
        // console.log('proj id');
        // console.log(_self.proj_id);
        var attr = {
            size: 'md',
            templateUrl : '../budget-request/budget-request',
            proj_id : _self.data.proj_id
        };

        defaultModal.showModal(attr);
    }

    _self.showAttachments = function() {
        var attr = {
            size: 'md',
            templateUrl : '../project-attachments/project-attachments',
            proj_id : _self.data.proj_id
        };

        defaultModal.showModal(attr);
    }

    _self.showRelated = function() {
        var attr = {
            size: 'md',
            templateUrl : '../projects/view-related',
            proj_id : _self.data.proj_id
        };

        defaultModal.showModal(attr);
    }

    _self.showReport = function()
    {
        ProjRestApi.report({proj_id : 1}).$promise.then(function(result){
            // console.log(result);
            // if(!result.status)
            // {
            //     alert(result.msg);
            //     return;
            // }

            var file = new Blob([result], {type : 'application/pdf'});
            var fileURL = URL.createObjectURL(file);
            $window.open(fileURL);
        });
        console.log('report');
    }
});

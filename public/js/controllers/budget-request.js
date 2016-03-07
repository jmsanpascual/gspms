'use strict'
angular.module('budget.request.controller', 
    [
    'budgetRequest.service', 
    'datatables', 
    'common.service', 
    'ui.bootstrap',
    'budgetRequestStatus.service'
    ])
  
.controller('BudgetReqCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnDefBuilder, 
    defaultModal, BudgetRequestRestApi, BudgetRequestStatusRestApi) {
    // $scope.proj_id = 1; //declared in modals/projects.blade.php
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.budget_requests = [];

    $scope.getProjBudgetReq = function()
    {
        console.log('proj_id');
        console.log($scope.proj_id);
        BudgetRequestRestApi.query({proj_id : $scope.proj_id}).$promise.then(function (result) {
           result = result[0];
           console.log(result);
          if (result.status) {
              console.log('request');
              console.log(result.budget_requests);
              vm.budget_requests =  result.budget_requests;
          } else {
              alert('Unable to load datatable');
          }
       });
    }

    $scope.status = {};

    BudgetRequestStatusRestApi.query().$promise.then(function(result){
        var result = result[0];
        if(result.status)
        {
            $scope.status = result.br_status;
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
        DTColumnDefBuilder.newColumnDef(4).notSortable()
    ];


    this.add = function()
    {
        var attr = {
            size: 'md',
            templateUrl : '../budget-request/add',
            saveUrl: '../budget-request',
            action: 'Add',
            status : $scope.status,
            brequest : {proj_id : $scope.proj_id}

        };

        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.budget_requests.push(data.brequest);
        });      

    }

    function edit(index, act) {
        var attr = {
            size: 'md',
            templateUrl : '../budget-request/add',
            saveUrl: '../budget-request/update',
            action: 'Edit',
            status : $scope.status,
            brequest : angular.copy(act)
        };
        attr.brequest.proj_id = $scope.proj_id;
        
        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.budget_requests.splice(index, 1, angular.copy(data.brequest));
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
            BudgetRequestRestApi.remove({id : act.id}).$promise.then(function(result){
                if(result.status)
                {
                    console.log('successfully deleted');
                    vm.budget_requests.splice(index, 1);
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }

})




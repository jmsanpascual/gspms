'use strict'
var projActCtrl = angular.module('project.activites.controller', ['projectActivities.service', 'datatables', 'common.service', 'ui.bootstrap']);
  
projActCtrl.controller('projActDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnBuilder, 
    reqDef, defaultModal, ProjectActivitiesRestApi) {
    $scope.proj_id = 1; //declared in modals/projects.blade.php
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.project_activities = {};

    // .fromSource('js/controllers/data.json')
    vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
            return ProjectActivitiesRestApi.query({proj_id : $scope.proj_id}).$promise.then(function (result) {
                       result = result[0];
                      if (result.status) {
                          console.log('proj');
                          console.log(result.proj);
                          return result.proj_activities;
                      } else {
                          alert('Unable to load datatable');
                      }

                   });
       }).withPaginationType('full_numbers')
        .withOption('createdRow', createdRow);

    vm.dtColumns = [
        DTColumnBuilder.newColumn('name').withTitle('Activity Name'),
        DTColumnBuilder.newColumn('start_date').withTitle('Start Date'),
        DTColumnBuilder.newColumn('end_date').withTitle('End Date'),
        DTColumnBuilder.newColumn('total_budget').withTitle('Status'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
    ];
    this.add = function()
    {
      alert('activities add');
        var attr = {
            size: 'lg',
            templateUrl : 'project_activities',
            saveUrl: 'project_activities/update',
            action: 'Add'
        };

        // console.log('proj');
        // console.log(proj);

        // var openModal = function(attr){
            var modal = defaultModal.showModal(attr);

        //     // when the modal opens
        //     modal.result.then(function(data){
        //         console.log(data);
        //         console.log('updating');
        //         // adding of user
        //         // reqDef.post('editUser',data.users).then(function(result){
        //         //     if(result.status){
        //                 vm.dtInstance.reloadData(); // update datatable here
        //             // }
        //             // else
        //             // {
        //             //     //error

        //             // }
        //         // });
        //     });
        // }
        // call open modal
        // showUserDetails
        // reqDef.get('project_activities/details/' + padtc.id).then(function(result){
        //     console.log(result);
        //     // console.log('show user details');
        //     // if(result.roles != undefined)
        //     //     attr.roles = result.roles;

        //     // if(result.users != undefined)
        //     //     attr.users = result.users;

        //     openModal(attr);
        // }, function(err){
        //     openModal(attr);
        // });
    }

    function edit(attr) {
        var attr = {
            size: 'lg',
            templateUrl : 'showProj',
            saveUrl: 'project_activities/update'
        };

        console.log('proj');
        console.log(proj);

        var openModal = function(attr){
            var modal = defaultModal.showModal(attr);

            // when the modal opens
            modal.result.then(function(data){
                console.log(data);
                console.log('updating');
                // adding of user
                // reqDef.post('editUser',data.users).then(function(result){
                //     if(result.status){
                        vm.dtInstance.reloadData(); // update datatable here
                    // }
                    // else
                    // {
                    //     //error

                    // }
                // });
            });
        }
        // call open modal
        // showUserDetails
        reqDef.get('project_activities/details/' + padtc.id).then(function(result){
            console.log(result);
            // console.log('show user details');
            // if(result.roles != undefined)
            //     attr.roles = result.roles;

            // if(result.users != undefined)
            //     attr.users = result.users;

            openModal(attr);
        }, function(err){
            openModal(attr);
        });

        // Edit some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
    }

    function deleteRow(attr) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : padtc.name,
            deletedKey : padtc.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id){
            reqDef.delete('project_activities/'+id).then(function(result){
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
        vm.project_activities[data.id] = data;
        return '<button class="btn btn-warning" ng-click="padtc.edit(padtc.project_activities[' + data.id + '])">' +
            '   <i class="fa fa-edit"></i>' +
            '</button>&nbsp;' +
            '<button class="btn btn-danger" ng-click="padtc.delete(padtc.project_activities[' + data.id + '])" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
    }

});

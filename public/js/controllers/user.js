'use strict'

var users = angular.module('users', ['datatables','common.service', 'ui.bootstrap']);

users.controller('userDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnBuilder, reqDef) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.persons = {};
    // .fromSource('js/controllers/data.json')
    vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
            
            return reqDef.get('fetchUsers').then(function(result){
                console.log(result);
                if(result.status)
                {
                    console.log('users');
                    console.log(result.users);
                    return result.users;
                }
                else
                {
                    alert('Unable to load datatable');
                }
                
            }, function(err){
                alert('Unable to load datatable');
            });
       }).withPaginationType('full_numbers')
        .withOption('createdRow', createdRow);

    vm.dtColumns = [
        DTColumnBuilder.newColumn('username').withTitle('Username'),
        DTColumnBuilder.newColumn('first_name').withTitle('First NAme'),
        DTColumnBuilder.newColumn('last_name').withTitle('Last Name'),
        DTColumnBuilder.newColumn('email').withTitle('Email'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
    ];


    function deleteRow(person) {
        vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        vm.dtInstance.reloadData();
    };

    function edit(person) {
        vm.message = 'You are trying to edit the row: ' + JSON.stringify(person);
        // Edit some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        vm.dtInstance.reloadData();
    };


    function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }
    function actionsHtml(data, type, full, meta) {
        vm.persons[data.id] = data;
        return '<button class="btn btn-warning" ng-click="showCase.edit(showCase.persons[' + data.id + '])">' +
            '   <i class="fa fa-edit"></i>' +
            '</button>&nbsp;' +
            '<button class="btn btn-danger" ng-click="showCase.delete(showCase.persons[' + data.id + '])" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
    }
});

users.controller('userCtrl', function($scope,defaultModal, reqDef){
    $scope.users = {};
    $scope.add = function(){

        var attr = {
            size: 'md',
            templateUrl : 'addUser'
        };
        var userModal = defaultModal.showModal(attr);

        userModal.result.then(function(data){
            console.log(data);
            console.log('adding');
            
            reqDef.post('addUser',data).then(function(result){
                if(result.status){

                }
                else
                {
                    //error

                }
            });
        });
    };

    $scope.addUser = function()
    {
        
    }
});

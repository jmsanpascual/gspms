'use strict'

var users = angular.module('users', ['datatables','common.service', 'ui.bootstrap']);

users.controller('userDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnBuilder, reqDef, defaultModal) {
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

                if (result.status) {
                    // console.log('users');
                    // console.log(result.users);
                    return result.users;
                } else {
                    alert('Unable to load datatable');
                }

            }, function(err){
                alert('Unable to load datatable');
            });
       }).withPaginationType('full_numbers')
        .withOption('createdRow', createdRow);

    vm.dtColumns = [
        DTColumnBuilder.newColumn('username').withTitle('Username'),
        DTColumnBuilder.newColumn('fname').withTitle('First NAme'),
        DTColumnBuilder.newColumn('lname').withTitle('Last Name'),
        DTColumnBuilder.newColumn('email').withTitle('Email'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
    ];

    function edit(person) {
        var attr = {
            size: 'md',
            templateUrl : 'addUser',
            saveUrl: 'editUser'
        };

        console.log('person');
        console.log(person);

        var openModal = function(attr){
            var userModal = defaultModal.showModal(attr);

            // when the modal opens
            userModal.result.then(function(data){
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
        reqDef.get('showUserDetails/' + person.id).then(function(result){
            console.log(result);
            console.log('show user details');
            if(result.roles != undefined)
                attr.roles = result.roles;

            if(result.users != undefined)
                attr.users = result.users;

            openModal(attr);
        }, function(err){
            openModal(attr);
        });

        // Edit some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
    }

    function deleteRow(person) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : person.username,
            deletedKey : person.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id){
            reqDef.delete('deleteUser/'+id).then(function(result){
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
            templateUrl : 'addUser',
            saveUrl: 'addUser'
        };

        var openModal = function(attr){
            var userModal = defaultModal.showModal(attr);

            // when the modal opens
            userModal.result.then(function(data){
                console.log(data);
                console.log('added');
                // adding of user
                // reqDef.post('addUser',data.users).then(function(result){
                //     if(result.status){
                //         //success
                //     }
                //     else
                //     {
                //         //error

                //     }
                // });
            });
        }
        // call open modal
        reqDef.get('getRoles').then(function(result){
            if(result.roles != undefined)
                attr.roles = result.roles;

            openModal(attr);
        }, function(err){
            openModal(attr);
        });

        
    };

});
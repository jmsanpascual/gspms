'use strict'

angular.module('users', [
    'datatables',
    'common.service',
    'ui.bootstrap',
    'roles.service',
    'notification',
])

.controller('userDTCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnDefBuilder, reqDef, defaultModal, rolesRestApi) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    $scope.roles = {};

    rolesRestApi.query().$promise.then(function(result){
        result = result[0];
        $scope.roles = result.roles;
    });

    this.refresh = function(){

        vm.persons = [];
        console.log('reset');
        reqDef.get('fetchUsers').then(function(result){

                console.log(result);

                if (result.status) {
                    // console.log('users');
                    // console.log(result.users);
                    vm.persons = result.users;
                } else {
                    alert('Unable to load datatable');
                }

            }, function(err){
                alert('Unable to load datatable');
            });
    }
    vm.refresh();
    console.log('persons');
    console.log(vm.persons);

    vm.dtOptions = DTOptionsBuilder.newOptions()
    .withPaginationType('full_numbers');

    vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4).notSortable()
    ];


    this.add = function(){
        console.log(vm.persons);
        var attr = {
            size: 'md',
            templateUrl : 'addUser',
            saveUrl: 'addUser',
            action: 'Add',
            roles : $scope.roles,
            selectedRole: $scope.roles[0].id
        };

        var openModal = function(attr){
            var userModal = defaultModal.showModal(attr);

            // when the modal opens
            userModal.result.then(function(data){
                console.log(data);
                console.log('added');
                // adding of user
                vm.persons.unshift(data.users);
                console.log(vm.persons);
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


    }

    function edit(index, person) {
        var user = angular.copy(person);
        // delete user.password;
        var attr = {
            size: 'md',
            templateUrl : 'addUser',
            saveUrl: 'editUser',
            action: 'Edit',
            users : user,
            roles : $scope.roles,
            selectedRole: person.selectedRole
        };

        var userModal = defaultModal.showModal(attr);

        // when the modal opens
        userModal.result.then(function(data){
            console.log(data);
            console.log('updating');

            vm.persons.splice(index, 1, angular.copy(data.users));
        });

    }

    function deleteRow(index, person) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        console.log(person);
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
                    vm.persons.splice(index, 1);
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }
});

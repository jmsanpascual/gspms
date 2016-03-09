'use strict'

angular.module('resourcePersons', ['datatables','common.service', 'ui.bootstrap', 'resourcePersonService'])

.controller('resourcePersonDTCtrl', function($scope, $compile, ResourcePerson, DTOptionsBuilder, DTColumnBuilder, defaultModal) {
    var rp = this;
    rp.message = '';
    rp.edit = edit;
    rp.delete = deleteRow;
    rp.dtInstance = {};
    rp.persons = {};

    // .fromSource('js/controllers/data.json')
    rp.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
        return ResourcePerson.getResourcePersons().then(function (resourcePersons) {
            console.log('Resource Persons:', resourcePersons);
            return resourcePersons;
        }, function(err){
            alert('Unable to load resource persons');
        });
    }).withPaginationType('full_numbers').withOption('createdRow', createdRow);

    rp.dtColumns = [
        DTColumnBuilder.newColumn('name').withTitle('Name'),
        DTColumnBuilder.newColumn('profession').withTitle('Profession'),
        DTColumnBuilder.newColumn('email').withTitle('Email'),
        DTColumnBuilder.newColumn('contact_num').withTitle('Contact'),
        DTColumnBuilder.newColumn('school').withTitle('School'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
    ];

    rp.add = function () {
        var attr = {
            size: 'lg',
            templateUrl : 'add-resource-persons',
            // saveUrl: '../resource-persons',
            action: 'Add',
            keepOpen : true, // keep open even after save
            // programs : $scope.program,
            // status : $scope.status,
            // champions : $scope.champions,
            // resource_person : $scope.resource_person
        };
        var modal = defaultModal.showModal(attr);
        // add to datatable
        modal.result.then(function(data){
            // rp.projects.push(data);
        });
    }

    function edit (resourcePerson) {
        var attr = {
            size: 'md',
            templateUrl : 'addUser',
            saveUrl: 'editUser'
        };

        console.log('Resource Person:', resourcePerson);

        var openModal = function (attr) {
            var userModal = defaultModal.showModal(attr);

            // when the modal opens
            userModal.result.then(function (data) {
                console.log(data);
                console.log('updating');
                rp.dtInstance.reloadData();
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

    function deleteRow(resourcePerson) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : resourcePerson.first_name,
            deletedKey : resourcePerson.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function (id) {
            // reqDef.delete('deleteUser/'+id).then(function(result){
            //     if (result.status) {
            //         console.log('successfully deleted');
            //     } else {
            //         console.log('not deleted');
            //     }
            // });
        });
    }

    function createdRow(row, data, dataIndex) {
        // Recompiling so we can bind Angular directive to the DT
        $compile(angular.element(row).contents())($scope);
    }

    function actionsHtml(data, type, full, meta) {
        rp.persons[data.id] = data;
        return '<button class="btn btn-warning" ng-click="showCase.edit(showCase.persons[' + data.id + '])">' +
            '   <i class="fa fa-edit"></i>' +
            '</button>&nbsp;' +
            '<button class="btn btn-danger" ng-click="showCase.delete(showCase.persons[' + data.id + '])" )"="">' +
            '   <i class="fa fa-trash-o"></i>' +
            '</button>';
    }
})

.controller('resourcePersonCtrl', function($scope, defaultModal, reqDef) {
    var rp = this;
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

angular.module('showcase.bindAngularDirective', ['datatables'])
.controller('BindAngularDirectiveCtrl', BindAngularDirectiveCtrl);

function BindAngularDirectiveCtrl($scope, $compile, DTOptionsBuilder, DTColumnBuilder, $http) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.persons = {};
    // .fromSource('js/controllers/data.json')
    vm.dtOptions = DTOptionsBuilder.fromFnPromise(function() {
            
            return $http.get('fetchUsers').then(function(result){
                result = result.data;
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
        DTColumnBuilder.newColumn('AccountDetailsID').withTitle('ID'),
        DTColumnBuilder.newColumn('Username').withTitle('Username'),
        DTColumnBuilder.newColumn('AccountType').withTitle('Account Type'),
        DTColumnBuilder.newColumn(null).withTitle('Actions').notSortable()
            .renderWith(actionsHtml)
    ];

    function edit(person) {
        vm.message = 'You are trying to edit the row: ' + JSON.stringify(person);
        // Edit some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        vm.dtInstance.reloadData();
    }
    function deleteRow(person) {
        vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        vm.dtInstance.reloadData();
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
}
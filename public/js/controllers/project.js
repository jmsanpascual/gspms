'use strict'
angular.module('project.controller', [
    'project.service',
    'program.service',
    'projectStatus.service',
    'dynamicElement',
    'user.service',
    'datatables',
    'common.service',
    'ui.bootstrap',
    'project.activites.controller',
    'budget.request.controller',
    'items.controller',
    'resourcePersonService',
    'project.attachment',
    'upload',
    'toast',
    'project-related',
    'notification',
    'projectExpense',
    'activityItemExpense',
])

.controller('projDTCtrl', function($scope, DTOptionsBuilder, DTColumnDefBuilder,
  reqDef, defaultModal, Project, ProgramRestApi, ProjectStatusRestApi, UserRestApi, ResourcePerson,
  ResourcePersonManager) {
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.projects = [];
    vm.resourcePersons = [];

    vm.refresh = function()
    {
        console.log('refresh ');
        Project.getProjects().then(function (result) {
            result = result[0];
            if (result.status) {
                console.log('Projects:', result.proj);
                vm.projects = result.proj;
            } else {
                alert('Unable to load datatable');
            }
        });
    }
    vm.refresh();

    vm.getResourcePerson = function(program_id, data) {
        return ResourcePerson.get({program_id: program_id}).then(function (resourcePersons) {
            console.log('Resource Persons:', resourcePersons);
            resourcePersons.unshift({id: 'NA', name: 'No Resource Person'});
            if (data) {
                return data.resource_person = resourcePersons;
            }

            // ResourcePersonManager.set(resourcePersons);
            // vm.resourcePersons = ResourcePersonManager.get();
            vm.resourcePersons = resourcePersons;

        });
    }

    // vm.resourcePersons.unshift({id:'NA', name: 'No Resource Person'});

    // ResourcePerson.getResourcePersons().then(function (resourcePersons) {
    //     console.log('Resource Persons:', resourcePersons);
    //     vm.resourcePersons = resourcePersons;

    //     vm.resourcePersons.unshift({id:'NA', name: 'No Resource Person'});
    // });

    // instantiate program
    ProgramRestApi.query().$promise.then(function (programs) {
        var result = programs[0];
        console.log('Programs:', result);

        if (result.status) {
            $scope.program = result.program;
            vm.getResourcePerson($scope.program[0]);
        } else {
            console.log(result.msg);
        }
    });

    // instantiate project status
    ProjectStatusRestApi.query().$promise.then(function (projectStatus) {
        var result = projectStatus[0];
        console.log('Project Status:', result);

        if (result.status) {
            $scope.status = result.projectStatus;
        } else {
            console.log(result.msg);
        }
    });

    UserRestApi.getChampion().$promise.then(function (result) {
        if (result.status) {
            $scope.champions = result.champions;
        } else {
            console.log(result.msg);
        }
    });

    // To be deleted, not Used anymore
    // UserRestApi.getResourcePerson().$promise.then(function (result) {
    //     if (result.status) {
    //         $scope.resource_person = result.resource_persons;
    //     } else {
    //         console.log(result.msg);
    //     }
    // });

    vm.dtOptions = DTOptionsBuilder.newOptions()
        .withOption('aaSorting', [1, 'desc'])
        .withPaginationType('full_numbers');

    vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3).withClass('right'),
        DTColumnDefBuilder.newColumnDef(4),
        DTColumnDefBuilder.newColumnDef(5).notSortable()
    ];

    this.add = function () {
        var attr = {
            size: 'lg',
            templateUrl: 'projects',
            saveUrl: '../projects',
            action: 'Add',
            keepOpen: true, // keep open even after save
            programs: $scope.program,
            program: $scope.program[0],
            status: $scope.status,
            champions: $scope.champions,
            champion: $scope.champions[0],
            resource_person: vm.resourcePersons,
            resource: vm.resourcePersons[0],
            proj: {objective: {}},
            getResourcePerson: vm.getResourcePerson
        };
        var modal = defaultModal.showModal(attr);

        // Add to datatable
        modal.result.then(function(data) {
            // vm.projects.push(data);
            vm.refresh();
        });
    }

    function edit(index, proj) {
        // console.log(proj);
        var attr = {
            size: 'lg',
            templateUrl: 'projects',
            saveUrl: '../projects/update',
            action: 'Edit',
            // keepOpen : true, // keep open even after save
            programs: $scope.program,
            program: {id: proj.program_id},
            status: $scope.status,
            champions: $scope.champions,
            champion: {id: proj.champion_id},
            resource_person: vm.resourcePersons,
            resource: {id: proj.resource_person_id},
            proj: angular.copy(proj),
            getResourcePerson: vm.getResourcePerson
        };

        var modal = defaultModal.showModal(attr);
        return modal.result.then(function (data) {
            // vm.projects.splice(index, 1, angular.copy(data.proj));
            //save
            vm.refresh();
        }, function() {
            // close
            vm.refresh();
        });
    }

    function deleteRow(index, proj) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName: proj.name,
            deletedKey: proj.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id) {
            Project.remove({id: id}).then(function(result) {
                if (result.status)
                {
                    console.log('successfully deleted');
                    vm.projects.splice(index, 1);
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }
})

.controller('ProjBudgetCtrl', function($http, ExpenseManager, BudgetManager) {
    var vm = this;
    vm.expense;
    vm.budget;
    // vm.proj_id;
    vm.getTotalExpense = getTotalExpense;
    vm.getTotalBudget = getTotalBudget;

    // activate();

    function getTotalExpense(proj_id) {
        if (!proj_id) return;

        $http.get('../project-expense/total_expense/' + proj_id).then(function(result) {
            result = result.data;
            ExpenseManager.setTotal(result.total_expense);
            vm.expense = ExpenseManager.get();
        });
    }

    function getTotalBudget(proj_id) {
        if (!proj_id) return;

        $http.get('../budget-request/getTotalBudget/' + proj_id).then(function(result) {
            result = result.data;
            BudgetManager.setTotal(result.total_budget);
            vm.budget = BudgetManager.get();
        });
    }
})

.directive('dateFormat', function() {
    return {
        require: 'ngModel',
        link: function(scope, element, attr, ngModelCtrl) {
      //Angular 1.3 insert a formater that force to set model to date object, otherwise throw exception.
      //Reset default angular formatters/parsers
            ngModelCtrl.$formatters.length = 0;
            ngModelCtrl.$parsers.length = 0;

            ngModelCtrl.$formatters.push(function(valueFromModel) {
         //return how data will be shown in input
                if (valueFromModel) {
             // For momentjs > 2.9 moment global va is not defined use momentjs instead of moment.
                    return valueFromModel.substr(0, valueFromModel.indexOf(' ')) || valueFromModel;
                }
                else
              return null;
            });
        }
    };
});

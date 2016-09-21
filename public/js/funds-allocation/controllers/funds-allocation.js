'use strict';

angular.module('fundsAllocation')
.controller('FundsAllocationCtrl', function($scope, $compile, FundsAllocation, Project,
    DTOptionsBuilder, DTColumnDefBuilder, defaultModal) {

    var fa = this;
    fa.message = '';
    fa.dtInstance = {};
    fa.allocatedFunds = [];

    fa.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

    fa.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3).notSortable()
    ];

    FundsAllocation.query().then(function (allocatedFunds) {
        console.log('Allocated Funds:', allocatedFunds);
        fa.allocatedFunds = allocatedFunds;
    }, function (error) {
        alert('Unable to load allocated funds.');
        console.log('Error:', error);
    });

    Project.getOnGoingProjects().then(function (projects) {
        console.log('Projects:', projects);
        fa.projects = projects;
    }, function (error) {
        alert('Unable to load projects.');
        console.log('Error:', error);
    });

    fa.add = function () {
        var attr = {
            size: 'md',
            templateUrl : 'create',
            resource: true,
            action: 'Add',
            projects : fa.projects,
            project: fa.projects[0],
        };
        var modal = defaultModal.showModal(attr);

        modal.result.then(function (data) {
            console.log("Allocated Fund:", data);
            var request = {
                project_id: data.allocatedFund.project.id,
                amount: data.allocatedFund.amount
            };

            FundsAllocation.save(request).then(function (allocatedFund) {
                console.log('Added:', allocatedFund);
                var project = {
                    id: data.allocatedFund.project.id,
                    name: data.allocatedFund.project.name,
                    total_budget: data.allocatedFund.project.total_budget
                };

                allocatedFund.project = project;
                fa.allocatedFunds.push(allocatedFund);

                project.total_budget += parseInt(allocatedFund.amount);
                Project.updateTotalBudget(project).then(function (result) {
                    console.log('Total Budget of project is updated successfully!', result);
                });
            });
        });
    };

    fa.edit = function (index, fund) {
        console.log('Fund:', fund);
        var attr = {
            size: 'md',
            templateUrl : 'create',
            action: 'Edit',
            resource: true,
            allocatedFund: fund,
            projects : fa.projects,
            // project: angular.copy(fund.project) // Not Working, project is not a resource
            project: getProject()
        };

        // Temporary solution
        function getProject() {
            var len = fa.projects.length;
            var project;

            for (var i = 0; i < len; i++) {
                if (fa.projects[i].id == fund.project.id)
                    return fa.projects[i];
            }
        }

        var userModal = defaultModal.showModal(attr);

        // when the modal opens
        userModal.result.then(function (data) {
            console.log("Allocated Fund:", data);
            var request = {
                id: data.allocatedFund.id,
                project_id: data.allocatedFund.project.id,
                amount: data.allocatedFund.amount
            };

            FundsAllocation.update(request).then(function (result) {
                console.log('Update yeah!', result);
                fund.amount = data.allocatedFund.amount;
                fund.project = data.allocatedFund.project;

                var project = data.allocatedFund.project;
                project.total_budget += parseInt(data.allocatedFund.amount);
                Project.updateTotalBudget(project).then(function (result) {
                    console.log('Total Budget of project is updated successfully!', result);
                });
            });
        });
    }

    fa.delete = function (index, fund) {
        var attr = {
            deleteName : fund.project.name
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function () {
            fund.$delete(function () {
                fa.allocatedFunds.splice(index, 1);
            });
        });
    }
});

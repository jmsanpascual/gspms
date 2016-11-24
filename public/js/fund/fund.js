'use strict'

angular.module('funds', ['ngResource', 'school', 'toast'])

.controller('FundCtrl', function (fund, School, toast) {
    var vm = this;

    vm.fund = {};

    activate();

    function activate() {
        School.query().$promise.then(function (schools) {
            vm.schools = schools;
            vm.fund.school = schools[0];
            vm.fund.year = new Date().getFullYear();
        });
    }

    vm.add = function (fundParam) {
        fund.add(fundParam).then(function (addedFund) {
            toast.success(fundParam.amount + ' was successfully added');
            reset();
        });
    };

    function reset() {
        vm.fund.amount = '';
        vm.fund.received_date = '';
    }
})

.factory('fund', function ($resource) {
    var fund = $resource('../funds/:id', {id: '@id'});

    function query() {
        return fund.query().$promise.then(function (funds) {
            return funds;
        })
    }

    function add(params) {
        return fund.save(params).$promise.then(function (fund) {
            return fund;
        });
    }

    return {
        query: query,
        add: add
    };
})

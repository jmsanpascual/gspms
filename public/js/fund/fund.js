'use strict'

angular.module('funds', ['ngResource'])

.controller('FundCtrl', function (fund) {
    var fundCtrl = this;

    fundCtrl.add = function (fundParam) {
        fundParam.year = new Date().getFullYear();
        fund.add(fundParam).then(function (addedFund) {
            console.log('Added fund:', addedFund);
            alert(fundParam.amount + ' was successfully added!');
            reset();
        });
    };

    function reset() {
        fundCtrl.capital.amount = '';
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

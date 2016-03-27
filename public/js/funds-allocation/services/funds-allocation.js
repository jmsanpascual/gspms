'use strict';

angular.module('fundsAllocation')
.factory('FundsAllocation', function (FundsAllocationApi) {
    function query() {
        return FundsAllocationApi.query().$promise;
    }

    function save(params) {
        var allocatedFund = new FundsAllocationApi(params);
        return FundsAllocationApi.save(allocatedFund).$promise;
    }

    function update(params) {
        return FundsAllocationApi.update(params).$promise;
    }

    return {
        query: query,
        save: save,
        update: update
    };
})

.factory('FundsAllocationApi', function ($resource) {
    return $resource('../funds-allocation/:id', {id: '@id'}, {
        update : {
            url: '../funds-allocation/update',
            method: 'POST'
        }
    });
});

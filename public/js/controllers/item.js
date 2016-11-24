'use strict'
angular.module('items.controller',
    [
    'items.service',
    'datatables',
    'common.service',
    'ui.bootstrap',
    'categories.service'
    ])

.controller('ItemCtrl', function($scope, $compile, DTOptionsBuilder, DTColumnDefBuilder,
    defaultModal, ItemsRestApi, CategoriesRestApi, $http) {
    // $scope.proj_id = 1; //declared in modals/projects.blade.php
    var vm = this;
    vm.message = '';
    vm.edit = edit;
    vm.delete = deleteRow;
    vm.dtInstance = {};
    vm.items = [];

    this.getProjItems = function()
    {
        console.log('proj_id');
        console.log($scope.proj_id);
        ItemsRestApi.query({proj_id : $scope.proj_id}).$promise.then(function (result) {
           result = result[0];
           console.log(result);
          if (result.status) {
              console.log('request');
              console.log(result.items);
              vm.items =  result.items;
          } else {
              alert('Unable to load datatable');
          }
       });
    }

    $scope.categories = {};

    CategoriesRestApi.query().$promise.then(function (result) {
       result = result[0];
       console.log(result);
      if (result.status) {
          console.log('request');
          console.log(result.categories);
          $scope.categories =  result.categories;
          $scope.categories.push({id: 'NA', name : 'Not in the list'});
      } else {
          alert('Unable to load datatable');
      }
   });

    // .fromSource('js/controllers/data.json')
    vm.dtOptions = DTOptionsBuilder.newOptions().withPaginationType('full_numbers');

    vm.dtColumnDefs = [
        DTColumnDefBuilder.newColumnDef(0),
        DTColumnDefBuilder.newColumnDef(1),
        DTColumnDefBuilder.newColumnDef(2),
        DTColumnDefBuilder.newColumnDef(3),
        DTColumnDefBuilder.newColumnDef(4),
        DTColumnDefBuilder.newColumnDef(5).notSortable()
    ];


    this.add = function()
    {
        var attr = {
            size: 'md',
            templateUrl : '../items/add',
            saveUrl: '../items',
            action: 'Add',
            categories : $scope.categories,
            category: $scope.categories[0].id,
            items : {proj_id : $scope.proj_id}
        };

        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.items.push(data.items);
        });

    }

    function edit(index, act) {
        var attr = {
            size: 'md',
            templateUrl : '../items/add',
            saveUrl: '../items/update',
            action: 'Edit',
            categories : $scope.categories,
            category: act.category_id,
            items : angular.copy(act)
        };
        attr.items.proj_id = $scope.proj_id;

        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            vm.items.splice(index, 1, angular.copy(data.items));
        });
    }

    function deleteRow(index, act) {
        // vm.message = 'You are trying to remove the row: ' + JSON.stringify(person);
        // Delete some data and call server to make changes...
        // Then reload the data so that DT is refreshed
        // vm.dtInstance.reloadData();
        var attr = {
            deleteName : act.name,
            deletedKey : act.id
        }
        var del = defaultModal.delConfirm(attr);

        del.result.then(function(id){
            ItemsRestApi.remove({id : act.id}).$promise.then(function(result){
                if(result.status)
                {
                    console.log('successfully deleted');
                    vm.items.splice(index, 1);
                }
                else
                {
                    console.log('not deleted');
                }
            });
        });
    }
})

.controller('addItemCategory', function($scope, defaultModal){
    var _self = this;

    _self.add_category = function()
    {
        var attr = {
            action : 'Add',
            templateUrl : '../categories/add',
            size : 'md',
            saveUrl : '../categories'
        };

        defaultModal.showModal(attr).result.then(function(data){
            console.log(data);
            $scope.submitData.categories.push(data.item_category);
        });
    }
})

.controller('PriceRecommendationController', function ($http) {
    var vm = this;

    vm.getPriceRecommendation = function (item) {
        console.log('Average price:', item);

        $http.get('../items/price-recommendation', {
            params: item
        }).then(function (response) {
            console.log('Average price success:', response);
            vm.priceRecommendation = 'Average Price: ' + response.data.recommendedPrice;
        }, function (error) {
            console.log('Average price error:', error);
            vm.priceRecommendation = 'Average Price: Unavailable';
        });
    };
})

.controller('AddItemController', function($http, $scope, defaultModal){
    var vm = this;

    vm.name = '';
    vm.storeItemName = storeItemName;

    $http.get('../items/names').then(function (response) {
        vm.itemNames = response.data.items;
        vm.itemNames.push({id: 'NA', name: 'Not in the list'});

        var itemsLen = vm.itemNames.length;

        if (itemsLen == 1) {
            vm.itemName = vm.itemNames[0];
        } else {
            for (var i = 0; i < itemsLen; i++) {

                if (($scope.$parent.submitData.items['item_name'] || '').toLowerCase() == vm.itemNames[i].name.toLowerCase()) {
                    vm.itemName = vm.itemNames[i];
                } else {
                    vm.itemName = vm.itemNames[itemsLen - 1];
                }
            }
        }
    }, function (error) {
        console.log('Error @AddItemController-http-get-item-names', error);
    });

    function storeItemName(item) {
        if (item.id == 'NA') return;

        $scope.$parent.submitData.items['item_name'] = item.name;
    }
});

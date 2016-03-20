@extends('layouts.defaultModal')

@section('title')
	Item/Expense Lists
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="ItemCtrl as ic" ng-init = 'proj_id = submitData.proj_id; getProjItems()'>
        <button class = "btn btn-success btn-sm pull-right" ng-click = "ic.add()"> Add Item/Expense</button>
        <p class="text-danger"><strong>@{{ ic.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="ic.dtOptions" dt-columns="ic.dtColumnDefs" dt-instance="ic.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Item Name</th>
              <th>Category</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in ic.items">
              <td>@{{data.item_name}}</td>
              <td>@{{data.category}}</td>
              <td>@{{data.quantity}}</td>
              <td>@{{data.price}}</td>
              <td>@{{ ((data.price) * (data.quantity)) }}</td>
              <td>
                <button class="btn btn-warning btn-sm" ng-click="ic.edit($index, data)">
                <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger btn-sm" ng-click="ic.delete($index ,data)">
                   <i class="fa fa-trash-o"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

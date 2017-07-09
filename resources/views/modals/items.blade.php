@extends('layouts.defaultModal')

@section('title')
	Item/Expense Lists
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="ItemCtrl as ic" ng-init = 'proj_id = submitData.proj_id; ic.getProjItems()'>
        @if(Session::get('role') == config('constants.role_champion'))
        <button class = "btn btn-success pull-right" ng-click = "ic.add()"> Add Item/Expense</button>
        @endif
        <button class = "btn btn-danger pull-right" ng-click = "ic.getProjItems()"> Refresh</button>

        <p class="text-danger"><strong>@{{ ic.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="ic.dtOptions" dt-columns="ic.dtColumnDefs" dt-instance="ic.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Item Name</th>
              <th>Category</th>
              <th>Quantity</th>
              <th class="right">Price</th>
              <th class="right">Total Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in ic.items">
              <td>@{{data.item_name}}</td>
              <td>@{{data.category}}</td>
              <td>@{{data.quantity}} (@{{data.quantity_label}})</td>
              <td class="right">@{{data.price  | number}}</td>
              <td class="right">@{{ ((data.price) * (data.quantity))  | number}}</td>
              <td>

              @if(Session::get('role') == config('constants.role_finance'))
                <button class="btn btn-warning btn-sm" ng-click="ic.edit($index, data)">
                <i class="fa fa-edit"></i>
                </button>
			  @endif
                @if(Session::get('role') == config('constants.role_champion'))
                <!-- <button class="btn btn-danger btn-sm" ng-click="ic.delete($index ,data)">
                   <i class="fa fa-trash-o"></i>
                </button> -->
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

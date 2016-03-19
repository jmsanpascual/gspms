@extends('layouts.defaultModal')

@section('title')
	Budget Request List
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="BudgetReqCtrl as brc" ng-init = 'proj_id = submitData.proj_id; getProjBudgetReq()'>
        <button class = "btn btn-success pull-right" ng-click = "brc.add()"> Request Budget</button>
        <p class="text-danger"><strong>@{{ brc.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="brc.dtOptions" dt-columns="brc.dtColumnDefs" dt-instance="brc.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Amount Requested</th>
              <th>Reason</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in brc.budget_requests">
              <td>@{{data.amount}}</td>
              <td>@{{data.reason}}</td>
              <td>@{{data.status}}</td>
              <td>
                <button class="btn btn-warning" ng-click="brc.edit($index, data)">
                <i class="fa fa-edit"></i>
                </button>
                <button class="btn btn-danger" ng-if = "data.status_id != 2" ng-click="brc.delete($index ,data)">
                   <i class="fa fa-trash-o"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

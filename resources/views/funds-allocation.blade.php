@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Funds</a>
              </li>
              <li>Funds Allocation</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Funds Allocation</h1>
      </div>
  </div>
  <div class="row" ng-app="fundsAllocation">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Funds Allocation</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="FundsAllocationCtrl as fa">
                <button class="btn btn-success btn-sm pull-right" ng-click="fa.add()">Allocate Funds</button>
                <div>
                  <p class="text-danger"><strong ng-bind="fa.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="fa.dtOptions" dt-columns="fa.dtColumns"
                  dt-instance="fa.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "fund in fa.allocatedFunds">
                        <td ng-bind="fund.project.name"></td>
                        <td ng-bind="fund.amount"></td>
                        <td ng-bind="fund.created_at"></td>
                        <td>
                          <button class="btn btn-warning btn-sm" ng-click="fa.edit($index, fund)">
                          <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" ng-click="fa.delete($index, fund)">
                             <i class="fa fa-trash-o"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('scripts')
{!! HTML::script('js/services/project.js') !!}
{!! HTML::script('js/funds-allocation/module.js') !!}
{!! HTML::script('js/funds-allocation/services/funds-allocation.js') !!}
{!! HTML::script('js/funds-allocation/controllers/funds-allocation.js') !!}
@endsection

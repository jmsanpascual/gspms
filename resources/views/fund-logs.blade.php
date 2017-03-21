@extends('layouts.index')

@section('content')
  <div class="row" ng-app="fundLogs" ng-controller="FundLogsCtrl as flc">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">School Funds</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">
                <button class = "btn btn-danger btn-sm pull-right" ng-click = "flc.refresh()">Refresh</button>
                <div>
                  <table datatable="ng" dt-options="flc.dtOptions" dt-columns="flc.dtColumns"
                  dt-instance="flc.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Fund From</th>
                        <th>Funded By</th>
                        <th>Amount</th>
                        <th>Received Date</th>
                        <th>Year</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "fund in flc.schoolFunds">
                          <td ng-bind="fund.type"></td>
                        <td ng-bind="fund.referer.name"></td>
                        <td ng-bind="fund.amount"></td>
                        <td ng-bind="fund.received_date"></td>
                        <td ng-bind="fund.year"></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Leftover Funds</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">
                <button class = "btn btn-danger btn-sm pull-right" ng-click = "flc.refresh()">Refresh</button>
                <div>
                  <table datatable="ng" dt-options="flc.dtOptions" dt-columns="flc.dtColumns"
                  dt-instance="flc.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Fund From</th>
                        <th>Project</th>
                        <th>Amount</th>
                        <th>Received Date</th>
                        <th>Year</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "fund in flc.projectFunds">
                        <td ng-bind="fund.type"></td>
                        <td ng-bind="fund.referer.name"></td>
                        <td ng-bind="fund.amount"></td>
                        <td ng-bind="fund.received_date"></td>
                        <td ng-bind="fund.year"></td>
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
{!! HTML::script('js/fund/fund-logs.controller.js') !!}
@endsection

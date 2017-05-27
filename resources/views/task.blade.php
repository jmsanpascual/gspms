@extends('layouts.index')

@section('content')

  <div class="row" ng-app="task">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Tasks</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="TaskController as tc">
                <!-- <button class="btn btn-success btn-sm pull-right" ng-click="tc.add()">Add Resource Person</button> -->
                <!-- <button class = "btn btn-danger btn-sm pull-right" ng-click = "tc.getResourcePersons()"> Refresh</button> -->
                <div>
                  <p class="text-danger"><strong ng-bind="tc.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="tc.dtOptions" dt-columns="tc.dtColumns"
                  dt-instance="tc.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Project</th>
                        <th>Task Name</th>
                        <th>Start Date</th>
                        <th>Completed</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "task in tc.tasks">
                        <td ng-bind="task.activity.project.name"></td>
                        <td ng-bind="task.name"></td>
                        <td ng-bind="task.activity.start_date"></td>
                        <td style="text-align:center;">
                          <!-- <input type="checkbox" ng-model="task.done"
                            ng-change="tc.update($index, task)"
                            ng-true-value="1" ng-false-value="0"
                            > -->
                            <span ng-class="{'glyphicon glyphicon-ok': task.done, 'glyphicon glyphicon-remove': !task.done}">
                        </td>
                        <td>
                          <button title="Edit Task" class="btn btn-warning btn-sm" ng-click="tc.edit($index, task)">
                            <i class="fa fa-edit"></i>
                          </button>
                          <a class="btn btn-success btn-sm" title="Status Report"
                          target="_blank" href="{{ asset('tasks/report/project-status') }}/@{{ task.activity.project.id }}">
                            <i class="fa fa-file-text" style="color:white;"></i>
                          </a>
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
{!! HTML::script('js/volunteer/task/task.module.js') !!}
{!! HTML::script('js/volunteer/task/task.controller.js') !!}
{!! HTML::script('js/volunteer/task/task.factory.js') !!}
<!-- project expense  -->
{!! HTML::script('js/services/item.js') !!}
{!! HTML::script('js/project-expense/project-expense.module.js') !!}
{!! HTML::script('js/project-expense/project-expense-manager.factory.js') !!}
{!! HTML::script('js/project-expense/project-expense-resource.factory.js') !!}
{!! HTML::script('js/project-expense/project-expense.controller.js') !!}
<!-- Activity item expense  -->
{!! HTML::script('js/activity-item-expense/activity-item-expense.module.js') !!}
{!! HTML::script('js/activity-item-expense/activity-item-expense-manager.factory.js') !!}
{!! HTML::script('js/activity-item-expense/activity-item-expense-resource.factory.js') !!}
{!! HTML::script('js/activity-item-expense/activity-item-expense.controller.js') !!}
@endsection

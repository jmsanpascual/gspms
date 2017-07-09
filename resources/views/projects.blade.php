@extends('layouts.index')

@section('css')
{!! HTML::style('js/upload/upload.css'); !!}
@endsection

@section('app')
ng-app='project.controller'
@endsection

@section('content')
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Projects</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">

                <div ng-controller="projDTCtrl as proj">
                  @if(Session::get('role') == config('constants.role_champion') ||
                  Session::get('role') == config('constants.role_exec'))
                  <button class = "btn btn-success btn-sm pull-right" ng-click = "proj.add()"> Add Project</button>&nbsp;
                  @endif
                  <a class="btn btn-default btn-sm pull-right" target="_blank" href = "{{asset('projects/report/summary')}}" style="margin-right:5px">
                      Project Summary Report
                  </a>
                  <button class = "btn btn-danger btn-sm pull-right" ng-click = "proj.refresh()" style="margin-right:5px">Refresh</button>

                  <p class="text-danger"><strong ng-bind="proj.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="proj.dtOptions" dt-columns="proj.dtColumnDefs" dt-instance="proj.dtInstance" class="table table-hover row-border hover">
                  <thead>
                    <tr>
                      <th>Project Title</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Initial Budget</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat = "data in proj.projects">
                      <td ng-bind="data.name"></td>
                      <td ng-bind="data.start_date"></td>
                      <td ng-bind="data.end_date"></td>
                      <td ng-bind="data.total_budget | number"></td>
                      <td ng-bind="data.status"></td>
                      <td>
                        <button class="btn btn-warning btn-sm" ng-if = "data.champion_id == {{Session::get('id')}} ||
                        {{ json_encode((Session::get('role') != config('constants.role_champion')))}}"
                        ng-click="proj.edit($index, data)">
                        <i class="fa fa-edit"></i>
                        </button>
                        @if(Session::get('role') == config('constants.role_champion') ||
                        Session::get('role') == config('constants.role_exec'))
                        <button class="btn btn-danger btn-sm" ng-if = "data.proj_status_id != 3" ng-click="proj.delete($index ,data)">
                           <i class="fa fa-trash-o"></i>
                        </button>
                        @endif
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
@parent

@endsection

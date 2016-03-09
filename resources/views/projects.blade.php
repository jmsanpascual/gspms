@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Projects</a>
              </li>
              <li>View Projects</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">View Projects</h1>
      </div>
  </div>
  <div class="row" ng-app = "project.controller">
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
                  <button class = "btn btn-success pull-right" ng-click = "proj.add()"> Add Project</button>
                  <p class="text-danger"><strong>@{{ proj.message }}</strong></p>
                  <br>
                  <table datatable="ng" dt-options="proj.dtOptions" dt-columns="proj.dtColumnDefs" dt-instance="proj.dtInstance" class="table table-hover row-border hover">
                  <thead>
                    <tr>
                      <th>Project Title</th>
                      <th>Start Date</th>
                      <th>End Date</th>
                      <th>Total Budget</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat = "data in proj.projects">
                      <td>@{{data.name}}</td>
                      <td>@{{data.start_date}}</td>
                      <td>@{{data.end_date}}</td>
                      <td>@{{data.total_budget}}</td>
                      <td>@{{data.status}}</td>
                      <td>
                        <button class="btn btn-warning" ng-click="proj.edit($index, data)">
                        <i class="fa fa-edit"></i>
                        </button>
                        <button class="btn btn-danger" ng-click="proj.delete($index ,data)">
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
{!! HTML::script('js/services/project-status.js') !!}
{!! HTML::script('js/services/program.js') !!}
{!! HTML::script('js/services/project.js') !!}
{!! HTML::script('js/services/project-activities.js') !!}
{!! HTML::script('js/services/user.js') !!}
{!! HTML::script('js/services/activity-status.js') !!}
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/project-activities.js') !!}
{!! HTML::script('js/services/budget-request.js') !!}
{!! HTML::script('js/services/budget-request-status.js') !!}
{!! HTML::script('js/controllers/budget-request.js') !!}
{!! HTML::script('js/services/item.js') !!}
{!! HTML::script('js/services/categories.js') !!}
{!! HTML::script('js/controllers/item.js') !!}
{!! HTML::script('js/controllers/project.js') !!}
@endsection

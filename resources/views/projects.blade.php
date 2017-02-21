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
                  <button class = "btn btn-success btn-sm pull-right" ng-click = "proj.add()"> Add Project</button>
                  @endif
                  <button class = "btn btn-danger btn-sm pull-right" ng-click = "proj.refresh()">Refresh</button>
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
                      <td ng-bind="data.total_budget"></td>
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
{!! HTML::script('js/activity-dependencies/activity-dependencies.module.js') !!}
{!! HTML::script('js/activity-dependencies/phase.factory.js') !!}
{!! HTML::script('js/activity-dependencies/progress-calculator.factory.js') !!}
{!! HTML::script('js/activity-dependencies/milestone.controller.js') !!}
{!! HTML::script('js/activity-dependencies/milestone.factory.js') !!}
{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/volunteer/volunteer.module.js') !!}
{!! HTML::script('js/volunteer/volunteer.factory.js') !!}
{!! HTML::script('js/volunteer/expertise/expertise.factory.js') !!}
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
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/item.js') !!}
{!! HTML::script('js/services/item-manager.factory.js') !!}
{!! HTML::script('js/controllers/project.js') !!}

<!-- Attachment -->
{!! HTML::script('js/project-attachments/project-attachment.module.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.controller.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.factory.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.service.js') !!}
<!-- End Attachment  -->
<!-- Related Project  -->
{!! HTML::script('js/project-related/project-related.module.js') !!}
{!! HTML::script('js/project-related/project-related.controller.js') !!}
<!-- End Related Project  -->
<!-- UPLOAD -->
{!! HTML::script('js/upload/upload.js') !!}
<!-- END UPLOAD -->
<!-- Toast -->
{!! HTML::script('js/others/toast.js') !!}
<!-- End Toast -->
{!! HTML::script('js/others/custom-prototypes.js') !!}
@endsection

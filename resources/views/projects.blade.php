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
                  <table datatable="" dt-options="proj.dtOptions" dt-columns="proj.dtColumns" dt-instance="proj.dtInstance" class="table table-hover row-border hover">
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
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/project.js') !!}
{!! HTML::script('js/controllers/project-activities.js') !!}
@endsection

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
        <h1 class="h1">Project List</h1>
    </div>
</div>

<div class="row" ng-app='project.controller' ng-controller='ProjectCtrl'>
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
          <table class="table table-striped">
            <thead>
              <tr>
                <th>#</th>
                <th>Project Name</th>
                <th>Budget</th>
                <th>Start Date</th>
                <th>End Date</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat='project in projects'>
                <td ng-bind='$index'></td>
                <td ng-bind='project.name'></td>
                <td ng-bind='project.total_budget'></td>
                <td ng-bind='project.start_date'></td>
                <td ng-bind='project.end_date'></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
  </div>
</div>

@endsection

@section('scripts')
{!! HTML::script('js/services/project.js') !!}
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/project.js') !!}
@endsection

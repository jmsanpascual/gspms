@extends('layouts.defaultModal')

@section('title')
	Related Projects
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="ProjectRelatedController as prc" ng-init = 'prc.activate(submitData.proj); prc.refresh()'>

 		<div class = "form-group">
 			<div class = "row">
 				<label class = "col-md-3">Average Total Budget</label>
 				<label class = "col-md-3" ng-bind="prc.ave_budget | number"></label>
 				<label class = "col-md-3">Average Duration</label>
 				<label class = "col-md-3" ng-bind="prc.ave_duration"></label>
 			</div>
 		</div>
 		<div class = "form-group">
 			<div class = "row">
 				<label class = "col-md-3">Minimum Total Budget</label>
 				<label class = "col-md-3" ng-bind="prc.min_budget | number"></label>
 				<label class = "col-md-3">Minimum Duration</label>
 				<label class = "col-md-3" ng-bind="prc.min_duration"></label>
 			</div>
 		</div>
 		<div class = "form-group">
 			<div class = "row">
 				<label class = "col-md-3">Maximum Total Budget</label>
 				<label class = "col-md-3" ng-bind="prc.max_budget | number"></label>
 				<label class = "col-md-3">Max Duration</label>
 				<label class = "col-md-3" ng-bind="prc.max_duration"></label>
 			</div>
 		</div>

        <button class = "btn btn-danger pull-right" ng-click = "prc.refresh()">Refresh</button>

        <p class="text-danger"><strong>@{{ prc.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="prc.dtOptions" dt-columns="prc.dtColumnDefs"
        dt-instance="prc.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Project Title</th>
              <th>Total Budget</th>
              <th>Duration</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in prc.related">
              <td>@{{data.name }}</td>
              <td>@{{data.total_budget}}</td>
              <td>@{{data.duration}}</td>
              <td>
				@if(session()->get('role') == config('constants.role_life') || session()->get('role') == config('constants.role_head'))
                <button class="btn btn-primary" title = "Edit" ng-click="prc.edit($index, data)">
                <i class="fa fa-exchange"></i>
                </button>
				@endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

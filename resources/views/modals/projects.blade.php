@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Project
@stop
@section('modal-content')
	<form role="form" id = "projForm">
		<h3>Project Information</h3>
		<hr>
		<input type ="hidden" ng-model = "submitData.proj.id">
		<input type ="hidden" ng-model = "submitData.proj.token">
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Project Name</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.name">
				</div>
				<label class = "form-label col-md-2">Program</label>
				<div class = "col-md-4">
					<select class = "form-control" ng-model = "submitData.proj.program_id" 
					ng-options = "p.id as p.name for p in submitData.programs">
					</select>
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Start Date</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.start_date">
				</div>
				<label class = "form-label col-md-2">End Date</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.end_date">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Partner Organization</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.partner_organization">
				</div>
				<label class = "form-label col-md-2">Partner Community</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.partner_community">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Status</label>
				<div class = "col-md-4">
					<select class = "form-control" ng-model = "submitData.proj.proj_status_id" 
					ng-options = "c.id as c.name for c in submitData.status">
					</select>
				</div>	
				<label class = "form-label col-md-2">Total Budget</label>
				<div class = "col-md-4">
					<input type = "text" class = "form-control" ng-model = "submitData.proj.total_budget">
				</div>
			</div>
			</div>
		</div>

		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Champion</label>
				<div class = "col-md-4">
					<select class = "form-control" ng-model = "submitData.proj.champion_id" 
					ng-options = "c.id as c.name for c in submitData.champions">
					</select>
				</div>
				<label class = "form-label col-md-2">Resource Person</label>
				<div class = "col-md-4">
					<select class = "form-control" ng-model = "submitData.proj.resource_person_id" 
					ng-options = "rp.id as rp.name for rp in submitData.resource_person">
					</select>
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-2">Objective</label>
				<div class = "col-md-10">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.proj.objective"></textarea>
				</div>
			</div>
			</div>
		</div>
		<!-- Activities -->
		<div ng-if = "submitData.proj.id">
		<h3>Activities</h3>
		<hr>
		 <div ng-controller="projActDTCtrl as padtc" ng-init = 'proj_id = submitData.proj.id; getProjActivities(submitData.proj.id)'>
	        <button class = "btn btn-success pull-right" ng-click = "padtc.add()"> Add Activity</button>
	        <p class="text-danger"><strong>@{{ padtc.message }}</strong></p>
	        <br>
	        <table datatable="ng" dt-options="padtc.dtOptions" dt-columns="padtc.dtColumnDefs" dt-instance="padtc.dtInstance" class="table table-hover row-border hover">
	        <thead>
	            <tr>
	              <th>Activity Name</th>
	              <th>Start Date</th>
	              <th>End Date</th>
	              <th>Status</th>
	              <th>Actions</th>
	            </tr>
	          </thead>
	          <tbody>
	            <tr ng-repeat = "data in padtc.project_activities">
	              <td>@{{data.name}}</td>
	              <td>@{{data.start_date}}</td>
	              <td>@{{data.end_date}}</td>
	              <td>@{{data.status}}</td>
	              <td>
	                <button class="btn btn-warning" ng-click="padtc.edit($index, data)">
	                <i class="fa fa-edit"></i>
	                </button>
	                <button class="btn btn-danger" ng-click="padtc.delete($index ,data)">
	                   <i class="fa fa-trash-o"></i>
	                </button>
	              </td>
	            </tr>
	          </tbody>
	        </table>
	      </div>
	  </div>
	  <!-- End Activities -->
	</form>
@stop

@section('btn')
	<button class = "btn btn-success" ng-click="save('proj')">Save</button>
@stop

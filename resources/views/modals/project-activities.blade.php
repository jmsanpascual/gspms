@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Activity
@stop
@section('modal-content')
	<form role="form" id = "projForm">

		<input type ="hidden" ng-model = "submitData.projAct.id">
		<input type ="hidden" ng-model = "submitData.projAct.proj_id">
		<input type ="hidden" ng-model = "submitData.projAct.token">
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Activity Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.name" placeholder="Activity Name">
				</div>

			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Start Date</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.start_date" placeholder="Start Date">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">End Date</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.end_date" placeholder="End Date">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.projAct.description" placeholder="Description"></textarea>
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group" ng-if = "submitData.projAct.status_id">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Remarks</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.projAct.remarks" placeholder="Remarks"></textarea>
				</div>
			</div>
			</div>
		</div>
		<!-- <div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Status</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.projAct.status_id"
					ng-options = "c.id as c.name for c in submitData.status">
					</select>
				</div>
			</div>
			</div>
		</div> -->

	  <!-- End Activities -->
	</form>
@stop

@section('btn')
	<span ng-controller = "ActivityStatusCtrl as asc" ng-init = "asc.data.proj_id = submitData.projAct.proj_id;
	asc.data.act_id = submitData.projAct.id" style ="margin-right: 5px;" ng-if = "submitData.projAct.id">
		<span ng-if = "submitData.projAct.status_id == 1">
			<button class = "btn btn-primary" ng-click = "asc.approve()">Approve</button>
			<button class = "btn btn-danger" ng-click = "asc.disapprove()">Disapprove</button>
		</span>
		<button class = "btn btn-info" ng-click = "asc.completed()" ng-if = "submitData.projAct.status_id == 2">Completed</button>
	</span>
	<button class = "btn btn-success" ng-if = "submitData.projAct.status_id != 4" ng-click="save('projAct')">Save</button>
@stop

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
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.name">
				</div>
				
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Start Date</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.start_date">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">End Date</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.end_date">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
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
		</div>

	  <!-- End Activities -->
	</form>
@stop

@section('btn')
	<button class = "btn btn-success" ng-click="save('projAct')">Save</button>
@stop

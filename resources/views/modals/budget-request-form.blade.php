@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Budget Request
@stop
@section('modal-content')
	<form role="form" id = "brForm">
		<input type ="hidden" ng-model = "submitData.brequest.id">
		<input type ="hidden" ng-model = "submitData.brequest.token">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Amount</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.brequest.amount">
				</div>

			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Reason</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.brequest.reason"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Status</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.brequest.status_id" 
					ng-options = "c.id as c.name for c in submitData.status">
					</select>
				</div>	
			</div>
		</div>
	</form>
@stop

@section('btn')
	<button class = "btn btn-success" ng-click="save('brequest')">Save</button>
@stop

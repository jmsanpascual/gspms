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
		<!-- <div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Status</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.brequest.status_id" 
					ng-options = "c.id as c.name for c in submitData.status">
					</select>
				</div>	
			</div>
		</div> -->
		<div class = "form-group" ng-if = "submitData.brequest.status_id">
			<div class = "row">
				<label class = "form-label col-md-4">Remarks</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.brequest.remarks"></textarea>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	<span ng-controller = "BudgetRequestStatusCtrl as brsc" ng-init = "brsc.data.proj_id = submitData.brequest.proj_id;
	brsc.data.br_id = submitData.brequest.id" style ="margin-right: 5px;" ng-if = "submitData.brequest.id">
		<span ng-if = "submitData.brequest.status_id == 1">
			<button class = "btn btn-primary" ng-click = "brsc.approve()">Approve</button>
			<button class = "btn btn-danger" ng-click = "brsc.disapprove()">Disapprove</button>
		</span>
	</span>
	<button class = "btn btn-success" ng-if = "submitData.brequest.status_id != 2" ng-click="save('brequest')">Save</button>
@stop

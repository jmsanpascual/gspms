@extends('layouts.defaultModal')

@section('title')
    {{$title}}
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Category</label>
				<div class = "col-md-6">
                    <input type = "text" class = "form-control" ng-model = "submitData.expense.category"
					placeholder = "Enter Category ">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Amount</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.expense.amount"
					placeholder = "Enter Amount">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Remarks</label>
				<div class = "col-md-6">
					<textarea class = "form-control" ng-model = "submitData.expense.remarks"
					placeholder = "Enter Remarks"></textarea>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
    @if(Session::get('role') == config('constants.role_champion') || Session::get('role') == config('constants.role_finance'))
	<button class = "btn btn-success" ng-click="save('expense')">Save</button>
    @endif
@stop

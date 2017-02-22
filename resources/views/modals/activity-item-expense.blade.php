@extends('layouts.defaultModal')

@section('title')
    {{$title}}
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
        <div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Item Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.data.item_name"
					placeholder = "Enter Item Name">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" ng-model = "submitData.data.description"
					placeholder = "Enter Description"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Category</label>
				<div class = "col-md-6">
                    <select class = "form-control" ng-model = "submitData.data.project_expense_id"
    	            ng-options = "projectExpense.id as projectExpense.category for projectExpense in submitData.categories">
                    </select>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Price</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.data.price"
					placeholder = "Enter Price">
				</div>
			</div>
		</div>
        <div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.data.quantity"
					placeholder = "Enter Quantity">
				</div>
			</div>
		</div>
        <div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity Label</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.data.quantity_label"
					placeholder = "Enter Quantity Label">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Remarks</label>
				<div class = "col-md-6">
					<textarea class = "form-control" ng-model = "submitData.data.remarks"
					placeholder = "Enter Remarks"></textarea>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
    @if(Session::get('role') == config('constants.role_champion') || Session::get('role') == config('constants.role_finance')
      || Session::get('role') == config('constants.role_volunteer'))
	<button class = "btn btn-success" ng-click="save('data')">Save</button>
    @endif
@stop

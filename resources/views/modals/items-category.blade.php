@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Item/Expense
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<input type ="hidden" ng-model = "submitData.item_category.id">
		<input type ="hidden" ng-model = "submitData.item_category.token">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Category Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.item_category.name"
					placeholder = "Enter Category Name">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.item_category.description"
					placeholder = "Enter Description"></textarea>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	@if(Session::get('role') == config('constants.role_champion'))
	<button class = "btn btn-success" ng-click="save('item_category')">Save</button>
	@endif
@stop

@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Item/Expense
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<input type ="hidden" ng-model = "submitData.items.id">
		<input type ="hidden" ng-model = "submitData.items.token">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Item Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.item_name"
					placeholder = "Enter Item Name">
				</div>

			</div>
		</div>
		<div class = "form-group" ng-controller = "addItemCategory as aic" >
			<div class = "row">
				<label class = "form-label col-md-4">Category</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-init="submitData.items.category_id = submitData.category" ng-model = "submitData.items.category_id"
					ng-options = "c.id as c.name for c in submitData.categories">
					</select>
					<br>
					@if(Session::get('role') == config('constants.role_champion'))
					<button class = "btn btn-warning" ng-if = "submitData.items.category_id == 'NA'"
					ng-click = "aic.add_category()">Add Category</button>
					@endif
				</div>

			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.items.description"
					placeholder = "Enter Description"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.quantity"
					placeholder = "Enter Quantity">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Price</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.price"
					placeholder = "Enter Price">
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	@if(Session::get('role') == config('constants.role_champion'))
	<button class = "btn btn-success" ng-click="save('items')">Save</button>
	@endif
@stop

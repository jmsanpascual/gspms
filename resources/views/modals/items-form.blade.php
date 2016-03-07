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
					<input type = "text" class = "form-control" ng-model = "submitData.items.item_name">
				</div>

			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Category</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.items.category_id" 
					ng-options = "c.id as c.name for c in submitData.categories">
					<option>Not in the list</option>
					</select>
				</div>	
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.items.description"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.quantity">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Price</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.price">
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	<button class = "btn btn-success" ng-click="save('items')">Save</button>
@stop

@extends('layouts.defaultModal')

@section('title')
	Add Users
@stop
@section('modal-content')
	<form role="form" id = "userForm">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Username</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.username">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Password</label>
				<div class = "col-md-6">
					<input type = "password" ng-model = "submitData.password">
				</div>
			</div>
			
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Confirm Password</label>
				<div class = "col-md-6">
					<input type = "password" ng-model = "submitData.repassword">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">First Name</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.fname">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Middle Name</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.mname">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Last Name</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.lname">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Email</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.email">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Contact Number</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.cnum">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Birthdate</label>
				<div class = "col-md-6">
					<input type = "text" ng-model = "submitData.bdate">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-3">Address</label>
				<div class = "col-md-6">
					<textarea class = "form-control" ng-model = "submitData.address"></textarea>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	<button class = "btn btn-success" ng-click="save()">Save</button>
@stop

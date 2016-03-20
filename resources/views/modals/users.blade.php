@extends('layouts.defaultModal')

@section('title')
	@{{submitData.action}} User
@stop
@section('modal-content')
	<form role="form" id = "userForm">
		<h3>Account Information</h3>
		<hr>
		<input type ="hidden" ng-model = "submitData.users.id">
		<input type ="hidden" ng-model = "submitData.users.token">
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Username</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.username" placeholder = "Enter Username">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Password</label>
				<div class = "col-md-6">
					<input type = "password" class = "form-control" ng-model = "submitData.users.password" placeholder = "Enter Password">
				</div>
			</div>
			</div>
			
		</div>
		<div class = "form-group" ng-if = "!submitData.users.id">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Confirm Password</label>
				<div class = "col-md-6">
					<input type = "password" class = "form-control" ng-model = "submitData.users.repassword" placeholder = "Enter Confirm Password">
				</div>
			</div>
			</div>
		</div>

		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Account Type</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.users.selectedRole" 
					ng-options = "r.id as r.name for r in submitData.roles">
					</select>
				</div>
			</div>
			</div>
		</div>
		<h3>Personal Information</h3>
		<hr>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">First Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.fname"
					placeholder = "Enter First Name">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Middle Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.mname"
					placeholder = "Enter Middle Name">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Last Name</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.lname"
					placeholder = "Enter Last Name">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Email</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.email"
					placeholder = "Enter Email">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row ">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Contact Number</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.cnum"
					placeholder = "Enter Contact Number">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Birthdate</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.users.bdate"
					placeholder = "Enter Birthdate (mm/dd/yyyy)">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-3">Address</label>
				<div class = "col-md-5">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.users.address"
					placeholder = "Enter Address"></textarea>
				</div>
			</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	@if(Session::get('role') == config('constants.role_life'))
		<button class = "btn btn-success" ng-click="save()">Save</button>
	@endif
@stop

@extends('layouts.defaultModal')

@section('title')
  {{$action}} Resource Person
@stop

@section('modal-content')
  <form role="form" id = "resourcePersonForm">
    <h3>Resource Person Information</h3>
    <hr>
    <input type ="hidden" ng-model = "submitData.resourcePerson.id">
    <input type ="hidden" ng-model = "submitData.resourcePerson.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Username</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.username">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Password</label>
        <div class = "col-md-6">
          <input type = "password" ng-model = "submitData.resourcePerson.password">
        </div>
      </div>
      </div>

    </div>
    <div class = "form-group" ng-if = "!submitData.resourcePerson.id">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Confirm Password</label>
        <div class = "col-md-6">
          <input type = "password" ng-model = "submitData.resourcePerson.repassword">
        </div>
      </div>
      </div>
    </div>

    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Account Type</label>
        <div class = "col-md-6">
          <select class = "form-control" ng-model = "submitData.resourcePerson.selectedRole"
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
          <input type = "text" ng-model = "submitData.resourcePerson.fname">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Middle Name</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.mname">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Last Name</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.lname">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Email</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.email">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row ">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Contact Number</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.cnum">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Birthdate</label>
        <div class = "col-md-6">
          <input type = "text" ng-model = "submitData.resourcePerson.bdate">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Address</label>
        <div class = "col-md-5">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.resourcePerson.address"></textarea>
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

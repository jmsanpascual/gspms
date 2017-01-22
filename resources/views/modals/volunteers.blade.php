@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action }} Volunteer
@stop

@section('modal-content')
  <form role="form" id = "resourcePersonForm">
    <h3>Account Information</h3>
    <hr>
    <input type ="hidden" ng-model = "submitData.volunteer.id">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Username</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.volunteer.username" placeholder = "Enter Username">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Password</label>
        <div class = "col-md-8">
          <input type = "password" class = "form-control" ng-model = "submitData.volunteer.password" placeholder = "Enter Password">
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
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.volunteer.info.first_name" placeholder="First Name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Middle Name</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.volunteer.info.middle_name"
          placeholder = "Enter Middle Name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Last Name</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.volunteer.info.last_name"
          placeholder = "Enter Last Name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Email</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.volunteer.info.email"
          placeholder = "Enter Email">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row ">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Contact Number</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.volunteer.info.contact_num"
          placeholder = "Enter Contact Number">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Birthdate</label>
        <div class = "col-md-8">
          <input type = "date" class = "form-control" ng-model = "submitData.volunteer.info.birth_date" format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Address</label>
        <div class = "col-md-8">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.volunteer.info.address"
          placeholder = "Enter Address"></textarea>
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

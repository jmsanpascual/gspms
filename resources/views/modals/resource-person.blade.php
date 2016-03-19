@extends('layouts.defaultModal')

@section('title')
  @{{$action}} Resource Person Information
@stop

@section('modal-content')
  <form role="form" id = "resourcePersonForm">
    <input type ="hidden" ng-model = "submitData.resourcePerson.id">
    <input type ="hidden" ng-model = "submitData.resourcePerson.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">First Name</label>
        <div class = "col-md-6">
          <input class="form-control" type = "text" ng-model = "submitData.person.first_name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Last Name</label>
        <div class = "col-md-6">
          <input class="form-control" type = "text" ng-model = "submitData.person.last_name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Email</label>
        <div class = "col-md-6">
          <input class="form-control" type = "text" ng-model = "submitData.person.email">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Contact No</label>
        <div class = "col-md-6">
          <input class="form-control" type = "number" ng-model = "submitData.person.contact_num">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row ">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Address</label>
        <div class = "col-md-6">
          <input class="form-control" type = "text" ng-model = "submitData.person.address">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Profession</label>
        <div class = "col-md-6">
          <input class="form-control" type = "text" ng-model = "submitData.resourcePerson.profession">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-3">School</label>
          <div class = "col-md-6">
            <select class = "form-control" ng-init="submitData.resourcePerson.school = submitData.school" ng-model = "submitData.resourcePerson.school"
            ng-value="" ng-options = "school.name for school in submitData.schools">
            </select>
          </div>
        </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

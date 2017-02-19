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
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.person.first_name" placeholder="First Name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Last Name</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.person.last_name" placeholder="Last Name">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Email</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.person.email" placeholder="Email">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Contact</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.person.contact_num" placeholder="Contact">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row ">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Address</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.person.address" placeholder="Address">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Profession</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.resourcePerson.profession" placeholder="Profession">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-3">School</label>
          <div class = "col-md-8">
            <select class = "form-control" ng-init="submitData.resourcePerson.school = submitData.school" ng-model = "submitData.resourcePerson.school"
            ng-value="" ng-options = "school.name for school in submitData.schools">
            </select>
          </div>
        </div>
      </div>
    </div>
  </form>
  <hr>
  <div ng-if = "submitData.resourcePerson.id" ng-controller="SpecializationController as sc">
      <h3>Specialization</h3>
      <hr ng-init = 'sc.resource_person_id = submitData.projAct.id;sc.refresh()'>
      <button class = "btn btn-sm btn-success pull-right" ng-click = "sc.add()"> Add Specialization</button>
      <button class = "btn btn-sm btn-danger pull-right" ng-click = "sc.refresh()"> Refresh</button>

      <p class="text-danger"><strong>@{{ sc.message }}</strong></p>
      <br>
      <table datatable="ng" dt-options="sc.dtOptions" dt-columns="sc.dtColumnDefs" dt-instance="sc.dtInstance" class="table table-hover row-border hover">
      <thead>
          <tr>
            <th>Specialization</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr ng-repeat = "data in sc.activityitemexpense">
            <td>@{{data.item_name}}</td>
            <td>
              <button class="btn btn-warning btn-sm" ng-click="sc.edit(data)">
              <i class="fa fa-edit"></i>
              </button>
            </td>
          </tr>
        </tbody>
      </table>
  </div>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

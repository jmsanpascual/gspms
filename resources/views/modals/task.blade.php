@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Activity
@stop
@section('modal-content')
  <form role="form" id = "projForm">
    <input type ="hidden" ng-model = "submitData.task.activity.id">
    <input type ="hidden" ng-model = "submitData.task.activity.proj_id">
    <input type ="hidden" ng-model = "submitData.task.activity.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Activity Name</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.task.activity.name" placeholder="Activity Name">
        </div>

      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Start Date</label>
        <div class = "col-md-8">
          <input type = "date" class = "form-control" ng-model = "submitData.task.activity.start_date" placeholder="Start Date"
          format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">End Date</label>
        <div class = "col-md-8">
          <input type = "date" class = "form-control" ng-model = "submitData.task.activity.end_date" placeholder="End Date"
          format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-4">Description</label>
          <div class = "col-md-8">
            <textarea class = "form-control" style ="resize:none" ng-model = "submitData.task.activity.description" placeholder="Description"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class = "form-group" ng-if = "submitData.task.activity.status_id">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Remarks</label>
        <div class = "col-md-8">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.task.activity.remarks" placeholder="Remarks"></textarea>
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

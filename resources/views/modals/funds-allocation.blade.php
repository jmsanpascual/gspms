@extends('layouts.defaultModal')

@section('title')
  @{{$action}} Funds Allocation Information
@stop

@section('modal-content')
  <form role="form" id = "allocatedFundForm">
    <input type ="hidden" ng-model = "submitData.allocatedFund.id">
    <input type ="hidden" ng-model = "submitData.allocatedFund.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-3">Projects</label>
          <div class = "col-md-8">
            <select class = "form-control" ng-init="submitData.allocatedFund.project = submitData.project" ng-model = "submitData.allocatedFund.project"
            ng-value="" ng-options = "project.name for project in submitData.projects">
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Amount</label>
        <div class = "col-md-8">
          <input class="form-control" type = "text" ng-model = "submitData.allocatedFund.amount" placeholder="Amount">
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

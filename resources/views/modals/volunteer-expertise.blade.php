@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action }} Expertise
@stop

@section('modal-content')
  <form role="form" id = "resourcePersonForm">
    <input type ="hidden" ng-model = "submitData.expertise.id">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">Expertise</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.expertise.name" placeholder = "Enter Expertise">
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class = "btn btn-success" ng-click="save()">Save</button>
@stop

@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Volunteer
@stop

@section('modal-content')
  <form role="form" id="itemsForm">
    <input type="hidden" ng-model="submitData.task.id">
    <div class="form-group">
      <div class="row">
        <label class="form-label col-md-2">Expertise</label>
        <div class="col-md-10">
          <select class = "form-control" ng-model = "submitData.expertiseId"
            ng-change="submitData.onChange(submitData.expertiseId)"
            ng-options = "expertise.id as expertise.name for expertise in submitData.expertises">
          </select>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label class="form-label col-md-2">Volunteer</label>
        <div class="col-md-10">
          <select class = "form-control" ng-model = "submitData.task.user_id"
            ng-options = "volunteer.id as volunteer.info.first_name for volunteer in submitData.volunteers">
          </select>
        </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  @if(Session::get('role') == config('constants.role_champion'))
   <button class="btn btn-success" ng-if="submitData.task.id" ng-click="save('task')">Save</button>
  @endif
@stop

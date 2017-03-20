@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Milestone
@stop

@section('modal-content')
  <form role="form" id="itemsForm">
    <input type="hidden" ng-model="submitData.milestone.id">
    <div class="form-group">
      <div class="row">
        <label class="form-label col-md-2">Phase 1</label>
        <div class="col-md-10">
          <input type = "date" class = "form-control" ng-model = "submitData.milestone.phase_1" placeholder="Phase 1 Milestone"
          format-date>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label class="form-label col-md-2">Phase 2</label>
        <div class="col-md-10">
          <input type = "date" class = "form-control" ng-model = "submitData.milestone.phase_2" placeholder="Phase 2 Milestone"
          format-date>
        </div>
      </div>
    </div>
    <div class="form-group">
      <div class="row">
        <label class="form-label col-md-2">Phase 3</label>
        <div class="col-md-10">
          <input type = "date" class = "form-control" ng-model = "submitData.milestone.phase_3" placeholder="Phase 3 Milestone"
          format-date disabled>
        </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <button class="btn btn-success" ng-click="save('milestone')">Save</button>
@stop

@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Project
@stop
@section('modal-content')
  <form role="form" id = "projForm">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Project Name</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.name" placeholder="Project Name"
          disabled>
        </div>
        <label class = "form-label col-md-2">Project Name</label>
        <div class = "col-md-4">
            <input type = "text" class = "form-control" ng-model = "submitData.old_proj.name" placeholder="Project Name"
            disabled>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Program</label>
        <div class = "col-md-4">
            <select class = "form-control" ng-init="submitData.proj.program_id = submitData.program.id" ng-model = "submitData.proj.program_id"
            ng-options = "p.id as p.name for p in submitData.programs" disabled>
            </select>
        </div>
        <label class = "form-label col-md-2">Program</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.old_proj.program_id = submitData.program.id" ng-model = "submitData.old_proj.program_id"
          ng-options = "p.id as p.name for p in submitData.programs" disabled>
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Start Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.proj.start_date" placeholder="Start Date"
          disabled
          format-date>
        </div>
        <label class = "form-label col-md-2">Start Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.old_proj.start_date" placeholder="Start Date"
          disabled
          format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">End Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.proj.end_date" placeholder="End Date"
          disabled
          format-date>
        </div>
        <label class = "form-label col-md-2">End Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.old_proj.end_date" placeholder="End Date"
          disabled
          format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Partner Organization</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.partner_organization" placeholder="Partner Organization"
          disabled>
        </div>
        <label class = "form-label col-md-2">Partner Organization</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.old_proj.partner_organization" placeholder="Partner Organization"
          disabled>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Partner Community</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.partner_community" placeholder="Partner Community"
          disabled>
        </div>
        <label class = "form-label col-md-2">Partner Community</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.old_proj.partner_community" placeholder="Partner Community"
          disabled>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Total Budget</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.total_budget" placeholder="Total Budget"
          disabled>
        </div>
        <label class = "form-label col-md-2">Total Budget</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.old_proj.total_budget" placeholder="Total Budget"
          disabled>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Champion</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.champion_id = submitData.champion.id" ng-model = "submitData.proj.champion_id"
          ng-options = "c.id as c.name for c in submitData.champions" disabled>
          </select>
        </div>
        <label class = "form-label col-md-2">Champion</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.old_proj.champion_id = submitData.champion.id" ng-model = "submitData.proj.champion_id"
          ng-options = "c.id as c.name for c in submitData.champions" disabled>
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Resource Person</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.resource_person_id = submitData.resource.id" ng-model = "submitData.proj.resource_person_id"
          ng-options = "rp.id as rp.name for rp in submitData.resource_person" disabled>
          </select>
        </div>
        <label class = "form-label col-md-2">Resource Person</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.old_proj.resource_person_id = submitData.resource.id" ng-model = "submitData.proj.resource_person_id"
          ng-options = "rp.id as rp.name for rp in submitData.resource_person" disabled>
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group" ng-controller='DynamicElementCtrl'>

    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Remarks</label>
        <div class = "col-md-4">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.proj.remarks"
          placeholder = "Enter Remarks" disabled></textarea>
        </div>
        <label class = "form-label col-md-2">Remarks</label>
        <div class = "col-md-4">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.old_proj.remarks"
          placeholder = "Enter Remarks" disabled></textarea>
        </div>
      </div>
      </div>
    </div>
    <div class = "row">
      <div class = "col-md-12">
      <label class = "form-label col-md-2">Objective(s)</label>
      <div class = "col-md-4">
          <div class="objectives" ng-repeat='field in fields'>
            <input class="form-control" ng-model="submitData.proj.objective[$index]" type="text" ng-class="{'col-sm-12': $last}"
            placeholder="Objective @{{$index + 1}}" disabled>
          </div>
      </div>
      <label class = "form-label col-md-2">Objective(s)</label>
      <div class = "col-md-4">
          <div class="objectives" ng-repeat='field in fields'>
            <input class="form-control" ng-model="submitData.old_proj.objective[$index]" type="text" ng-class="{'col-sm-12': $last}"
            placeholder="Objective @{{$index + 1}}" disabled>
          </div>
      </div>
    </div>
  </div>
    </div>
</form>
@stop
@section('closeClass')
    btn-sm
@stop

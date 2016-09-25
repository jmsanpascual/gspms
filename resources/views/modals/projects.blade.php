@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Project
@stop
@section('modal-content')
  <form role="form" id = "projForm">
    <h3>Project Information</h3>
    <hr>
    <input type ="hidden" ng-model = "submitData.proj.id">
    <input type ="hidden" ng-model = "submitData.proj.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Project Name</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.name" placeholder="Project Name"
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
        </div>
        <label class = "form-label col-md-2">Program</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.program_id = submitData.program.id" ng-model = "submitData.proj.program_id"
          ng-options = "p.id as p.name for p in submitData.programs" ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
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
          <input type = "text" class = "form-control" ng-model = "submitData.proj.start_date" placeholder="Start Date"
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
        </div>
        <label class = "form-label col-md-2">End Date</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.end_date" placeholder="End Date"
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
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
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
        </div>
        <label class = "form-label col-md-2">Partner Community</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.partner_community" placeholder="Partner Community"
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <!-- <label class = "form-label col-md-2">Status</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-model = "submitData.proj.proj_status_id"
          ng-options = "c.id as c.name for c in submitData.status">
          </select>
        </div> -->
        <label class = "form-label col-md-2">Total Budget</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.total_budget" placeholder="Total Budget"
          ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
        </div>
      </div>
      </div>
    </div>

    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        @if(Session::get('role') != config('constants.role_champion'))
        <label class = "form-label col-md-2">Champion</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.champion_id = submitData.champion.id" ng-model = "submitData.proj.champion_id"
          ng-options = "c.id as c.name for c in submitData.champions" ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
          </select>
        </div>
        @endif
        <label class = "form-label col-md-2">Resource Person</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.resource_person_id = submitData.resource.id" ng-model = "submitData.proj.resource_person_id"
          ng-options = "rp.id as rp.name for rp in submitData.resource_person" ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group" ng-controller='DynamicElementCtrl'>
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Objective(s)</label>
        <div class = "col-md-10">
          <div class="objectives" ng-repeat='field in fields'>
            <input class="form-control" ng-model="submitData.proj.objective[$index]" type="text" ng-class="{'col-sm-12': $last}"
            placeholder="Objective @{{$index + 1}}" ng-disabled="{{Session::get('role') == config('constants.role_life')}}">
            <button class="btn btn-primary btn-sm" type="button" ng-click="removeField($index)"
            ng-if="{{Session::get('role') != config('constants.role_life')}}">
              <i class="fa fa-remove"></i>
            </button>
          </div>
        </div>
        <div class="col-sm-6" ng-class="{'col-sm-offset-2': fields.length}" ng-if="{{Session::get('role') != config('constants.role_life')}}">
          <button class="btn btn-primary btn-sm" type="button" ng-click="addField()">
            Add Objective
          </button>
        </div>
      </div>
    </div>
    <div class = "form-group" ng-if = "submitData.proj.proj_status_id">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Remarks</label>
        <div class = "col-md-10">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.proj.remarks"
          placeholder = "Enter Remarks"></textarea>
        </div>
      </div>
      </div>
    </div>
    </div>
    <!-- Activities -->
    <div ng-if = "submitData.proj.id">
    <h3>Activities</h3>
    <hr>
     <div ng-controller="projActDTCtrl as padtc" ng-init = 'proj_id = submitData.proj.id; padtc.getProjActivities(submitData.proj.id)'>
          @if(Session::get('role') == config('constants.role_champion'))
          <button class = "btn btn-success btn-sm pull-right" ng-click = "padtc.add()"
          ng-if = "submitData.proj.proj_status_id != 3"> Add Activity</button>
          @endif
          <button class = "btn btn-danger btn-sm pull-right" ng-click = "padtc.getProjActivities()"
          ng-if = "submitData.proj.proj_status_id != 3"> Refresh</button>
          <p class="text-danger"><strong>@{{ padtc.message }}</strong></p>
          <br>
          <table datatable="ng" dt-options="padtc.dtOptions" dt-columns="padtc.dtColumnDefs" dt-instance="padtc.dtInstance" class="table table-hover row-border hover">
          <thead>
              <tr>
                <th>Activity Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat = "data in padtc.project_activities">
                <td>@{{data.name}}</td>
                <td>@{{data.start_date}}</td>
                <td>@{{data.end_date}}</td>
                <td>@{{data.status}}</td>
                <td>
                  <span ng-if ="submitData.proj.proj_status_id != 3">
                    <button class="btn btn-warning btn-sm" ng-click="padtc.edit($index, data)">
                    <i class="fa fa-edit"></i>
                    </button>
                    @if(Session::get('role') == config('constants.role_champion'))
                    <button class="btn btn-danger btn-sm" ng-if = "data.status_id != 4" ng-click="padtc.delete($index ,data)">
                       <i class="fa fa-trash-o"></i>
                    </button>
                    @endif
                </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>

    <!-- End Activities -->
  </form>
@stop

@section('btn')

	<span ng-controller = "btnCtrl as btnc" ng-if = "submitData.proj.id"
	ng-init = 'btnc.data.proj_id = submitData.proj.id;'>
		<div class = "pull-left" ng-if = "submitData.proj.proj_status_id != 3">
			<button class = "btn btn-info btn-sm" ng-click="btnc.showItem()">
        @if(Session::get('role') == config('constants.role_life')
          || Session::get('role') == config('constants.role_head'))
        View Item/Expense
        @else
        Add Item/Expense
        @endif
      </button>
      <button class = "btn btn-warning btn-sm" ng-click="btnc.showReqBudget()">
        @if(Session::get('role') == config('constants.role_life')
          || Session::get('role') == config('constants.role_head'))
        View Budget Request
        @else
        Request Budget
        @endif
      </button>
      <a class = "btn btn-default btn-sm" target = "_blank" href = "{{asset('projects/report')}}/@{{submitData.proj.id}}">Progress Report</a>


      @if(Session::get('role') == config('constants.role_life')
        || Session::get('role') == config('constants.role_head'))
      <button class = "btn btn-primary btn-sm" ng-click="btnc.showAttachments()">
          View Attachments
      </button>
      @else
      <button class = "btn btn-primary btn-sm" ng-click="btnc.showAttachments()" ng-if = "submitData.proj.proj_status_id == 1">
          Add Attachments
      </button>
      @endif

		</div>
		@if(Session::get('role') == config('constants.role_life'))
		<span ng-if = "submitData.proj.proj_status_id == 2">
			<button class = "btn btn-primary btn-sm" ng-click = "btnc.approve()">Approve</button>
			<button class = "btn btn-danger btn-sm" ng-click = "btnc.disapprove()">Disapprove</button>
		</span>
		@endif
		@if(Session::get('role') == config('constants.role_champion') ||
		Session::get('role') == config('constants.role_exec'))
		<button class = "btn btn-info btn-sm" ng-click = "btnc.completed()" ng-if = "submitData.proj.proj_status_id == 1">Completed</button>
		@endif
	</span>
	@if(Session::get('role') == config('constants.role_champion') ||
		Session::get('role') == config('constants.role_exec') ||
    Session::get('role') == config('constants.role_life'))
	<button class = "btn btn-success btn-sm" ng-if = "submitData.proj.proj_status_id != 3" ng-click="save('proj')">Save</button>
	@endif
@stop

@section('closeClass')
    btn-sm
@stop

@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Activity
	<div class="progress" ng-controller="ActivityTaskController" ng-show="submitData.projAct.tasks && submitData.projAct.tasks.length">
		<div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
		aria-valuemin="0" aria-valuemax="100" ng-style="{width: percentage}">
			@{{ percentage }}
		</div>
	</div>
@stop
@section('modal-content')
	<form role="form" id = "projForm">
		<div ng-if = "submitData.projAct.id">
			<span ng-init="submitData.setItemData(submitData.projAct)"></span>
		</div>
		<input type ="hidden" ng-model = "submitData.projAct.id">
		<input type ="hidden" ng-model = "submitData.projAct.proj_id">
		<input type ="hidden" ng-model = "submitData.projAct.token">
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Activity Name</label>
				<div class = "col-md-8">
					<input type = "text" class = "form-control" ng-model = "submitData.projAct.name" placeholder="Activity Name">
				</div>

			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Start Date</label>
				<div class = "col-md-8">
					<input type = "date" class = "form-control" ng-model = "submitData.projAct.start_date" placeholder="Start Date"
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
					<input type = "date" class = "form-control" ng-model = "submitData.projAct.end_date" placeholder="End Date"
					format-date>
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Item Used</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-model = "submitData.projAct.item"
		            ng-options = "item as item.item_name + ' / per ' + item.quantity_label for item in submitData.items">
		            </select>
				</div>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Quantity (max: @{{ submitData.projAct.item.quantity }})</label>
				<div class = "col-md-6">
					<input type = "number" class = "form-control" ng-model = "submitData.projAct.quantity" placeholder="Quantity">
				</div>
			</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
					<label class = "form-label col-md-4">Description</label>
					<div class = "col-md-8">
						<textarea class = "form-control" style ="resize:none" ng-model = "submitData.projAct.description" placeholder="Description"></textarea>
					</div>
				</div>
			</div>
		</div>
		<div class = "form-group" ng-controller='DynamicElementTaskController'>
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Tasks</label>
				<div class = "col-md-8">
					<div class="objectives" ng-repeat='field in fields'>
            <input class="form-control" ng-model="submitData.projAct.tasks[$index].name"
							type="text" ng-class="{'col-sm-12': $last}"
            	placeholder="Task @{{$index + 1}}" >
						<button class="btn btn-primary btn-sm" type="button"
							ng-click="doneAndUndoneTasks(submitData.projAct.tasks[$index])">
              <i ng-class="{'fa fa-times': submitData.projAct.tasks[$index].done, 'fa fa-check': !submitData.projAct.tasks[$index].done}"></i>
            </button> &nbsp;
						<button class="btn btn-primary btn-sm" type="button"
							ng-click="assignTask(submitData.projAct.tasks[$index])">
              <i class="fa fa-user"></i>
            </button> &nbsp;
						<button class="btn btn-primary btn-sm" type="button"
							ng-click="addRemarks(submitData.projAct.tasks[$index])">
              <i class="fa fa-file-text" aria-hidden="true"></i>
            </button> &nbsp;
            <button class="btn btn-primary btn-sm" type="button" ng-click="removeField($index)">
              <i class="fa fa-trash-o"></i>
            </button>
          </div>
				</div>
				<div class="col-sm-6" ng-class="{'col-sm-offset-4': fields.length}">
          <button class="btn btn-primary btn-sm" type="button" ng-click="addField()">
            Add Task
          </button>
        </div>
			</div>
			</div>
		</div>
		<div class = "form-group" ng-if = "submitData.projAct.status_id">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Remarks</label>
				<div class = "col-md-8">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.projAct.remarks" placeholder="Remarks"></textarea>
				</div>
			</div>
			</div>
		</div>
		<!-- <div class = "form-group">
			<div class = "row">
				<div class = "col-md-12">
				<label class = "form-label col-md-4">Status</label>
				<div class = "col-md-8">
					<select class = "form-control" ng-model = "submitData.projAct.status_id"
					ng-options = "c.id as c.name for c in submitData.status">
					</select>
				</div>
			</div>
			</div>
		</div> -->

	  <!-- End Activities -->
	</form>
@stop

@section('btn')

	<span ng-controller = "ActivityStatusCtrl as asc" ng-init = "asc.data.proj_id = submitData.projAct.proj_id;
	asc.data.act_id = submitData.projAct.id" style ="margin-right: 5px;" ng-if = "submitData.projAct.id">
		@if(Session::get('role') == config('constants.role_life'))
		<span ng-if = "submitData.projAct.status_id == 1">
			<button class = "btn btn-primary" ng-click = "asc.approve()">Approve</button>
			<button class = "btn btn-danger" ng-click = "asc.disapprove()">Disapprove</button>

		</span>
		@endif
		@if(Session::get('role') == config('constants.role_champion'))
		<button class = "btn btn-info" ng-click = "asc.completed()" ng-if = "submitData.projAct.status_id == 2">Completed</button>
		@endif
	</span>


	@if(Session::get('role') == config('constants.role_champion'))
	<button class = "btn btn-success" ng-if = "submitData.projAct.status_id != 4" ng-click="save('projAct')">Save</button>
	@endif
@stop

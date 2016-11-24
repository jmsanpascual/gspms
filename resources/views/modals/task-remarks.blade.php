@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Task Remarks
@stop

@section('modal-content')
	<form role="form" id="itemsForm">
		<input type="hidden" ng-model="submitData.task.id">
		<div class="form-group">
			<div class="row">
				<label class="form-label col-md-2">Remarks</label>
				<div class="col-md-10">
					<textarea class="form-control" style="resize:none" placeholder="Enter Remarks"
            ng-model="submitData.task.remarks"></textarea>
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

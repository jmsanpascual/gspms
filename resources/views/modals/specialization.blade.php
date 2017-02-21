@extends('layouts.defaultModal')

@section('title')
    {{$title}}
@stop
@section('modal-content')
@{{submitData.data}}
	<form role="form" id = "itemsForm">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Program</label>
				<div class = "col-md-6">
                    <select class = "form-control" ng-model = "submitData.special.program_id"
    	            ng-options = "program.id as program.name for program in submitData.programs">
                    </select>
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
    @if(Session::get('role') == config('constants.role_champion') || Session::get('role') == config('constants.role_finance'))
	<button class = "btn btn-success" ng-click="save('special')">Save</button>
    @endif
@stop

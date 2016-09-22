@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Attachments
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<input type ="hidden" ng-model = "submitData.attachment.id">
		<input type ="hidden" ng-model = "submitData.attachment.token">
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Subject</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.attachment.subject"
					placeholder = "Enter Subject">
				</div>

			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.attachment.description"
					placeholder = "Enter Description"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
                <div class ="col-md-4">
                    <tmjupload class = "btn btn-primary" file-model = "submitData.attachment.files"
                    target = "#attachment-container" multiple = "true">Attach File</tmjupload>
                </div>
				<div class = "col-md-6" id = "attachment-container">
				</div>
			</div>
		</div>
	</form>
@stop

@section('btn')
	@if(Session::get('role') == config('constants.role_champion'))
	<button class = "btn btn-success" ng-click="save('attachment')">Save</button>
	@endif
@stop

@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action }} Attachments
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<input type ="hidden" ng-model = "submitData.attachment.id">
		<input type ="hidden" ng-model = "submitData.attachment.project_id">
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
		<div class = "form-group" ng-if ="submitData.action == 'Edit' ">
		  <div class = "row">
			<label class = "form-label col-md-4">Uploaded files</label>
			<div class = "col-md-6" ng-controller = "ProjectAttachmentFormController as pafc">
			  <div class = "pic-container" ng-repeat = "data in submitData.attachment.files">
				  <a type="button" class="btn btn-default" style = "position:absolute; bottom:0; right:0; margin:2px;z-index:10;"
				  ng-href ="@{{data.file}}" download="@{{data.name}}" title = "Download"><i class = "fa fa-download"></i></a>
			  <button type="button" class="close pull-right pic-container-close"
			  ng-click="pafc.delete(submitData.attachment.files, data, $index)">&times;</button>
        		<div class = "col-lg-3 col-md-3 col-sm-3 col-xs-3">
				  <img class = "pic-container-img img-responsive" ng-src = "@{{data.file}}"></img>
			    </div>
				<div class = "col-lg-9 col-md-9 col-sm-9 col-xs-9 pic-container-right">
			      <span style = "text-align: center;"> @{{data.name}} </span>
				  <div class="progress">
				    <div class="progress-bar" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
					style="width:100%;">100 %
				    </div>
				  </div>
			    </div>
			  </div>
			</div>
		  </div>
		</div>
		@if(Session::get('role') == config('constants.role_champion') ||
			Session::get('role') == config('constants.role_exec'))
		<hr>

		<div class = "form-group">
			<div class = "row">
                <div class ="col-md-4">
                    <tmjupload class = "btn btn-primary" file-model = "submitData.attachment.upload_files"
                    target = "#attachment-container" multiple = "true">Upload File</tmjupload>
                </div>
				<div class = "col-md-6" id = "attachment-container">
				</div>
			</div>
		</div>
		@endif
	</form>
@stop

@section('btn')
	@if(Session::get('role') == config('constants.role_champion'))
	<button class = "btn btn-success" ng-click="save('attachment', true)">Save</button>
	@endif
@stop

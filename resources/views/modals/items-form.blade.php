@extends('layouts.defaultModal')

@section('title')
	@{{ submitData.action}} Item/Expense
@stop
@section('modal-content')
	<form role="form" id = "itemsForm">
		<input type ="hidden" ng-model = "submitData.items.id">
		<input type ="hidden" ng-model = "submitData.items.token">
		<div class = "form-group" ng-controller="AddItemController as ai">
			<div class = "row">
				<label class = "form-label col-md-4">Item Name</label>
				<div class = "col-md-6">
					<select class = "form-control"
						ng-model="ai.itemName"
						ng-change="ai.storeItemName(ai.itemName)"
					ng-options = "item.name for item in ai.itemNames">
					</select>
					<br>
					@if(Session::get('role') == config('constants.role_champion'))
					<input class="form-control col-md-4" type="text"
						placeholder="Item Name"
						ng-model="ai.name"
						ng-change="ai.storeItemName({name: ai.name})"
						ng-if="ai.itemName.id == 'NA'">
					@endif
					<!-- <input type = "text" class = "form-control" ng-model = "submitData.items.item_name"
					placeholder = "Enter Item Name"> -->
				</div>
			</div>
		</div>
		<div class = "form-group" ng-controller = "addItemCategory as aic" >
			<div class = "row">
				<label class = "form-label col-md-4">Category</label>
				<div class = "col-md-6">
					<select class = "form-control" ng-init="submitData.items.category_id = submitData.category" ng-model = "submitData.items.category_id"
					ng-options = "c.id as c.name for c in submitData.categories">
					</select>
					<br>
					@if(Session::get('role') == config('constants.role_champion'))
					<button class = "btn btn-warning" ng-if = "submitData.items.category_id == 'NA'"
					ng-click = "aic.add_category()">Add Category</button>
					@endif
				</div>

			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Description</label>
				<div class = "col-md-6">
					<textarea class = "form-control" style ="resize:none" ng-model = "submitData.items.description"
					placeholder = "Enter Description"></textarea>
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.quantity"
					placeholder = "Enter Quantity">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Quantity Label</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.quantity_label"
					placeholder = "Enter Quantity Label e.g(kg, liter)">
				</div>
			</div>
		</div>
		<div class = "form-group">
			<div class = "row">
				<label class = "form-label col-md-4">Price</label>
				<div class = "col-md-6">
					<input type = "text" class = "form-control" ng-model = "submitData.items.price"
					placeholder = "Enter Price">
				</div>
			</div>
		</div>
		<div class = "form-group" ng-if ="submitData.action == 'Edit' ">
		  <div class = "row">
			<label class = "form-label col-md-4">Uploaded files</label>
			<div class = "col-md-6" ng-controller = "ProjectAttachmentFormController as pafc"
			ng-init = "pafc.showFiles(submitData.items.project_attachment_id)">
			  <div class = "pic-container" ng-repeat = "data in pafc.files">
				  <a type="button" class="btn btn-default" style = "position:absolute; bottom:0; right:0; margin:2px;z-index:10;"
				  ng-href ="@{{data.file}}" download="@{{data.name}}" title = "Download"><i class = "fa fa-download"></i></a>
			  <button type="button" class="close pull-right pic-container-close"
			  ng-click="pafc.delete(pafc.files, data, $index)">&times;</button>
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
		<!-- <hr>

		<div class = "form-group">
			<div class = "row">
                <div class ="col-md-4">
                    <tmjupload class = "btn btn-primary" file-model = "submitData.items.upload_files"
                    target = "#attachment-container" multiple = "true">Upload File</tmjupload>
                </div>
				<div class = "col-md-10 col-md-offset-1" id = "attachment-container">
				</div>
			</div>
		</div> -->
		@endif
	</form>
@stop

@section('btn')

	<span ng-controller="PriceRecommendationController as prc">
		<span class="pull-left">@{{ prc.priceRecommendation }}</span>
		<button class = "btn btn-info" ng-click="prc.getPriceRecommendation(submitData.items)">Average Price</button>
	</span>
	{{(Session::get('role') == config('constants.role_champion'))}}
	<button class = "btn btn-success" ng-click="save('items')" ng-if = "(!submitData.items.id && {{(int)(Session::get('role') == config('constants.role_champion'))}})
	|| (submitData.items.id && {{(int)(Session::get('role') == config('constants.role_finance'))}})">Save</button>
@stop

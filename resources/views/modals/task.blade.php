@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Activity
@stop
@section('modal-content')
  <form role="form" id = "projForm">
    <input type ="hidden" ng-model = "submitData.task.activity.id">
    <input type ="hidden" ng-model = "submitData.task.activity.proj_id">
    <input type ="hidden" ng-model = "submitData.task.activity.token">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Activity Name</label>
        <div class = "col-md-8">
          <input type = "text" class = "form-control" ng-model = "submitData.task.activity.name" placeholder="Activity Name">
        </div>

      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Start Date</label>
        <div class = "col-md-8">
          <input type = "date" class = "form-control" ng-model = "submitData.task.activity.start_date" placeholder="Start Date"
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
          <input type = "date" class = "form-control" ng-model = "submitData.task.activity.end_date" placeholder="End Date"
          format-date>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-4">Description</label>
          <div class = "col-md-8">
            <textarea class = "form-control" style ="resize:none" ng-model = "submitData.task.activity.description" placeholder="Description"></textarea>
          </div>
        </div>
      </div>
    </div>
    <div class = "form-group" ng-if = "submitData.task.activity.status_id">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-4">Remarks</label>
        <div class = "col-md-8">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.task.activity.remarks" placeholder="Remarks"></textarea>
        </div>
      </div>
      </div>
    </div>
  </form>
  <!-- Items -->
    <div ng-if = "submitData.task.activity.id" ng-controller="ActivityItemExpenseController as aiec">
        <h3>Item / Expense</h3>
        <hr ng-init = 'aiec.activity_id = submitData.task.activity.id;aiec.refresh()'>
        @if(Session::get('role') == config('constants.role_champion') || Session::get('role') == config('constants.role_volunteer') )
        <button class = "btn btn-sm btn-success pull-right" ng-click = "aiec.add()">Add Item/Expense</button>
        @endif
        <button class = "btn btn-sm btn-danger pull-right" ng-click = "aiec.refresh()" style="margin-right:5px">Refresh</button>

        <p class="text-danger"><strong>@{{ aiec.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="aiec.dtOptions" dt-columns="aiec.dtColumnDefs" dt-instance="aiec.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Item Name</th>
              <th>Category</th>
              <th>Price</th>
              <th>Quantity</th>
              <th>Total</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in aiec.activityitemexpense">
              <td>@{{data.item_name}}</td>
              <td>@{{data.category}}</td>
              <td>@{{data.price}}</td>
              <td>@{{data.quantity}}</td>
              <td>@{{data.price * data.quantity}}</td>
              <td>
              @if(Session::get('role') == config('constants.role_finance'))
                <button class="btn btn-warning btn-sm" ng-click="aiec.edit(data)">
                <i class="fa fa-edit"></i>
                </button>
              @endif
                @if(Session::get('role') == config('constants.role_champion'))
                <!-- <button class="btn btn-danger btn-sm" ng-click="ic.delete($index ,data)">
                   <i class="fa fa-trash-o"></i>
                </button> -->
                @endif
              </td>
            </tr>
          </tbody>
        </table>
    </div>
@stop

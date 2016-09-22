@extends('layouts.defaultModal')

@section('title')
	Project Attachment
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="ProjectAttachmentController as pac" ng-init = 'pac.proj_id = submitData.proj_id; pac.refresh()'>
        @if(Session::get('role') == config('constants.role_champion'))
        <button class = "btn btn-success pull-right" ng-click = "pac.add()"> Add Attachment</button>
        @endif
        <button class = "btn btn-danger pull-right" ng-click = "pac.refresh()"> Refresh</button>

        <p class="text-danger"><strong>@{{ pac.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="pac.dtOptions" dt-columns="pac.dtColumnDefs"
        dt-instance="pac.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Subject</th>
              <th>Attached By</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in pac.attachments">
              <td>@{{data.subject }}</td>
              <td>@{{data.name}}</td>
              <td>
                <a class="btn btn-default btn-sm" href="@{{data.link}}" download>
                  <i class="fa fa-download"></i>
                </a>
                <button class="btn btn-warning btn-sm" ng-click="pac.edit($index, data)">
                <i class="fa fa-edit"></i>
                </button>
                @if(Session::get('role') == config('constants.role_champion'))
                <button class="btn btn-danger" ng-click="pac.delete($index ,data)">
                   <i class="fa fa-trash-o"></i>
                </button>
                @endif
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

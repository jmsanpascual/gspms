@extends('layouts.defaultModal')

@section('title')
	Related Projects
@stop
@section('modal-content')
	<!-- DTable -->
	 <div ng-controller="ProjectRelatedController as prc" ng-init = 'prc.proj_id = submitData.proj_id; prc.refresh()'>
        <button class = "btn btn-danger pull-right" ng-click = "prc.refresh()">Refresh</button>

        <p class="text-danger"><strong>@{{ prc.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="prc.dtOptions" dt-columns="prc.dtColumnDefs"
        dt-instance="prc.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Project Title</th>
              <th>Total Budget</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in prc.related">
              <td>@{{data.name }}</td>
              <td>@{{data.total_budget}}</td>
              <td>
                <button class="btn btn-warning" title = "Edit" ng-click="prc.edit($index, data)">
                <i class="fa fa-pencil"></i>
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
	  <!-- End DTable -->
@stop

@extends('layouts.index')

@section('content')

  <div class="row" ng-app="volunteer">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Volunteer</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="VolunteerController as vc">
                <button class="btn btn-success btn-sm pull-right" ng-click="vc.add()">Add Volunteer</button>
                <button class="btn btn-danger btn-sm pull-right" ng-click="vc.getVolunteers()" style="margin-right:5px">Refresh</button>
                <div>
                  <p class="text-danger"><strong ng-bind="vc.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="vc.dtOptions" dt-columns="vc.dtColumns"
                  dt-instance="vc.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Username</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "volunteer in vc.volunteers">
                        <td ng-bind="volunteer.username"></td>
                        <td ng-bind="volunteer.info.first_name"></td>
                        <td ng-bind="volunteer.info.last_name"></td>
                        <td ng-bind="volunteer.info.email"></td>
                        <td>
                          <button class="btn btn-warning btn-sm" ng-click="vc.edit($index, volunteer)">
                            <i class="fa fa-edit"></i>
                          </button>
                          <!-- <button class="btn btn-danger btn-sm" ng-click="vc.remove($index, volunteer)">
                            <i class="fa fa-trash-o"></i>
                          </button> -->
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('scripts')
{!! HTML::script('js/volunteer/volunteer.module.js') !!}
{!! HTML::script('js/volunteer/volunteer.controller.js') !!}
{!! HTML::script('js/volunteer/volunteer.factory.js') !!}
@endsection

@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Accounts</a>
              </li>
              <li>View List</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">View List</h1>
      </div>
  </div>
  <div class="row" ng-app = "users">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Users</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="userDTCtrl as showCase">
                  @if(Session::get('role') == config('constants.role_life'))
                    <button class = "btn btn-success btn-sm pull-right" ng-click = "showCase.add()"> Add User</button>
                  @endif
                   <button class = "btn btn-danger btn-sm pull-right" ng-click = "showCase.refresh()"> Refresh</button>
                <div>
                  <p class="text-danger"><strong ng-bind="showCase.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="showCase.dtOptions" dt-columns="showCase.dtColumnDefs" dt-instance="showCase.dtInstance" class="table table-hover row-border hover">
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
                    <tr ng-repeat = "person in showCase.persons">
                      <td ng-bind="person.username"></td>
                      <td ng-bind="person.fname"></td>
                      <td ng-bind="person.lname"></td>
                      <td ng-bind="person.email"></td>
                      <td>
                        <button class="btn btn-warning btn-sm" ng-click="showCase.edit($index, person)"
                        ng-if="person.selectedRole == 4">
                        <i class="fa fa-edit"></i>
                        </button>
                        @if(Session::get('role') == config('constants.role_life'))
                        <button class="btn btn-danger btn-sm" ng-click="showCase.delete($index ,person)">
                           <i class="fa fa-trash-o"></i>
                        </button>
                        @endif
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
{!! HTML::script('js/controllers/user.js') !!}
{!! HTML::script('js/services/roles.js') !!}
@endsection

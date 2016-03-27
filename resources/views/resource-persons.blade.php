@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Resource Person</a>
              </li>
              <li>View List</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">View List</h1>
      </div>
  </div>
  <div class="row" ng-app="resourcePersons">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Resource Persons</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="resourcePersonDTCtrl as rp">
                <button class="btn btn-success pull-right" ng-click="rp.add()">Add Resource Person</button>
                <button class = "btn btn-danger pull-right" ng-click = "rp.getResourcePersons()"> Refresh</button>
                <div>
                  <p class="text-danger"><strong ng-bind="rp.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="rp.dtOptions" dt-columns="rp.dtColumns"
                  dt-instance="rp.dtInstance" class="table table-hover row-border hover">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Profession</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>School</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr ng-repeat = "person in rp.persons">
                        <td ng-bind="person.name"></td>
                        <td ng-bind="person.profession"></td>
                        <td ng-bind="person.email"></td>
                        <td ng-bind="person.contact_num"></td>
                        <td ng-bind="person.school"></td>
                        <td>
                          <button class="btn btn-warning btn-sm" ng-click="rp.edit($index, person)">
                          <i class="fa fa-edit"></i>
                          </button>
                          <button class="btn btn-danger btn-sm" ng-click="rp.delete($index, person)">
                             <i class="fa fa-trash-o"></i>
                          </button>
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
{!! HTML::script('js/resource-person/services/school.js') !!}
{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/resource-person/controllers/resource-person.js') !!}
@endsection

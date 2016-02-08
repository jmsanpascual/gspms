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

  <div class="row" ng-app = "showcase.bindAngularDirective">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Users</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body" ng-controller="BindAngularDirectiveCtrl as showCase">
                <div ng-controller="BindAngularDirectiveCtrl as showCase">
                  <p class="text-danger"><strong>@{{ showCase.message }}</strong></p>
                  <br>
                  <table datatable="" dt-options="showCase.dtOptions" dt-columns="showCase.dtColumns" dt-instance="showCase.dtInstance" class="table table-hover row-border hover">
                  </table>
                </div>
              </div>
          </div>
      </div>
  </div>

@endsection

@section('scripts')
{!! HTML::script('js/controllers/user.js') !!}
@endsection

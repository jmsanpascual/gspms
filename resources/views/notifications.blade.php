@extends('layouts.index')

@section('css')
{!! HTML::style('js/upload/upload.css'); !!}
@endsection

@section('app')
ng-app='notification'
@endsection

@section('content')
  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Notifications</a>
              </li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Notification Lists</h1>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Notification Lists</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">

                <div ng-controller="NotificationListController as nc">
                  <button class = "btn btn-danger btn-sm pull-right" ng-click = "nc.getNotif()">Refresh</button>
                  <p class="text-danger"><strong ng-bind="nc.message"></strong></p>
                  <br>
                  <table datatable="ng" dt-options="nc.dtOptions" dt-columns="nc.dtColumnDefs" dt-instance="nc.dtInstance" class="table table-hover row-border hover">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Message</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr ng-repeat = "notif in nc.notifications">
                      <td ng-bind="notif.title"></td>
                      <td ng-bind="notif.text"></td>
                      <td ng-bind="notif.created_at"></td>
                      <td>@{{ (notif.read_flag) ? 'Read' : 'Unread'}}</td>
                      <td>
                        <button class="btn btn-warning btn-sm" ng-click="nc.showNotif(notif)">
                        <i class="fa fa-eye"></i>
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
@parent
{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/services/project-status.js') !!}
{!! HTML::script('js/services/program.js') !!}
{!! HTML::script('js/services/project-activities.js') !!}
{!! HTML::script('js/services/user.js') !!}
{!! HTML::script('js/services/project.js') !!}
{!! HTML::script('js/services/activity-status.js') !!}
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/project-activities.js') !!}
{!! HTML::script('js/services/budget-request.js') !!}
{!! HTML::script('js/services/budget-request-status.js') !!}
{!! HTML::script('js/controllers/budget-request.js') !!}
{!! HTML::script('js/services/item.js') !!}
{!! HTML::script('js/services/categories.js') !!}
{!! HTML::script('js/controllers/dynamic-element.js') !!}
{!! HTML::script('js/controllers/item.js') !!}

<!-- Attachment -->
{!! HTML::script('js/project-attachments/project-attachment.module.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.controller.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.service.js') !!}
<!-- End Attachment  -->
<!-- Related Project  -->
{!! HTML::script('js/project-related/project-related.module.js') !!}
{!! HTML::script('js/project-related/project-related.controller.js') !!}
<!-- End Related Project  -->
<!-- UPLOAD -->
{!! HTML::script('js/upload/upload.js') !!}
<!-- END UPLOAD -->
<!-- Toast -->
{!! HTML::script('js/others/toast.js') !!}
<!-- End Toast -->
@endsection

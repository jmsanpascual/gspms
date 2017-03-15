@extends('layouts.index')

@section('css')
<base href = "/gspms/public/projects/">
{!! HTML::style('js/upload/upload.css'); !!}
@endsection

@section('app')
ng-app='dashboard'
@endsection

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Home</a>
              </li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Welcome {{ Session::get('first_name') }}!</h1>
          <br><br><br>
          <h4> Here are the list of reminders for you as of today, <b>{{ date('F d, Y')}}</b>.</h4>
          <hr>
      </div>
  </div>
  <div ng-controller ="projDTCtrl as pc">
  <!-- TO DOS -->
  @include('dashboard.todo')
  <!-- End TO DOS -->
  <!-- DELAYED PROJECTS -->
  @include('dashboard.delayed-projects')
  <!-- End DELAYED PROJECTS -->
  <!-- UPCOMING -->
  @include('dashboard.upcoming')
  <!-- End UPCOMING -->
  </div>
@endsection

@section('scripts')
@parent
<!-- DASHBOARD  -->
{!! HTML::script('js/dashboard/dashboard.module.js') !!}
{!! HTML::script('js/dashboard/todo.controller.js') !!}
{!! HTML::script('js/dashboard/upcoming.controller.js') !!}
{!! HTML::script('js/dashboard/delayed-projects.controller.js') !!}
<!-- {!! HTML::script('js/dashboard/factories/champion-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/program-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/resource-person-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/status-manager.factory.js') !!} -->

<!-- END Dashboard -->
@endsection

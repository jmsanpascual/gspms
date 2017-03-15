@extends('layouts.index')

@section('css')
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
                <a href="#">Dashboard</a>
              </li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Dashboard</h1>
      </div>
  </div>
  <!-- TO DOS -->
  @include('dashboard.todo')
  <!-- End TO DOS -->
  <!-- DELAYED PROJECTS -->
  @include('dashboard.delayed-projects')
  <!-- End DELAYED PROJECTS -->
  <!-- UPCOMING -->
  include('dashboard.upcoming')
  <!-- End UPCOMING -->
@endsection

@section('scripts')
@parent
<!-- DASHBOARD  -->
{!! HTML::script('js/dashboard/dashboard.module.js') !!}
{!! HTML::script('js/dashboard/todo.controller.js') !!}
{!! HTML::script('js/dashboard/upcoming.controller.js') !!}
{!! HTML::script('js/dashboard/delayed-projects.controller.js') !!}
{!! HTML::script('js/dashboard/dashboard.run.js') !!}
{!! HTML::script('js/dashboard/factories/champion-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/program-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/resource-person-manager.factory.js') !!}
{!! HTML::script('js/dashboard/factories/status-manager.factory.js') !!}

<!-- END Dashboard -->

{!! HTML::script('js/activity-dependencies/activity-dependencies.module.js') !!}
{!! HTML::script('js/activity-dependencies/phase.factory.js') !!}
{!! HTML::script('js/activity-dependencies/progress-calculator.factory.js') !!}
{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/volunteer/volunteer.module.js') !!}
{!! HTML::script('js/volunteer/volunteer.factory.js') !!}
{!! HTML::script('js/volunteer/expertise/expertise.factory.js') !!}


{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/services/project-status.js') !!}
{!! HTML::script('js/services/program.js') !!}
{!! HTML::script('js/services/project.js') !!}

{!! HTML::script('js/services/project-activities.js') !!}
{!! HTML::script('js/services/user.js') !!}
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
{!! HTML::script('js/controllers/project.js') !!}


<!-- Attachment -->
{!! HTML::script('js/project-attachments/project-attachment.module.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.controller.js') !!}
{!! HTML::script('js/project-attachments/project-attachment.factory.js') !!}
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

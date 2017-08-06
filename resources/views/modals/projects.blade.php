@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Project
@stop
@section('modal-content')

  <form role="form" id = "projForm">
    <h3>Project Information</h3>
    <hr>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Project Name</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.name" placeholder="Project Name"
          ng-disabled="{{(json_encode(Session::get('role') == config('constants.role_life')))}}  || submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}" >
        </div>
        <label class = "form-label col-md-2">Program</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.program_id = submitData.program.id; submitData.getResourcePerson(submitData.proj.program_id, submitData)" ng-model = "submitData.proj.program_id"
          ng-options = "p.id as p.name for p in submitData.programs" ng-change ="submitData.getResourcePerson(submitData.proj.program_id, submitData)"
          ng-disabled="{{json_encode(Session::get('role') == config('constants.role_life'))}} || submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}" >
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Start Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.proj.start_date" placeholder="Start Date"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}"
         date-format>
        </div>
        <label class = "form-label col-md-2">End Date</label>
        <div class = "col-md-4">
          <input type = "date" class = "form-control" ng-model = "submitData.proj.end_date" placeholder="End Date"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}"
          date-format>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Partner Organization</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.partner_organization" placeholder="Partner Organization"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}">
        </div>
        <label class = "form-label col-md-2">Partner Community</label>
        <div class = "col-md-4">
          <input type = "text" class = "form-control" ng-model = "submitData.proj.partner_community" placeholder="Partner Community"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}">
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
            <label class = "form-label col-md-2">Initial Budget</label>
            <div class = "col-md-4">
                <input type = "text" class = "form-control" style="text-align:right" ng-model = "submitData.proj.total_budget" placeholder="Total Budget"
                ng-disabled="{{json_encode(Session::get('role') == config('constants.role_life'))}} || submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}}
                || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}" >
            </div>
        </div>
      </div>
    </div>
    <div class = "form-group" ng-controller = "ProjBudgetCtrl as pbc" ng-init = "pbc.getTotalExpense(submitData.proj.id); pbc.getTotalBudget(submitData.proj.id)">
      <div class = "row">
        <div class = "col-md-12">
            <label class = "form-label col-md-2">Total Budget</label>
            <div class = "col-md-4">
                <input type = "text" class = "form-control" style="text-align:right" disabled value = "@{{ (+submitData.proj.total_budget + +pbc.budget.total).toFixed(2) }}"
                placeholder="Total Budget" disabled>
            </div>
            <span ng-if = "pbc.expense.total && submitData.proj.id" >
                <label class = "form-label col-md-2">Remaining Budget</label>
                <div class = "col-md-4">
                    <input type = "text" class = "form-control" placeholder="Total Remaining Budget" style="text-align:right"
                    disabled value = "@{{ (+submitData.proj.total_budget + +pbc.budget.total - pbc.expense.total).toFixed(2)}}">
                </div>
            </span>
      </div>
      </div>
    </div>

    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        @if(Session::get('role') != config('constants.role_champion'))
        <label class = "form-label col-md-2">Champion</label>
        <div class = "col-md-4">
          <select class = "form-control" ng-init="submitData.proj.champion_id = submitData.champion.id" ng-model = "submitData.proj.champion_id"
          ng-options = "c.id as c.name for c in submitData.champions"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}">
          </select>
        </div>
        @endif
        <label class = "form-label col-md-2">Resource Person</label>
        <div class = "col-md-4" ng-init = "submitData.proj.resource_person_id = submitData.resource.id || 'NA'">
          <select class = "form-control" ng-model = "submitData.proj.resource_person_id"
          ng-options = "rp.id as rp.name for rp in submitData.resource_person"
          ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{json_encode(Session::get('role') == config('constants.role_life'))}}
          || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}">
          </select>
        </div>
      </div>
      </div>
    </div>
    <div class = "form-group" ng-controller='DynamicElementCtrl'>
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Objective(s)</label>
        <div class = "col-md-10">
          <div class="objectives" ng-repeat='field in fields'>
            <input class="form-control" ng-model="submitData.proj.objective[$index]" type="text" ng-class="{'col-sm-12': $last}"
            placeholder="Objective @{{$index + 1}}"
            ng-disabled="submitData.proj.proj_status_id == {{config('constants.proj_status_approved')}} || submitData.proj.proj_status_id == {{config('constants.proj_status_ongoing')}} || {{ json_encode(Session::get('role') == config('constants.role_life'))}}
            || submitData.proj.proj_status_id == {{config('constants.proj_status_completed')}}">
            <button class="btn btn-primary btn-sm" type="button" ng-click="removeField($index)"
            ng-if="submitData.proj.proj_status_id != {{config('constants.proj_status_approved')}} &&
                submitData.proj.proj_status_id != {{config('constants.proj_status_ongoing')}} && {{json_encode(Session::get('role') != config('constants.role_life'))}}">
              <i class="fa fa-remove"></i>
            </button
          </div>
        </div>
        <div class="col-sm-6" ng-class="{'col-sm-offset-2': fields.length}"
        ng-if="submitData.proj.proj_status_id != {{config('constants.proj_status_approved')}} &&
            submitData.proj.proj_status_id != {{config('constants.proj_status_ongoing')}} && {{json_encode(Session::get('role') != config('constants.role_life'))}}">
          <button class="btn btn-primary btn-sm" type="button" ng-click="addField()">
            Add Objective
          </button>
        </div>
      </div>
    </div>
    </div>
    <div class = "form-group" ng-if = "submitData.proj.proj_status_id">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-2">Remarks</label>
        <div class = "col-md-10">
          <textarea class = "form-control" style ="resize:none" ng-model = "submitData.proj.remarks"
          placeholder = "Enter Remarks"></textarea>
        </div>
      </div>
      </div>
    </div>

    <!-- Expense -->
    <div ng-if = "submitData.proj.id" ng-controller="ProjectExpenseController as pec">
        <h3>Project Expense</h3>
        <hr ng-init = 'pec.proj_id = submitData.proj.id;submitData.refreshExpense = pec.refresh;pec.refresh();'>
        @if(Session::get('role') == config('constants.role_champion'))
        <button class = "btn btn-sm btn-success pull-right" ng-if = "submitData.proj.proj_status_id != 3"
        ng-click = "pec.add()"> Add Project Expense</button>
        @endif
        <button class = "btn btn-sm btn-danger pull-right" ng-click = "pec.refresh()"
        ng-if = "submitData.proj.proj_status_id != 3" style="margin-right:5px;"> Refresh</button>

        <p class="text-danger"><strong>@{{ pec.message }}</strong></p>
        <br>
        <table datatable="ng" dt-options="pec.dtOptions" dt-columns="pec.dtColumnDefs" dt-instance="pec.dtInstance" class="table table-hover row-border hover">
        <thead>
            <tr>
              <th>Category</th>
              <th>Amount</th>
              <th>Remaining Amount</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat = "data in pec.projectexpense">
              <td>@{{data.category}}</td>
              <td>@{{data.amount | number}}</td>
              <td>@{{data.remaining_amount.toFixed(2) | number}}</td>
              <td>
              @if(Session::get('role') == config('constants.role_finance'))
                <button ng-if = "submitData.proj.proj_status_id != 3" class="btn btn-warning btn-sm" ng-click="pec.edit(data)">
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
    <!-- End Expense -->
    <hr>
    <!-- Activities -->
    <div ng-if = "submitData.proj.id" ng-controller="projActDTCtrl as padtc"
      ng-init="padtc.activate(submitData.proj)">

        <h3 ng-init="mc.activate(submitData.proj, padtc)" ng-controller="MilestoneController as mc">Activities
          @if(Session::get('role') == config('constants.role_life'))
          <button class="btn btn-primary btn-sm" ng-click="mc.add()">
            Add Milestone
          </button>
          @endif
          @if(Session::get('role') == config('constants.role_champion') || Session::get('role') == config('constants.role_life'))
          <button class="btn btn-success btn-sm" ng-click="mc.view()">
            Milestone
          </button>
          @endif
        </h3>

        <div class="progress" ng-if="padtc.project_activities.length"
          ng-mouseover="padtc.phaseProgress.hide = false"
          ng-mouseout="padtc.phaseProgress.hide = true">

          <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="70"
          aria-valuemin="0" aria-valuemax="100" ng-style="{width: padtc.percent.value + '%'}">
            @{{ padtc.percent.value }}%
          </div>

        </div>

        <!-- <div class="progress" ng-hide="padtc.phaseProgress.hide"> -->

          <!-- ng-style="{width: phase.percent + '%'}" -->
          <!-- <div class="progress-bar" aria-valuemin="0" aria-valuemax="33"
            ng-repeat="phase in padtc.phasesPercentages"
            ng-style="{width: '33.33%'}"
            ng-class="phase.class">
            <span class="sr-only">
              @{{ phase.percent }}% Complete Phase @{{ phase.id }}
            </span> -->
              <!-- Phase @{{ phase.id }} @ @{{ phase.percent }}%  -->
              <!-- @{{ phase.daysLeft }} Days Left @ @{{ phase.percent }}% / 33.33% -->
          <!-- </div>
        </div> -->

        <hr>
        <div ng-init = 'proj_id = submitData.proj.id; padtc.getProjActivities(submitData.proj.id);
            padtc.refreshExpense = submitData.refreshExpense;'>
          @if(Session::get('role') == config('constants.role_champion'))
          <button class = "btn btn-success btn-sm pull-right" ng-click = "padtc.add()"
          ng-if = "submitData.proj.proj_status_id != 3"> Add Activity</button>
          @endif
          <button class = "btn btn-danger btn-sm pull-right" ng-click = "padtc.getProjActivities(submitData.proj.id)"
          ng-if = "submitData.proj.proj_status_id != 3" style="margin-right:5px;"> Refresh</button>
          <p class="text-danger"><strong>@{{ padtc.message }}</strong></p>
          <br>
          <table datatable="ng" dt-options="padtc.dtOptions" dt-columns="padtc.dtColumnDefs" dt-instance="padtc.dtInstance" class="table table-hover row-border hover">
          <thead>
              <tr>
                <th>Activity Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Status</th>
                <th>Phase</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr ng-repeat = "data in padtc.project_activities">
                <td>@{{data.name}}</td>
                <td>@{{data.start_date}}</td>
                <td>@{{data.end_date}}</td>
                <td>@{{data.status}}</td>
                <td>@{{data.phase_id}}</td>
                <td>
                  <span ng-if ="submitData.proj.proj_status_id != 3">
                    <button class="btn btn-warning btn-sm" ng-click="padtc.edit($index, data)">
                    <i class="fa fa-file-text"></i>
                    </button>
                    @if(Session::get('role') == config('constants.role_champion'))
                    <!-- <button class="btn btn-danger btn-sm" ng-if = "data.status_id != 4" ng-click="padtc.delete($index ,data)">
                       <i class="fa fa-trash-o"></i>
                    </button> -->
                    @endif
                </span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
    </div>
    <!-- End Activities -->
  </form>
@stop

@section('btn')

	<span ng-controller = "btnCtrl as btnc" ng-if = "submitData.proj.id"
	ng-init = 'btnc.data.proj_id = submitData.proj.id; btnc.proj = submitData.proj'>
		<div class = "pull-left">


        @if(Session::get('role') == config('constants.role_life')
          || Session::get('role') == config('constants.role_finance'))
           <button class = "btn btn-warning btn-sm" ng-click="btnc.showReqBudget()">
            View Budget Request
        </button>
        @elseif(Session::get('role') == config('constants.role_champion'))
         <button class = "btn btn-warning btn-sm" ng-click="btnc.showReqBudget()"
         ng-if = "submitData.proj.proj_status_id != 3">
            Request Budget
        </button>
        @endif

        @if(Session::get('role') == config('constants.role_life')
          || Session::get('role') == config('constants.role_head'))
        <div class="dropdown" style = "display: inline !important" ng-if = "submitData.proj.proj_status_id == 3 || submitData.proj.proj_status_id == 1 || submitData.proj.proj_status_id == 5">
          <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown">View Reports
          <span class="caret"></span></button>
          <ul class="dropdown-menu">
        <li>
          <a target="_blank" href="{{asset('projects/report/progress')}}/@{{submitData.proj.id}}">Project Charter Report</a></li>
            <li>
              <a target="_blank" href="{{asset('projects/report/status')}}/@{{submitData.proj.id}}"
              ng-if = "submitData.proj.proj_status_id != 3">Progress Report</a></li>

            <li ng-if = "submitData.proj.proj_status_id == 3"><a target="_blank" href="{{asset('projects/report/completion')}}/@{{submitData.proj.id}}">
              Project Completion Report</a></li>
            <!-- <li><a target="_blank" href="{{asset('projects/report/summary')}}/@{{submitData.proj.id}}">Project Summary Report</a></li> -->
            <li><a target="_blank" href="{{asset('projects/report/expense')}}/@{{submitData.proj.id}}">Expense Report</a></li>
          </ul>
        </div>
      <!-- <a class = "btn btn-default btn-sm" target = "_blank" href = "{{asset('projects/report')}}/@{{submitData.proj.id}}">View Progress Report</a> -->
      @endif

      <button class = "btn btn-success btn-sm" ng-click = "btnc.showRelated()">View Related Projects</button>

      <!-- @if(Session::get('role') == config('constants.role_champion'))
        <button class = "btn btn-primary btn-sm" ng-click="btnc.showAttachments()" ng-if = "submitData.proj.proj_status_id == 1 || submitData.proj.proj_status_id == 5">
            Add Attachments
        </button>
      @elseif(Session::get('role') == config('constants.role_finance'))
      <button class = "btn btn-primary btn-sm" ng-click="btnc.showAttachments()">
          View Attachments
      </button>
      @endif -->
  </div>
		@if(Session::get('role') == config('constants.role_life'))
		<span ng-if = "submitData.proj.proj_status_id == 6">
			<button class = "btn btn-primary btn-sm" ng-click = "btnc.approve()">Approve</button>
			<button class = "btn btn-danger btn-sm" ng-click = "btnc.disapprove()">Disapprove</button>
		</span>
		@endif

        @if(Session::get('role') == config('constants.role_finance'))
		<span ng-if = "submitData.proj.proj_status_id == 2">
			<button class = "btn btn-primary btn-sm" ng-click = "btnc.approveByFinance()">Approve</button>
			<button class = "btn btn-danger btn-sm" ng-click = "btnc.disapproveByFinance()">Disapprove</button>
		</span>
		@endif

		@if(Session::get('role') == config('constants.role_champion') ||
		Session::get('role') == config('constants.role_exec'))
		<button class = "btn btn-info btn-sm" ng-click = "btnc.completed()" ng-if = "submitData.proj.proj_status_id == 1">Completed</button>
		@endif
	</span>
	@if(Session::get('role') == config('constants.role_champion') ||
		Session::get('role') == config('constants.role_exec'))
	<button class = "btn btn-success btn-sm" ng-if = "submitData.proj.proj_status_id != 3" ng-click="save('proj')">Save</button>
	@endif
@stop

@section('closeClass')
    btn-sm
@stop

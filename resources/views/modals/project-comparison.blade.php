@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Project
@stop
@section('modal-content')
  <h3>Project Information</h3>
  <hr>
  <table class = "table table-bordered table-hover table-striped">
    <thead>
      <tr>
        <th>Fields</th>
        <th>Original</th>
        <th>Comparison</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Project Name</td>
        <td ng-bind= "submitData.old_proj.name"></td>
        <td ng-bind= "submitData.proj.name"></td>
      </tr>
      <tr>
        <td>Program</td>
        <td ng-bind= "submitData.old_proj.program_name"></td>
        <td ng-bind= "submitData.proj.program_name"></td>
      </tr>
      <tr>
        <td>Partner Organization</td>
        <td ng-bind= "submitData.old_proj.partner_organization"></td>
        <td ng-bind= "submitData.proj.partner_organization"></td>
      </tr>
      <tr>
        <td>Partner Community</td>
        <td ng-bind= "submitData.old_proj.partner_community"></td>
        <td ng-bind= "submitData.proj.partner_community"></td>
      </tr>
      <tr>
        <td>Total Work Done</td>
        <td ng-bind= "submitData.old_proj.duration"></td>
        <td ng-bind= "submitData.proj.duration"></td>
      </tr>
      <tr>
        <td>Initial Budget</td>
        <td ng-bind= "submitData.old_proj.total_budget"  style="text-align:right"></td>
        <td ng-bind= "submitData.proj.total_budget"  style="text-align:right"></td>
      </tr>
      <tr>
        <td>Total Budget</td>
        <td ng-bind= "submitData.old_proj.current_budget"  style="text-align:right"></td>
        <td ng-bind= "submitData.proj.current_budget"  style="text-align:right"></td>
      </tr>
      <tr>
        <td>Champion</td>
        <td ng-bind= "submitData.old_proj.champion_name"></td>
        <td ng-bind= "submitData.proj.champion_name"></td>
      </tr>
      <tr>
        <td>Remarks</td>
        <td ng-bind= "submitData.old_proj.remarks"></td>
        <td ng-bind= "submitData.proj.remarks"></td>
      </tr>
      <tr>
        <td>Objectives</td>
        <td>
          <ul>
            <li ng-repeat = "objective in submitData.old_proj.objective">@{{objective}} </li>
          </ul>
        </td>
        <td>
          <ul>
            <li ng-repeat = "objective in submitData.proj.objective">@{{objective}} </li>
          </ul>
        </td>
      </tr>
      <tr>
      </tr>
    </tbody>
  </table>
  <h3>Project Expense</h3>
  <hr>
  <table class = "table table-bordered">
    <tr>
      <th>Original</th>
      <th>Comparison</th>
    </tr>
    <tr>
      <td>
        <table class = "table table-bordered">
          <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Remaining Amount</th>
          </tr>
          <tr ng-repeat="data in submitData.projectexpense">
            <td>@{{data.category}}</td>
            <td  style="text-align:right">@{{data.amount | number}}</td>
            <td  style="text-align:right">@{{data.remaining_amount | number}}</td>
          </tr>
          <tr ng-if="submitData.projectexpense.length == 0">
            <td colspan="3">No record(s) found</td>
          </tr>
        </table>
      </td>
      <td>
        <table class = "table table-bordered">
          <tr>
            <th>Category</th>
            <th>Amount</th>
            <th>Remaining Amount</th>
          </tr>
          <tr ng-repeat="data in submitData.proj.projectexpense">
            <td>@{{data.category}}</td>
            <td  style="text-align:right">@{{data.amount | number}}</td>
            <td  style="text-align:right">@{{data.remaining_amount | number}}</td>
          </tr>
          <tr ng-if="submitData.proj.projectexpense.length == 0">
            <td colspan="3">No record(s) found</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
  <h3>Activities</h3>
  <hr>
  <table class = "table table-bordered">
    <tr>
      <th>Original</th>
      <th>Comparison</th>
    </tr>
    <tr>
      <td ng-controller="projActDTCtrl as padtc">
        <table class = "table table-bordered" ng-init="padtc.getProjActivities(submitData.old_proj.id)">
          <tr>
            <th>Activity Name</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
          <tr ng-repeat = "data in padtc.project_activities">
           <td>@{{data.name}}</td>
           <td>@{{data.start_date}}</td>
           <td>@{{data.end_date}}</td>
         </tr>
          <tr ng-if="padtc.project_activities.length == 0">
            <td colspan="3">No record(s) found</td>
          </tr>
        </table>
      </td>
      <td ng-controller="projActDTCtrl as padtc">
        <table class = "table table-bordered" ng-init="padtc.getProjActivities(submitData.proj.id)">
          <tr>
            <th>Activity Name</th>
            <th>Start Date</th>
            <th>End Date</th>
          </tr>
          <tr ng-repeat = "data in padtc.project_activities">
           <td>@{{data.name}}</td>
           <td>@{{data.start_date}}</td>
           <td>@{{data.end_date}}</td>
         </tr>
          <tr ng-if="padtc.project_activities.length == 0">
            <td colspan="3">No record(s) found</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
@stop
@section('closeClass')
    btn-sm
@stop

@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Project
@stop
@section('modal-content')
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
        <td>Start Date</td>
        <td ng-bind= "submitData.old_proj.start_date"></td>
        <td ng-bind= "submitData.proj.start_date"></td>
      </tr>
      <tr>
        <td>End Date</td>
        <td ng-bind= "submitData.old_proj.end_date"></td>
        <td ng-bind= "submitData.proj.end_date"></td>
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
        <td>Total Budget</td>
        <td ng-bind= "submitData.old_proj.total_budget"></td>
        <td ng-bind= "submitData.proj.total_budget"></td>
      </tr>
      <tr>
        <td>Champion</td>
        <td ng-bind= "submitData.old_proj.champion_name"></td>
        <td ng-bind= "submitData.proj.champion_name"></td>
      </tr>
      <tr>
        <td>Resource Person</td>
        <td ng-bind= "submitData.old_proj.resource_person_name"></td>
        <td ng-bind= "submitData.proj.resource_person_name"></td> 
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
    </tbody>
  </table>
@stop
@section('closeClass')
    btn-sm
@stop

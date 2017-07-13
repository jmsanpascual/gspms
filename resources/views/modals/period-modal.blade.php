@extends('layouts.defaultModal')

@section('title')
  @{{$action}} Project Period Range
@stop

@section('modal-content')
  <form role="form" id = "allocatedFundForm">
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
          <label class = "form-label col-md-3">From</label>
          <div class = "col-md-8">
            <select class = "form-control"  ng-model = "submitData.period.from"
            ng-value="" ng-options = "date for (index, date) in submitData.dates | orderBy">
            </select>
          </div>
        </div>
      </div>
    </div>
    <div class = "form-group">
      <div class = "row">
        <div class = "col-md-12">
        <label class = "form-label col-md-3">To</label>
        <div class = "col-md-8">
          <select class = "form-control" ng-model = "submitData.period.to"
          ng-value="" ng-options = "date for (index, date) in submitData.dates | orderBy">
          </select>
        </div>
      </div>
      </div>
    </div>
  </form>
@stop

@section('btn')
  <a class="btn btn-success" target="_blank" style="margin-right:5px;color:white;"
  href="{{ asset('projects/report/summary') }}?from=@{{ submitData.period.from }}&to=@{{ submitData.period.to }}" >
      Generate Report
  </a>
@stop

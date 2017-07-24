@extends('layouts.index')

@section('content')
  <div class="row" ng-app="funds">
      @if(Session::get('role') == config('constants.role_head'))
      <div class="col-md-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Add Funds</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>

              <div class="panel-body"  ng-controller="FundCtrl as fc">
                <form class="form-horizontal" ng-submit='fc.add(fc.fund)'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Schools</label>
                        <div class="col-sm-8">
                          <select class="form-control" ng-model="fc.fund.school"
                            ng-options="school.name for school in fc.schools track by school.id">
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="number" placeholder="Amount" ng-model="fc.fund.amount" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Received Date</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="date" placeholder="Received Date" ng-model="fc.fund.received_date" required>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-offset-3 col-sm-6">
                        <button class="btn btn-sm btn-info" type="submit">
                          Save
                        </button>
                      </div>
                    </div>
                </form>
              </div>
          </div>

      </div>
      @endif

      <div class="col-md-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">View Funds</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>

              <div class="panel-body"  ng-controller="ViewFundCtrl as vfc">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Year</label>
                        <div class="col-sm-8">
                          <select class="form-control" ng-model="vfc.fund"
                            ng-options="fund.year for fund in vfc.funds track by fund.id">
                          </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Total Fund</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="decimal" placeholder="Total Fund" ng-model="vfc.fund.amount | number" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Remaining Fund</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="decimal" placeholder="Remaining Fund" ng-model="vfc.fund.remaining_funds | number" readonly>
                        </div>
                    </div>
                </form>
              </div>
          </div>

      </div>
  </div>

@endsection

@section('scripts')
{!! HTML::script('js/fund/fund.js') !!}
{!! HTML::script('js/fund/view-fund.controller.js') !!}
{!! HTML::script('js/others/toast.js') !!}
{!! HTML::script('js/school/school.module.js') !!}
{!! HTML::script('js/school/school.factory.js') !!}
@endsection

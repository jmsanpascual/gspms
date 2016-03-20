@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Funds</a>
              </li>
              <li>Funds</li>
          </ul>
          <!--breadcrumbs end -->
          <!-- <h1 class="h1">View List</h1> -->
      </div>
  </div>
  <div class="row" ng-app="funds">
      <div class="col-md-12">

          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Funds</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>

              <div class="panel-body"  ng-controller="FundCtrl as fund">
                <form class="form-horizontal" ng-submit='fund.add(fund.capital)'>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Amount</label>
                        <div class="col-sm-8">
                          <input class="form-control" type="text" placeholder="Amount" ng-model="fund.capital.amount">
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
  </div>

@endsection

@section('scripts')
{!! HTML::script('js/fund/fund.js') !!}
@endsection

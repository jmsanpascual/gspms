@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Projects</a>
              </li>
              <li>Allocate Budget</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Project Budget Allocation Info</h1>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Project Budget Allocation Form</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">
                  <form class="form-horizontal">
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Project Title</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Project Title">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Program Name</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Program Name">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Allocated Budget</label>
                          <div class="col-sm-6">
                              <input type="number" class="form-control" placeholder="Allocated Budget">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Date</label>
                          <div class="col-sm-6">
                              <input type="date" class="form-control">
                          </div>
                      </div>
                      <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-6">
                            <button type="submit" class="btn btn-primary btn-sm">
                              Submit
                            </buttom>
                        </div>
                      </div>
                  </form>


              </div>
          </div>
      </div>
  </div>

@endsection

{!! HTML::script('js/funds-allocation/module.js') !!}
{!! HTML::script('js/funds-allocation/controllers/funds-allocation.js') !!}
{!! HTML::script('js/funds-allocation/services/funds-allocation.js') !!}

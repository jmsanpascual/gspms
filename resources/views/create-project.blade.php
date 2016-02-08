@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Projects</a>
              </li>
              <li>Create Proposal</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Project Proposal Info</h1>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Project Proposal Form</h3>
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
                            <select class="form-control input-sm">
                                <option value="">Regulatory Compliance</option>
                                <option value="">Green Building</option>
                                <option value="">Carbon Neutrality</option>
                                <option value="">Occupational Safety and Health</option>
                                <option value="">Disaster Risk Reduction Management-Emergency Preparedness</option>
                                <option value="">Biodiversity</option>
                                <option value="">Water Resources Management</option>
                                <option value="">Green Procurement</option>
                                <option value="">Data Management</option>
                                <option value="">Environmental Education</option>
                            </select>
                          </div>
                      </div>
                      <!-- If User is Executive Committee show this -->
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Champion</label>
                          <div class="col-sm-6">
                            <select class="form-control input-sm">
                                <option value="">Champion User 1</option>
                                <option value="">Champion User 2</option>
                                <option value="">Carbon User 3</option>
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Start Date</label>
                          <div class="col-sm-6">
                              <input type="date" class="form-control" placeholder="Start Date">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">End Date</label>
                          <div class="col-sm-6">
                              <input type="date" class="form-control" placeholder="End Date">
                          </div>
                      </div>
                      <!-- This should be a dynamic value -->
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Status</label>
                          <div class="col-sm-6">
                            <select class="form-control input-sm">
                                <option value="">For Approval</option>
                                <option value="">On-Going</option>
                                <option value="">Completed</option>
                            </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Partner Organization</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Partner Organization">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Partner Community</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Partner Community">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Budget</label>
                          <div class="col-sm-6">
                              <input type="number" class="form-control" placeholder="Budget">
                          </div>
                      </div>
                      <div class="form-group" ng-app='dynamicElement' ng-controller='DynamicElementCtrl' ng-cloak>
                          <label class="col-sm-3 control-label" >Objective(s)</label>
                          <div class="col-sm-6">
                              <input ng-repeat='field in fields' type="text" class="form-control" ng-class="{'col-sm-12': $last}"
                              placeholder="Objective @{{field.id}}" style='margin-bottom: 15px;'>
                          </div>
                          <div class="col-sm-6" ng-class="{'col-sm-offset-3': fields.length}">
                            <button class="btn btn-primary btn-sm" type="button" ng-click="addField()">
                              Add Objective
                            </button>
                            <button class="btn btn-primary btn-sm" type="button" ng-click="removeField()" ng-show='fields.length'>
                              Remove Objective
                            </button>
                          </div>
                      </div>
                      <!-- Not sure what this is for (Optional Input)-->
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Resource Person</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Resource Person">
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

@section('scripts')
{!! HTML::script('js/controllers/dynamic-element.js') !!}
@endsection

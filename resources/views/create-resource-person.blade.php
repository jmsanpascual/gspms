@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Resource Person</a>
              </li>
              <li>Create Resource Person</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Resource Person Info</h1>
      </div>
  </div>

  <div class="row" ng-app='resourcePerson' ng-controller='CreateResourcePersonCtrl as crp'>
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Resource Person Form</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">
                  <form class="form-horizontal" ng-submit='crp.saveResourcePerson()'>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">First Name</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.person.first_name" type="text" class="form-control" placeholder="First Name" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Last Name</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.person.last_name" type="text" class="form-control" placeholder="Last Name" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Email</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.person.email" type="email" class="form-control" placeholder="Email" required>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Contact No</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.person.contact_num" type="phone" class="form-control" placeholder="Contact No">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Address</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.person.address" type="text" class="form-control" placeholder="Address">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Profession</label>
                          <div class="col-sm-6">
                              <input ng-model="crp.profession" type="text" class="form-control" placeholder="Profession">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">School</label>
                          <div class="col-sm-6">
                            <select class="form-control input-sm" ng-model='crp.school'
                             ng-options="school.name for school in crp.schools">
                            </select>
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
{!! HTML::script('js/resource-person/services/school.js') !!}
{!! HTML::script('js/resource-person/services/resource-person.js') !!}
{!! HTML::script('js/resource-person/controllers/create-resource-person.js') !!}
@endsection

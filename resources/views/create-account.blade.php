@extends('layouts.index')

@section('content')

  <div class="row">
      <div class="col-md-12">
          <!--breadcrumbs start -->
          <ul class="breadcrumb">
              <li>
                <a href="#">Accounts</a>
              </li>
              <li>Create Account</li>
          </ul>
          <!--breadcrumbs end -->
          <h1 class="h1">Account Information</h1>
      </div>
  </div>

  <div class="row">
      <div class="col-md-12">
          <div class="panel panel-default">
              <div class="panel-heading">
                  <h3 class="panel-title">Account Form</h3>
                  <div class="actions pull-right">
                      <i class="fa fa-chevron-down"></i>
                      <i class="fa fa-times"></i>
                  </div>
              </div>
              <div class="panel-body">
                  <form class="form-horizontal">
                      <div class="form-group">
                          <label class="col-sm-3 control-label">First Name</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="First Name">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Last Name</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Last Name">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Username</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Username">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Password</label>
                          <div class="col-sm-6">
                              <input type="password" class="form-control" placeholder="Password">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Email</label>
                          <div class="col-sm-6">
                              <input type="email" class="form-control" placeholder="Email">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Contact No</label>
                          <div class="col-sm-6">
                              <input type="tel" class="form-control" placeholder="Contact No">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Address</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" placeholder="Address">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Account Type</label>
                          <div class="col-sm-6">
                            <select class="form-control input-sm">
                                <option value="">D.L.S.P. Head</option>
                                <option value="">Executive Committee</option>
                                <option value="">Champion</option>
                                <option value="">Finance Employee</option>
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

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">To Do's</h3>
                <div class="actions pull-right">
                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="panel-body">

              <div ng-controller="TodoController as tc">
                <button class = "btn btn-danger btn-sm pull-right" ng-click = "tc.get()">Refresh</button>
                <p class="text-danger"><strong ng-bind="nc.message"></strong></p>
                <br>
                <table datatable="ng" dt-options="tc.dtOptions" dt-columns="tc.dtColumnDefs" dt-instance="tc.dtInstance" class="table table-hover row-border hover">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat = "todo in tc.todos">
                    <td ng-bind="todo.title"></td>
                    <td ng-bind="todo.text"></td>
                    <td ng-bind="todo.created_at"></td>
                    <td>
                      <button class="btn btn-warning btn-sm" ng-click="tc.show(todo)">
                      <i class="fa fa-eye"></i>
                      </button>
                    </td>
                  </tr>
                </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
</div>
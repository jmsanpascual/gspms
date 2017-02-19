
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Upcoming Tasks</h3>
                <div class="actions pull-right">
                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="panel-body">

              <div ng-controller="UpcomingController as uc">
                <button class = "btn btn-danger btn-sm pull-right" ng-click = "uc.getNotif()">Refresh</button>
                <p class="text-danger"><strong ng-bind="uc.message"></strong></p>
                <br>
                <table datatable="ng" dt-options="uc.dtOptions" dt-columns="uc.dtColumnDefs" dt-instauce="uc.dtInstauce" class="table table-hover row-border hover">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr ng-repeat = "notif in uc.notifications">
                    <td ng-bind="notif.title"></td>
                    <td ng-bind="notif.text"></td>
                    <td ng-bind="notif.created_at"></td>
                    <td>@{{ (notif.read_flag) ? 'Read' : 'Unread'}}</td>
                    <td>
                      <button class="btn btn-warning btn-sm" ng-click="uc.showNotif(notif)">
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

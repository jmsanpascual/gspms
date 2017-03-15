<!--logo start-->
<div class="brand">
    <a href="/gspms/public/welcome" class="logo"><span>De La</span> Salle</a>
</div>
<!--logo end-->
<div class="toggle-navigation toggle-left">
    <button type="button" class="btn btn-default" id="toggle-left" data-toggle="tooltip" data-placement="right" title="Toggle Navigation">
        <i class="fa fa-bars"></i>
    </button>
</div>
<div class="user-nav" ng-controller ="projDTCtrl as pc">
    <ul ng-controller = "NotificationController as nc">
        @if(Session::get('role') != config('constants.role_volunteer'))
        <li class="dropdown messages">
            <span class="badge badge-danager animated bounceIn" id="new-messages" ng-if = "nc.count > 0"
                ng-bind="nc.count"></span>
            <button type="button" class="btn btn-default dropdown-toggle options" id="toggle-mail" data-toggle="dropdown" aria-expanded="true">
                <i class="fa fa-envelope"></i>
            </button>
            <ul class="dropdown-menu alert animated fadeInDown">
                <li>
                    <h1>You have <strong ng-bind="nc.count"></strong> new messages</h1>
                </li>
                <li ng-repeat = "notif in nc.notifications">
                    <a href="javascript:;" ng-click ="nc.read(pc.edit($index, notif), notif, $index);">
                        <div class="message-info">
                            <span class="sender" style = "font-weight:bold;" ng-bind="::notif.title"></span>
                            <span class="time" ng-bind="::notif.notif_created"></span>
                            <div class="message-content" ng-bind="::notif.text"></div>
                        </div>
                    </a>
                </li>

                <li>
                    <a href="/gspms/public/notifications/lists">Check all messages <i class="fa fa-angle-right"></i></a>
                </li>
            </ul>

        </li>
        @endif
        <li class="profile-photo">
            <img src="{{ asset('img/avatar.png') }}" alt="" class="img-circle">
        </li>
        <li class="dropdown settings">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
          {{ Session::get('first_name') . ' ' . Session::get('middle_name') . ' ' .
          Session::get('last_name') }}
          <i class="fa fa-angle-down"></i>
        </a>
            <ul class="dropdown-menu animated fadeInDown">
                <li>
                    <a href="{{ URL::to('logout') }}"><i class="fa fa-power-off"></i> Logout</a>
                </li>
            </ul>
        </li>
    </ul>
</div>

@section('scripts')
    @parent
    {!! HTML::script('js/notifications/notification.module.js') !!}
    {!! HTML::script('js/notifications/controllers/notification.controller.js') !!}
    {!! HTML::script('js/notifications/factories/notification.factory.js') !!}
    {!! HTML::script('js/notifications/factories/notification-manager.factory.js') !!}
@stop

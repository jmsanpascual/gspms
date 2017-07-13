
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Project Status</h3>
                <div class="actions pull-right">
                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="panel-body">
                <!-- <img src ="generated/test.png" width="600" height="400"> -->
                <canvas id="doughnut1" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
    <div class="col-md-6" ng-controller = "ActivityChartController as pcc">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Activities Status</h3>
                <div class="actions pull-right">
                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="panel-body">
                <canvas id="doughnut2" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
</div>
<div class = "row">
    <div class="col-md-6" ng-controller = "ProjectChartController as pcc">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Project Programs</h3>
                <div class="actions pull-right">
                    <i class="fa fa-chevron-down"></i>
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="panel-body">
                <!-- <img src ="generated/test.png" width="600" height="400"> -->
                <canvas id="doughnut3" width="600" height="400"></canvas>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    @parent
    {!! HTML::script('js/dashboard-head/project-chart/project-chart.controller.js') !!}
    {!! HTML::script('js/dashboard-head/project-chart/project-chart-manager.factory.js') !!}
    {!! HTML::script('js/dashboard-head/activity-chart/activity-chart.controller.js') !!}
    {!! HTML::script('js/dashboard-head/activity-chart/activity-chart-manager.factory.js') !!}
@endsection

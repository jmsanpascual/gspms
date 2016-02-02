<!DOCTYPE html>
<html ng-app = "showcase.bindAngularDirective">
    <head>
        <title>Life Sys</title>
        {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
        {!! HTML::style('css/bootstrap/css/bootstrap-theme.min.css'); !!}
        {!! HTML::style('css/font-awesome.min.css'); !!}
        {!! HTML::style('css/angular-datatable.css') !!}
        {!! HTML::style('js/others/datatable/media/css/jquery.dataTables.min.css'); !!}
    </head>
    <body>
        <div class="container">
            <div class="content">
                <div ng-controller="BindAngularDirectiveCtrl as showCase">
                <p class="text-danger"><strong>@{{ showCase.message }}</strong></p>
                <br>
                <table datatable="" dt-options="showCase.dtOptions" dt-columns="showCase.dtColumns" dt-instance="showCase.dtInstance" class="table table-hover row-border hover">
                </table>
            </div>
            </div>
        </div>
    </body>
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('js/others/datatable/media/js/jquery.dataTables.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular/angular.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular-resource/angular-resource.min.js') !!}
    {!! HTML::script('js/vendor/node_modules/angular-ui-bootstrap/ui-bootstrap-tpls.js') !!}
    {!! HTML::script('js/others/angular-datatable.min.js') !!}
    {!! HTML::script('js/controllers/user.js') !!}
    
    
</html>

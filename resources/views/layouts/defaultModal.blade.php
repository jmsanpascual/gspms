<div class="modal-header">
  <h3 class="modal-title">@yield('title')</h3>
</div>
<div class="modal-body">
		@yield('modal-content')
</div>
<div class="modal-footer">
  @yield('btn')
  <button class="btn btn-warning" type="button" ng-click="close()">Close</button>
</div>
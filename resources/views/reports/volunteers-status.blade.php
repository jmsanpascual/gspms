<html>
<head>
	  <title>
	  Lasallian Institute for the Environment
	  </title>

    {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
</head>
<center>
<style>
	td:nth-child(1) {
		font-weight: bold;
	}
	td {
		padding : 10px;
	}
	h2{
		color: white;
	}
	.sub-title {
		text-align : center !important;
		width : 100% !important;
	}
	h4{
		font-style: italic;
	}
	.objectives{
		font-weight: normal !important;
		font-size: 16px;
		position: relative;
	}
	table thead th {
		text-align:center;
		width : 100%;
		/*background-color: #2dcc70 !important;*/
		padding : 5px;
	}
  table {
    /*background-color: red!important;*/
  }
  td {
    /*background-color: blue!important;*/
  }
  .task-container {
    margin-left:20px!important;
  }
</style>
<body>
<table width = "100%">
	<tr>
    <td colspan="4" style="font-weight:normal;">
      <center>
      	<h5><img src="{{asset('img/life_logo.png')}}" style="width:55px"> Lasallian Institute for the Environment</h5>
      </center>
    </td>
  </tr>
	<tr>
		<td colspan= "4" class = "sub-title">
			<h1><b>VOLUNTEERS STATUS REPORT</b></h1>
    </td>
	</tr>
  @foreach($volunteers as $index => $volunteer)
		@if(count($volunteer->tasks) != 0)
	  <tr>
		<td colspan = "4">
			<table class = "table table-bordered" width="100%">
				<tr>
					<th style="padding:10px;">Volunteer</th>
					<th style="padding:10px;">Project</th>
					<th style="padding:10px;">Tasks</th>
					<th style="padding:10px;">Completed</th>
				</tr>
				@foreach($volunteer->tasks as $index2 => $task)
				<tr>
					<td>
						@if($index2 == 0)
						{{$volunteer->info['first_name']}} {{$volunteer->info['last_name']}}
						@endif
					</td>
					<td>
						@if($index2 == 0)
						{{$task->activity['project']['name']}}
						@endif
					</td>
					<td>{{$task->name}}</td>
					<td style="text-align:center;">{{$task->done ? '&#10004;' : '&#x2717;'}}</td>
				</tr>
				@endforeach
			</table>
		</td>
	  </tr>
		@endif
  @endforeach
	<tr>
    <?php $user = auth()->user()->infos[0];
          $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
          ?>
    <td colspan="4" style="text-align:right">{{'Generated By: ' . ucwords($fullName) . ' | Dated: ' . date('F d, Y')}}</td>
  </tr>
</table>
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
</body>
</html>

<html>
<head>
	<img src="{{asset('img/logo.png')}}">
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
<table width = "100%">
	<tr>
		<td colspan= "4" class = "sub-title">
			<h1><b>BUDGET / EXPENSE REPORT</b></h1>
      <br>
      (Period: {{date('F Y', strtotime($proj->start_date))}} - {{date('F Y', strtotime($proj->end_date))}})
    </td>
	</tr>
  <tr>
    <td colspan="4"><h4><u><b>Project Completed</b></h4></u></td>
  </tr>
  <?php $total=0; ?>
  @foreach($categories as $category)
  <tr>
	<td colspan = "4">
		<table class = "table table-bordered" width="100%">
			<tr>
				<th style="padding:10px;">CATEGORY</th>
				<th style="padding:10px;">EXPENSE</th>
				<th style="padding:10px;">ACTIVITY</th>
			</tr>
			<?php $name = $category->category;?>
			@foreach($category->activities as $activity)
			<tr>
				<td>{{$name}}</td>
				<td>{{$activity->expense}}</td>
				<td>{{$activity->name}}</td>
			</tr>
			<?php $name = '';
			$total += $activity->expense
			?>
			@endforeach
		</table>
	</td>
  </tr>
  @endforeach
  @if(EMPTY($categories) || COUNT($categories) == 0)
  <tr>
    <td colspan="4">
		<center><h5>No Budget/Expense Report Yet. </h5></center>
	</td>
  </tr>
  @endif
  <tr>
	  <td>Total Expense Incurred:</td>
	  <td> P {{number_format($total,2,'.',',')}}</td>
  </tr>
  <tr>
    <?php $user = auth()->user()->infos[0];
          $fullName = $user->last_name . ', ' . $user->first_name . ' ' . $user->middle_name;
          ?>
    <td colspan="4" style="text-align:right">{{'Generated By: ' . ucwords($fullName) . ' | Dated: ' . date('F d, Y')}}</td>
  </tr>
</table>
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
</html>

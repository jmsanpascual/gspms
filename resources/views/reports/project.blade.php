<html>
<head>
	<title>
		Green School - Project
	</title>

    {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
</head>
<center>
<style>
	td:nth-child(1), td:nth-child(3) {
		font-weight: bold;
		padding : 10px;
	}
	h2{
		color: white;
	}
	.sub-title {
		text-align : center;
		width : 100% !important;
	}
	h4{
		font-style: italic;
	}
	.objectives{
		font-weight: normal !important;
		font-size: 16px;
	}
	table thead th {
		text-align:center;
		width : 100%;
		background-color: #2dcc70 !important;
		padding : 5px;
	}
</style>
<table class = "table table-bordered table-responsive" width = "100%">
	<thead>
	<tr>
		<th colspan = "4" class = "gspms-title"><h2>Green School</h2></th>
	</tr>
</thead>
<tbody>
	<tr>
		<td colspan=  "4" class = "sub-title">
			<h3>Project Charter<h3></td>
	</tr><!--
	foreach($upd_arr['objective'] as $key => $value) {
               if (empty($temp)) $temp .= $value;
               else $temp .= $delimiter . $value;
            } -->
	<tr>
		<td>Project Name</td>
		<td>{{$proj->name}}</td>
		<td>Program</td>
		<td>{{$proj->program}}</td>
	</tr>
	<tr>
		<td>Start Date</td>
		<td>{{date('F d, Y', strtotime($proj->start_date))}}</td>
		<td>End Date</td>
		<td>{{date('F d, Y', strtotime($proj->end_date))}}</td>
	</tr>
	<tr>
		<td colspan=  "4" class = "sub-title">
			<h4>Partners<h4></td>
	</tr>
	<tr>
		<td>Organization</td>
		<td>{{$proj->partner_organization}}</td>
		<td>Community</td>
		<td>{{$proj->partner_community}}</td>
	</tr>
	<tr>
		<td>Champion</td>
		<td>{{$proj->champ_name}}</td>
		<td>Resource Person</td>
		<td>{{$proj->first_name . ' ' . $proj->middle_name . ' ' . $proj->last_name}}</td>
	</tr>
	<tr>
		<td colspan = "2">Initial Budget</td>
		<td colspan = "2">P {{number_format($proj->total_budget,2)}}</td>
	</tr>
	<tr>
		<td colspan = "2">Total Budget Request</td>
		<td colspan = "2">P {{number_format($total_budget_request,2)}}</td>
	</tr>
	<tr>
		<td colspan = "2">Total Budget</td>
		<td colspan = "2">P {{number_format($total_budget,2)}}</td>
	</tr>
	<tr>
		<td colspan = "2">Total Expense</td>
		<td colspan = "2">P {{number_format($total_expense,2)}}</td>
	</tr>
	<tr>
		<td colspan= "4" class = "sub-title"><h4>Objectives<h4></td>
	</tr>
	<tr>
		<td colspan = "4">
			<?php
			$delimiter = '(#$;)';
			$proj->objective = explode($delimiter, $proj->objective);
			?>
			<ul class = "objectives">
				@foreach($proj->objective as $key => $value)
				<li>{{$value}}</li>
				@endforeach
			</ul>
		</td>
	</tr>
	<tr>
		<td colspan = "2">Total Work Done (TWD)</td>
		<td colspan = "2">{{$duration}}</td>
	</tr>
	<tr>
		<td colspan = "2">Budget at Completion (BAC) </td>
		<td colspan = "2">{{number_format($proj->total_budget - $total_expense,2)}}</td>
	</tr>
	<tr>
		<td colspan = "2">Problems / Remarks</td>
		<td colspan = "2">{{ $proj->remarks }}</td>
	</tr>
	<!-- <tr>
		<td colspan = "2">Earned Value (EV)</td>
		<td colspan = "2"></td>
	</tr> -->
	<!-- <tr>
		<td colspan = "2">Actual Cost (AC)</td>
		<td colspan = "2">{{number_format($total_expense,2)}}</td>
	</tr> -->
	<!-- <tr>
		<td colspan = "2">Cost Performance Index (CPI)</td>
		<td colspan = "2"></td>
	</tr>
	<tr>
		<td colspan = "2">Estimate at Completion (EAC)</td>
		<td colspan = "2"></td>
	</tr>
	<tr>
		<td colspan = "2">To-Complete Performance Index (TCPI)</td>
		<td colspan = "2"></td>
	</tr>
	<tr>
		<td colspan = "4">
			<img src = "{{route('proj_chart', ['id' => 1 ])}}">
		</td>
	</tr> -->
</tbody>
</table>
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
</html>

<html>
<head>
	<title>
		Green School - Project
	</title>

    {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
</head>
<center>
<style>
	/*td:nth-child(1), td:nth-child(3) {
		font-weight: bold;
		padding : 10px;
	}*/
	td, th{
		/*font-weight: bold;*/
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
    h1, .center{
        text-align:center;
    }
	.form-group {
		font-size: 16px;
	}
	.form-label {
		font-weight: bold !important;
	}
</style>
<body>
<div class = "row">
    <h1 ><u>Budget / Expense Report</u></h1>
</div>

<h3><u>Projects Completed</u><h3>
<table class="table table-bordered table-stripped">
 <thead>
     <tr>
         <th>Activity Name</th>
         <th>Expense</th>
         <th>Category</th>
     </tr>
 </thead>
 <tbody>
	 <?php
	 $currentActivity = '';
	 $sum = 0;
	 ?>
	 @if(!EMPTY($activity))
       @foreach($activity AS $key => $val)
	   <?php
	   $expense = $val['quantity'] * $val['price'];
	   $sum += $expense;
	   ?>
       <tr>
         <td
		 	 @if($currentActivity == $val['name'])
			style = "border: none !important">
			@endif
			<!-- data -->
			 @if($currentActivity != $val['name'])
			 >
				 <?php
				 $currentActivity = $val['name'];
				 ?>
				 {{ $val['name']}}
			 @endif
		 </td>
         <td>{{ number_format($expense, 2) }}</td>
         <td>{{ $val['category'] }}</td>
       </tr>

       @endforeach
	 @endif
	 @if(COUNT($activity) == 0)
     <tr>
         <td class = "center" colspan="3">No records found</td>
     </tr>
	 @endif
 </tbody>
</table>
<table>
	<tr>
		<th>Total Expense Incurred :</th>
		<td>P {{ number_format($sum, 2)}}</td>
	</tr>
</table>

    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
</body>
</html>

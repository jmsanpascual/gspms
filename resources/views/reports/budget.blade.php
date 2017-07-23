<html>
<head>
	<title>
	Lasallian Institute for the Environment
	</title>

    {!! HTML::style('css/bootstrap/css/bootstrap.min.css'); !!}
</head>
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
</style>
<body>
	<div class = "row" style="text-align:center">
	    <img src="{{asset('img/life_logo.png')}}" style="width:55px"> Lasallian Institute for the Environment
	</div>
	<div class = "row"  style="text-align:center">
	    <h1 ><u>Budget Report</u></h1>
	</div>

	<h3><u>Projects Completed</u><h3>
	<table class="table table-bordered table-stripped">
	 <thead>
	     <tr>
	         <th>Project Name</th>
	         <th>Initial Budget</th>
	         <th>Total Budget Requested</th>
	         <th>Leftover Funds</th>
	     </tr>
	 </thead>
	 <tbody>
	     @if(!EMPTY($withoutRequest))
	       @foreach($withoutRequest AS $key => $val)
	       <tr>
	         <td> {{ $val['name']}}</td>
	         <td>{{ $val['total_budget'] }}</td>
	         <td>{{ $val['totalBudgetRequested'] }}</td>
	         <td>{{ $val['remaining'] }}</td>
	       </tr>
	       @endforeach
	     @endif
	     @if(COUNT($withoutRequest) == 0)
	     <tr>
	         <td class = "center" colspan="4">No projects found</td>
	     </tr>
	     @endif
	 </tbody>
	</table>

	<hr>
	<h3><u>Projects with Budget Requests</u><h3>
	<table class="table table-bordered table-stripped">
	    <thead>
	        <tr>
				<th>Project Name</th>
	   	         <th>Initial Budget</th>
	   	         <th>Total Budget Requested</th>
	   	         <th>Leftover Funds</th>
	        </tr>
	    </thead>
	    <tbody>
	        @if(!EMPTY($withRequest))
	            @foreach($withRequest AS $key => $val)
	            <tr>
	 	         <td> {{ $val['name']}}</td>
	 	         <td>{{ $val['total_budget'] }}</td>
	 	         <td>{{ $val['totalBudgetRequested'] }}</td>
	 	         <td>{{ $val['remaining'] }}</td>
	            </tr>
	            @endforeach
	        @endif

	        @if(COUNT($withRequest) == 0)
	        <tr>
	            <td class = "center" colspan="4">No projects found</td>
	        </tr>
	        @endif
	    </tbody>
	</table>
	<hr>
	<h3><u>Projects with Leftover Funds</u><h3>
	<table class="table table-bordered table-stripped">
	    <thead>
	        <tr>
              <th>Project Name</th>
              <th>Initial Budget</th>
              <th>Total Budget Requested</th>
              <th>Leftover Funds</th>
	        </tr>
	    </thead>
	    <tbody>
	        @if(!EMPTY($leftOvers))
	            @foreach($leftOvers AS $key => $val)
	            <tr>
	 	         <td> {{ $val['name']}}</td>
	 	         <td>{{ $val['total_budget'] }}</td>
	 	         <td>{{ $val['totalBudgetRequested'] }}</td>
	 	         <td>{{ $val['remaining'] }}</td>
	            </tr>
	            @endforeach
	        @endif
	        @if(COUNT($leftOvers) == 0)
	        <tr>
	            <td class = "center" colspan="4">No projects found</td>
	        </tr>
	        @endif
	    </tbody>
	</table>
    {!! HTML::script('js/others/jquery-1.12.0.min.js') !!}
    {!! HTML::script('plugins/bootstrap/js/bootstrap.min.js') !!}
  </body>
</html>

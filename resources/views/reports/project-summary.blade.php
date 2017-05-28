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
<div class = "row">
    <h1 ><u>Project Summary</u></h1>
</div>

<h3><u>Projects Completed</u><h3>
<table class="table table-bordered table-stripped">
 <thead>
     <tr>
         <th>Project Name</th>
         <th>Start Date</th>
         <th>End Date</th>
         <th>Actual End</th>
     </tr>
 </thead>
 <tbody>
     @if(!EMPTY($completed))
       @foreach($completed AS $key => $val)
       <tr>
         <td> {{ $val['name']}}</td>
         <td>{{ $val['start_date'] }}</td>
         <td>{{ $val['end_date'] }}</td>
         <td>{{ $val['actual_end'] }}</td>
       </tr>
       @endforeach
     @endif
     @if(COUNT($completed) == 0)
     <tr>
         <td class = "center" colspan="4">No projects found</td>
     </tr>
     @endif
 </tbody>
</table>

<hr>
<h3><u>Projects On-time</u><h3>
<table class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actual End</th>
        </tr>
    </thead>
    <tbody>
        @if(!EMPTY($onTime))
            @foreach($onTime AS $key => $val)
            <tr>
                <td>{{ $val['name'] }}</td>
                <td>{{ date('F j, Y', strtotime($val['start_date'])) }}</td>
                <td>{{ date('F j, Y', strtotime($val['end_date'])) }}</td>
                <td>{{ date('F j, Y', strtotime($val['actual_end'])) }}</td>
            </tr>
            @endforeach
        @endif

        @if(COUNT($onTime) == 0)
        <tr>
            <td class = "center" colspan="4">No projects found</td>
        </tr>
        @endif
    </tbody>
</table>
<hr>
<h3><u>Delayed Projects</u><h3>
<table class="table table-bordered table-stripped">
    <thead>
        <tr>
            <th>Project Name</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actual End</th>
        </tr>
    </thead>
    <tbody>
        @if(!EMPTY($delayed))
            @foreach($delayed AS $key => $val)
            <tr>
              <td> {{ $val['name']}}</td>
              <td>{{ $val['start_date'] }}</td>
              <td>{{ $val['end_date'] }}</td>
              <td>{{ $val['actual_end'] }}</td>
            </tr>
            @endforeach
        @endif
        @if(COUNT($delayed) == 0)
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

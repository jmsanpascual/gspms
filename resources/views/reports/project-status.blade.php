<html>
<head>
	<title>
		Green School - Project Completion Report
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
			<h1><b>STATUS REPORT</b></h1>
      <br>
      (Period: {{date('F Y', strtotime($proj->start_date))}} - {{date('F Y', strtotime($proj->end_date))}})
    </td>
	</tr>
  <tr>
    <td colspan="4"><h4><u><b>Project Information</b></h4></u></td>
  </tr>
  <tr>
	  <td width="29%">Project Name:</td>
      <td width="25%">{{$proj->name}}</td>
      <td width="25%">Start Date:</td>
    <td width="21%">{{date('m/d/Y', strtotime($proj->start_date))}}</td>
  </tr>
	<tr>
	<td>Program :</td>
	<td>{{$proj->program}}</td>
    <td>End Date</td>
    <td>{{date('m/d/Y', strtotime($proj->end_date))}}</td>
	</tr>
  {{-- <tr>
    <td colspan="4"><br></td>
  </tr> --}}
  <tr>
	  <td>Partner Organization : </td>
	  <td >{{$proj->partner_organization ?: 'N/A'}}</td>
  </tr>
  <tr>
  <td >Partner Community : </td>
	  <td >{{$proj->partner_community ?: 'N/A'}}</td>
  </tr>
	<tr style ="padding-top:10px;">
		<td>Champion : </td>
		<td>{{$proj->champ_name}}</td>
	</tr>
  <tr>
    <td  >Resource Person : </td>
    <?php $fullname = $proj->first_name . ' ' . $proj->middle_name . ' ' . $proj->last_name; ?>
    <td >{{trim($fullname) ?: 'No Resource Person'}}</td>
  </tr>
  <tr style = "padding-top:10px;">
    <td colspan="4"><h4><u><b>Objectives</b></h4></u></td>
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
  <tr style = "padding-top:10px;">
    <td colspan="4"><h4><u><b>Activities</b></h4></u></td>
  </tr>
  <tr>
    <td colspan="4">
    <ul class = "objectives">
      @foreach($activities as $key => $value)
      <li>{{$value['name']}}</li>

          &nbsp;&nbsp;&nbsp;&nbsp;<span style="font-weight:bold"><u>TASKS</u></span><br>
          @foreach($value['tasks'] AS $val)
            &nbsp;&nbsp;&nbsp;&nbsp;<span>- {{$val['name']}}</span><br>
          @endforeach
          @if(COUNT($value['tasks']) == 0)
            &nbsp;&nbsp;&nbsp;&nbsp;<span>No task(s) found</span><br>
          @endif
      @endforeach
    </ul>
    </td>
  </tr>
  {{-- <tr style = "margin-top:20px;">
    <td colspan="4"><h4><u><b>Milestones</b></h4></u></td>
  </tr>
  <tr>

  </tr> --}}
  <tr style = "padding-top:10px;">
    <td colspan="2"><h4><u><b>Project Budget</b></h4></u></td>
  </tr>
  <tr>
    <td>Initial Budget: </td>
    <td> P {{number_format($proj->total_budget,2)}}</td>

  </tr>
  <tr>
    <td colspan="2">
    <table class = "table table-bordered" style="padding:20px; width:100%">
      <tr>
        <th style="padding:10px;"><u> CATEGORY </u></th>
        <th style="padding:10px;"><u> AMOUNT </u></th>
      </tr>
      @foreach($expenses as $val)
      <tr>
        <td>{{$val->category}}</td>
        <td>{{number_format($val->amount,2,'.',',')}}</td>
      </tr>
      @endforeach
      @if(COUNT($expenses) == 0)
      <tr>
        <td colspan="2">No Record(s) Found</td>
      </tr>
      @endif
      <tr>
        <td> <b><u> TOTAL </u></b></td>
        <td> P {{number_format($total_expense,2, '.',',')}}</td>
      </tr>
    </table>
    </td>
  </tr>
  <tr style = "padding-top:10px;">
    <td colspan="2"><h4><u><b>Project Expenses</b></h4></u></td>
  </tr>
  <tr>
    <td colspan="4">
      <table width="100%" class ="table table-bordered">
        <tr>
          <th style="padding:10px;"><u> CATEGORY </u></th>
          <th style="padding:10px;"><u> ITEM </u></th>
          <th style="padding:10px;"><u> REMAINING AMOUNT </u></th>
        </tr>
        <?php $remainingTotal = 0; $totalExpense=0;?>
        @foreach($expenses as $val)
        <tr>
          <td>{{$val->category}}</td>
          {{-- <td>{{$val->activity->name}}</td> --}}
          <td>
            <ul class ="objective" >
              <?php $total = 0;?>
              @foreach($val->items as $item)
                <?php $total += ($item->quantity * $item->price); ?>
              <li><b>{{$item->item_name}}</b> - P {{$item->price}} x {{$item->quantity}}({{$item->quantity_label}}) = {{ number_format($item->quantity * $item->price, 2,'.',',')}}</li>
              @endforeach
              @if(COUNT($val->items) == 0)
                <li>N/A</li>
              @endif
              <li><u style="font-weight:bold">TOTAL:</u> {{number_format($total, 2, '.',',')}}</li>
            </ul>
          </td>
          <?php $remainingTotal += ($val->amount - $total); $totalExpense += $total; ?>
          <td>{{number_format(($val->amount - $total), 2,'.',',')}}</td>
        </tr>
        @endforeach
        @if(COUNT($expenses) == 0)
        <tr>
          <td colspan="3">No Expense(s) Found</td>
        </tr>
        @endif
        <tr>
          <td colspan="2"> <b><u> TOTAL </u></b></td>
          <td> P {{number_format($remainingTotal,2, '.',',')}}</td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
  	<td>Remaining Budget:</td>
  	<td> P {{ number_format($total_budget - $total_expense, 2, '.',',') }}</td>
    <td>Expenses Incurred:</td>
  	<td> P {{ number_format($totalExpense, 2, '.',',') }}</td>
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
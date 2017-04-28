@extends('layouts.defaultModal')

@section('title')
  @{{ submitData.action}} Milestone
@stop

@section('modal-content')
<b>Milestone 1</b> [<i>Planning</i>]: (@{{ submitData.milestoneDates.phase_1 }}) <br>
<b>Days delayed:</b> (@{{ (submitData.phase1.daysLeft < 0) ? submitData.phase1.daysLeft * -1 : 0 }})
<div class="progress">
  <div class="progress-bar" aria-valuemin="0" aria-valuemax="33"
    ng-style="{width: (submitData.phase1.percent * 3) + '%'}"
    ng-class="phase.class">
    <span class="sr-only">
      @{{ submitData.phase1.percent }}% Complete Phase @{{ submitData.phase1.id }}
    </span>
      @{{ (submitData.phase1.percent * 3) - ((submitData.phase1.percent * 3) % 1) }}%
  </div>
</div>
<b>Milestone 2</b> [<i>Implementation</i>]: (@{{ submitData.milestoneDates.phase_2 }}) <br>
<b>Days delayed:</b> (@{{ (submitData.phase1.daysLeft < 0) ? submitData.phase1.daysLeft * -1 : 0 }})
<div class="progress">
  <div class="progress-bar" aria-valuemin="0" aria-valuemax="33"
    ng-style="{width: (submitData.phase2.percent * 3) + '%'}"
    ng-class="submitData.phase2.class">
    <span class="sr-only">
      @{{ submitData.phase2.percent }}% Complete Phase @{{ submitData.phase2.id }}
    </span>
      @{{ (submitData.phase2.percent * 3) - ((submitData.phase2.percent * 3) % 1) }}%
  </div>
</div>
<b>Milestone 3</b> [<i>Closing</i>]: (@{{ submitData.milestoneDates.phase_3 }}) <br>
<b>Days delayed:</b> (@{{ (submitData.phase1.daysLeft < 0) ? submitData.phase1.daysLeft * -1 : 0 }})
<div class="progress">
  <div class="progress-bar" aria-valuemin="0" aria-valuemax="33"
    ng-style="{width: (submitData.phase3.percent * 3) + '%'}"
    ng-class="submitData.phase3.class">
    <span class="sr-only">
      @{{ submitData.phase3.percent }}% Complete Phase @{{ submitData.phase3.id }}
    </span>
      @{{ (submitData.phase3.percent * 3) - ((submitData.phase3.percent * 3) % 1) }}%
  </div>
</div>
@stop

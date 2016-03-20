@extends('layouts.index')

@section('content')
<h1>Welcome {{ Session::get('first_name') . ' ' . Session::get('middle_name') . ' ' . 
	Session::get('last_name') }}!</h1>
@endsection
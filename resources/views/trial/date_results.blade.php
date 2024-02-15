@extends('content')

@section('content')
    <date-results :is_admin="{{Auth::user()->role_id}}" :date_selected="{{json_encode($date)}}"></date-results>
@endsection

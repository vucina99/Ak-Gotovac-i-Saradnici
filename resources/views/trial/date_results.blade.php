@extends('content')

@section('content')
    <date-results :date_selected="{{json_encode($date)}}"></date-results>
@endsection

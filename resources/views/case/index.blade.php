@extends('content')

@section('content')


    <search-result :is_admin="{{Auth::user()->role_id}}"></search-result>




@endsection

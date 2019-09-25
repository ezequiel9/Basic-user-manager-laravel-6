@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <users :current_user="{{$current_user->toJson()}}"></users>
@endsection

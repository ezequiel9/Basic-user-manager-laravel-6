@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <dashboard :user="{{$user->toJson()}}"></dashboard>
@endsection

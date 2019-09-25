@extends('layouts.app')

@section('content')
    {{--Get dashboard component--}}
    <dashboard :user="{{$user->toJson()}}"></dashboard>
@endsection

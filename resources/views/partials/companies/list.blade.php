@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <companies :user="{{$user->toJson()}}"></companies>
@endsection

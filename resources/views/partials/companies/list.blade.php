@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <companies :current_user="{{$current_user->toJson()}}"></companies>
@endsection

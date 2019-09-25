@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <users-form :user="{{$user->toJson()}}" :current_user="{{$current_user->toJson()}}"></users-form>
@endsection

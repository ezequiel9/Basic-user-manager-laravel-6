@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <users-form :current_user="{{$current_user->toJson()}}" :user="{}"></users-form>
@endsection

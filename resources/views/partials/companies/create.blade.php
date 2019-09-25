@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <companies-form :current_user="{{$current_user->toJson()}}" :company="{}"></companies-form>
@endsection

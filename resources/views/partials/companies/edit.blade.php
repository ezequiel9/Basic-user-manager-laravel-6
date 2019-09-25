@extends('layouts.content')

@section('content')
    {{--Get dashboard component--}}
    <companies-form :company="{{$company->toJson()}}" :current_user="{{$current_user->toJson()}}"></companies-form>
@endsection

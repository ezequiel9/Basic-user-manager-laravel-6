@extends('layouts.app')

@section('app-content')

    <div class="d-flex" id="wrapper">
        <!--sidebar-->
        <div class="" id="sidebar-wrapper">
            <h5>Menu</h5>
            <ul>
                <li><a href="{{route('users.index')}}">Users</a></li>
                @if(Auth::user()->isAdmin())
                    <li><a href="{{route('companies.index')}}">Companies</a></li>
                @endif
            </ul>
        </div>
        <!--content-->
        <div class="" id="content-wrapper">

            <div class="row">
                <div class="col-12">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

@stop

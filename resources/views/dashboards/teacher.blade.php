@extends('layouts.app') @section('content')
    {{ __('Teacher Dashboard') }}
    @if (session('status'))
        {{ session('status') }}
    @endif {{ __('You are logged in as a Teacher!') }}
@endsection

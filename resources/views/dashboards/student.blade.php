@extends('layouts.app') @section('content')
    {{ __('Student Dashboard') }}
    @if (session('status'))
        {{ session('status') }}
    @endif {{ __('You are logged in as a Student!') }}
@endsection

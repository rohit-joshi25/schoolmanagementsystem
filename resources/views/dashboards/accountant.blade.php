@extends('layouts.app') @section('content')
    {{ __('Accountant Dashboard') }}
    @if (session('status'))
        {{ session('status') }}
    @endif {{ __('You are logged in as an Accountant!') }}
@endsection

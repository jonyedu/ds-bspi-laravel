@extends('layouts.master')

@section('content')
    <app :user="{{ json_encode(Auth::user()) }}"></app>              
@endsection

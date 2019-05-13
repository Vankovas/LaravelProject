@extends('app')

@section('title',"Home")

@section('content')
{{-- Check if the user is logged in --}}


{{-- If the user is not logged in --}}
    <div class="jumbotron text-center">
        <h1>Welcome to Your Health Diary</h1>
        <p>This is the website to keep track of your health</p>
        <img src="{{ url('/') . Storage::url("public/images/cover.jpg") }}">    </div>
@endsection



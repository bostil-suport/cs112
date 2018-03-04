@extends('layouts.app')

@section('content')
    Display one project with id={{ $project['id'] }}

    <div class="list">
        <h2 class="title">{{ $project['title'] }}</h2>

        <p>{{ $project['description'] }}</p>

        <span class="dateNews"><i>Added: {{ $project['created_at'] }}</i></span>

        <hr>
    </div>



@endsection()


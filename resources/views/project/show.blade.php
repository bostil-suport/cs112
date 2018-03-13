@extends('layouts.app')

@section('content')
    Display one project with id={{ $project->id }}

    <div class="list">
        <p class="title">{{ $project->title }}</p>

        <p>{{ $project->description }}</p>

        <span class="dateNews"><i>Added: {{ $project->created_at }}</i></span>

        @unless($project->tags->isEmpty())
            <h5>Tags:</h5>
            <ul>
                @foreach($project->tags as $tag)

                    <li>{{ $tag->name }}</li>

                @endforeach


            </ul>
        @endunless

        <hr>
    </div>



@endsection()


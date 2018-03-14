@extends('layouts.app')

@section('content')
    Display one project with id={{ $project->id }}

    <div class="list">
        <p class="title">{{ $project->title }}</p>

        <p>{{ $project->description }}</p>

        <span class="dateNews"><i>Added: {{ $project->created_at }}</i></span>

        @unless($project->tags->isEmpty())
            <h5>Tags:</h5>
            <div class="showTags">
                @foreach($project->tags as $tag)

                    <span class="oneTag">
                        <a href="{{ route('tags', $tag->name ) }}">{{ $tag->name }}</a>

                    </span>

                @endforeach
            </div>

        @endunless

    </div>



@endsection()


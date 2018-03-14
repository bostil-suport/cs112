@extends('layouts.app')

@section('content')

    @if($projects)

        <p>Display projects with tag=</p>
        <span class="oneTag">
                        {{ $tag_name }}

        </span>
        <div class="clearfix"></div>
        @foreach ($projects as $project)

            <div class="list">
                <h2 class="title"><a href="/project/{{ $project['id'] }}"> {{ $project['title'] }}</a></h2>

                <p>{{ $project['description'] }}</p>

                <span class="dateNews"><i>Added: {{ $project['created_at'] }}</i></span>


                <!-- если залогиненный, то отображаем Edit this project  -->
                <!-- убрать потом вообще, тк будет для каждого user отдельное редактирование своих проектов  -->





                <hr>
            </div>

        @endforeach

    @else

            Projects with tag {{ $tag_name }} not found
        {{--<p class="title">{{ $project->title }}</p>--}}


    @endif




@endsection()


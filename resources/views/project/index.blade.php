@extends('layouts.app')

@section('content')
    <h1>List of all projects</h1>


    <!-- если залогиненный, то отображаем  Add project -->
    @auth
    <a href='{!! url('/project/create'); !!}'>
        <button type="button" class="btn btn-success">Add project</button>
    </a>
    @endauth
    @auth
        <a href='{!! url('/project/mylist'); !!}'>
            <button type="button" class="btn btn-info">My projects</button>
        </a>
        <p>You can add project. View and edit your projects.</p>
    @endauth


    @foreach ($news as $value)

    <div class="list">
        <h2 class="title"><a href="/project/{{ $value->id }}"> {{ $value->title }}</a></h2>

        <p>{{ $value->description }}</p>

        <span class="dateNews"><i>Added: {{ $value->created_at }}</i></span>


        <!-- если залогиненный, то отображаем Edit this project  -->
        <!-- убрать потом вообще, тк будет для каждого user отдельное редактирование своих проектов  -->





        <hr>
    </div>

    @endforeach
@endsection()


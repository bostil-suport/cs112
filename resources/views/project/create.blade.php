@extends('layout')

@section('content')
    <h1>Add project</h1>

    <a href='{!! url('/project'); !!}'><button type="button" class="btn btn-success">Project list</button></a>

    <form action="/project" method="post">
    @csrf
    <div class="form-group">
            <label for="exampleInputTitle">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle" name="title" placeholder="Enter title">

        </div>
        <div class="form-group">
            <label for="exampleInputDescription">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription" name="description" placeholder="Enter Description">

        </div>

        <button type="submit" class="btn btn-primary">Add project</button>
    </form>

@endsection()


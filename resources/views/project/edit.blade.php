@extends('layout')

@section('content')
    <h1>Edit project with id=<?= $project['id'] ?></h1>

    <a href='{!! url('/project'); !!}'><button type="button" class="btn btn-success">Project list</button></a>

    <form action="/project/<?= $project['id'] ?>" method="post">
    @csrf
    <div class="form-group">
            <label for="exampleInputTitle">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle" name="title" value="<?= $project['title'] ?>">

        </div>
        <div class="form-group">
            <label for="exampleInputDescription">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription" name="description" value="<?= $project['description'] ?>">

        </div>

        <input type="hidden" name="_method" value="PATCH">

        <button type="submit" class="btn btn-primary">Update project</button>
    </form>

@endsection()


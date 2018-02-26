@extends('layouts.app')

@section('content')
    <h1>Projects list</h1>


    <!-- если залогиненный, то отображаем  Add project -->
    <a href='{!! url('/project/create'); !!}'>
        <button type="button" class="btn btn-success">Add project</button>
    </a>



    <?php foreach ($news as $value) : ?>

    <div class="list">
        <h2 class="title"><a href="/project/<?= $value->id ?>"> <?= $value->title ?></a></h2>

        <p><?= $value->description ?></p>

        <span class="dateNews"><i>Added: <?= $value->created_at ?></i></span>


        <!-- если залогиненный, то отображаем Edit this project  -->
        <a href="/project/<?= $value->id ?>/edit">
            <div>
                <button type="button" class="btn btn-info">Edit this project</button>
            </div>
        </a>




        <hr>
    </div>

    <?php endforeach; ?>
@endsection()

@extends('layouts.app')

@section('content')
    <h1>Edit project with projectId={{ $project->id }}</h1>

    <a href='{!! url('/project'); !!}'>
        <button type="button" class="btn btn-success">Project list</button>
    </a>

    <form action="/project/{{ $project->id }}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputTitle">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle" name="title" value="{{ $project->title }}"
                   required>

        </div>
        <div class="form-group">
            <label for="exampleInputDescription">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription" name="description"
                   value="{{ $project->description }}" required>

        </div>

        {{--<div class="form-group">--}}
        {{--<label for="tag_pluck">Tags</label>--}}
        {{--<select name="tag_pluck[]" class="form-control" id="tag_pluck" multiple="multiple" required>--}}
        {{--@foreach ($tags as $key => $value)--}}
        {{--<option value="{{ $key }}" >{{ $value }}</option>--}}
        {{--@endforeach--}}
        {{--</select>--}}

        {{--</div>--}}
        <div class="form-group">
            {!! Form::Label('tag_list', 'Tags:') !!}
            {!! Form::select('tag_list[]', $tags, $project->getTagListAttribute(), ['id'=>'tag_list', 'class' => 'form-control', 'multiple', 'required']) !!}
        </div>

        <input type="hidden" name="_method" value="PATCH">

        <button type="submit" class="btn btn-primary">Update project</button>
    </form>

@endsection()

@section('footer')
    <script>
        $('#tag_list').select2({
            placeholder: 'Tags',
            tags: true,
            tokenSeparators: [',',' '],
            ajax: {
                dataType: 'json',
                url: '{{url('tags-api')}}',
                delay:250,
                data: function (params) {
                    return {q: params.term}
                },
                processResults: function(data) {return data;}
            }
        });
    </script>
@endsection


@extends('layouts.app')

@section('content')
    <h1>Add project</h1>

    <a href='{!! url('/project'); !!}'>
        <button type="button" class="btn btn-success">Project list</button>
    </a>

    <form action="/project" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputTitle">Title</label>
            <input type="text" class="form-control" id="exampleInputTitle" name="title" placeholder="Enter title"
                   required>

        </div>
        <div class="form-group">
            <label for="exampleInputDescription">Description</label>
            <input type="text" class="form-control" id="exampleInputDescription" name="description"
                   placeholder="Enter Description" required>

        </div>

        {{--<div class="form-group">--}}
            {{--<label for="tag_list">Tags</label>--}}
            {{--<select name="tag_list[]" class="form-control" id="tag_list" multiple="multiple" required>--}}
                {{--@foreach ($tags as $key => $value)--}}
                    {{--<option value="{{ $key }}">{{ $value }}</option>--}}
                {{--@endforeach--}}
            {{--</select>--}}

        {{--</div>--}}

        <div class="form-group">
            {!! Form::Label('tag_list', 'Tags:') !!}
            {!! Form::select('tag_list[]', $tags, null, ['id'=>'tag_list', 'class' => 'form-control', 'multiple', 'required']) !!}
        </div>


        <input type="hidden" name="user_id" value="{{ $userid }}">

        <button type="submit" class="btn btn-primary">Add project</button>
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
                // delay:250,
                data: function (params) {
                    return {q: params.term}
                },
                processResults: function(data) {return data;}
            }
        });
    </script>
@endsection



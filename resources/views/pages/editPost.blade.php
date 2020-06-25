@extends('layouts.master')

@section('content')

    <form class="form-body" action="{{route('post.update', $post)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="postTitle">Give your Post a Title</label>
            <input type="text" class="form-control" id="postTitle" name="title" value="{{old('title', $post->title)}}"
                   required minlength="3" maxlength="40">

            @error('title')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            @enderror

        </div>

{{--        minlength="3"--}}
        <div class="form-group">
            <label for="postBody">Write your Article</label>
            <textarea placeholder="Write your Article" name="body" rows="10" cols="30" class="form-control"
                      id="postBody" required  maxlength="1600">{{old('body', $post->body)}}</textarea>
            @error('body')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            @enderror

        </div>

        <div class="form-group">

            <label for="postTags">Select Post Tags</label>
            <select multiple class="form-control" id="postTags" name="tags[]" required>

                @foreach($tags as $tag)

                    <option
{{--                    preselects current tags from database. And if the user selects something new and get an error in form submitting also preselect the last selected data --}}
                        value="{{$tag->id}}" {{(collect(old('tags')))->contains($tag->id) || $thisPostTags->contains($tag)  ? "selected" : "" }}>{{$tag->name}}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Post Now</button>

        </div>
    </form>

@endsection

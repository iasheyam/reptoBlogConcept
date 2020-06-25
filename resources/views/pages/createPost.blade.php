@extends('layouts.master')

@section('content')

    <form class="form-body" action="{{route('post.store')}}" method="POST">

        @csrf

        <div class="form-group">

            <label for="postTitle">Give your Post a Title</label>
            <input type="text" class="form-control" id="postTitle" name="title" value="{{old('title')}}" required
                   minlength="3" maxlength="40">

            @error('title')
            <div class="alert alert-danger">
                <strong>{{$message}}</strong>
            </div>
            @enderror

        </div>


        <div class="form-group">
            <label for="postBody">Write your Article</label>
            <textarea placeholder="Write your Article" name="body" rows="10" cols="30" class="form-control"
                      id="postBody" required minlength="3" maxlength="1600"> {{old('body')}} </textarea>

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
                        <option value="{{$tag->id}}" {{(collect(old('tags')))->contains($tag->id) ? "selected" : "" }}>{{$tag->name}}</option>
                    @endforeach
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Post Now</button>

        </div>
    </form>

@endsection

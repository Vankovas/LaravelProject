@extends('app')

@section('title',"Posts")

@section('content')

    {{-- Post Content --}}
    {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
    <div class="focus-post">
        <h1 class="focus-post-title">{{$post->title}}</h1>
        <img src="{{Storage::url("cover_images/". $post->cover_image)}}"><br><br>
        <div class="focus-post-body ">{!!$post->body!!}</div>
        <small class="float-right">Written on {{$post->created_at}}</small>
    </div>
    {!! Form::close() !!}

    <hr>

    {{-- Controls --}}
    <div class="focus-post-actions">
        {{-- Go Back --}}

        <form action="/posts">
            <input class="btn btn-dark focus-post-btn" type="submit" value="Go Back"/>
        </form>
        @if (Auth::check())
            @if(Auth::user()->id == $post->user_id || Auth::user()->type == "admin")
                {{-- Edit --}}
                <form action="/posts/{{$post->id}}/edit">
                    <input class="btn btn-primary focus-post-btn" type="submit" value="Edit"/>
                </form>

                {{-- Delete --}}
                {!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST',
                'class'=>'focus-post-delete'])!!}
                {{Form::hidden('_method', 'DELETE')}}
                {{Form::submit('Delete', ['class'=>'btn btn-danger focus-post-btn'])}}
                {!! Form::close()!!}
            @endif
        @endif
    </div>

@endsection

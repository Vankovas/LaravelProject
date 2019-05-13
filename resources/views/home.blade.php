@extends('app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        Welcome, {{Auth::user()->name}}
                        {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                        <div class="form-group">
                            <img src="{{ Storage::url("profile_images/". Auth:: user()->profile_image)}}"
                                 style="width:150px; height:150px; float:left; border-radius:50%; margin-right:25px;"><br><br>
                            {{Form::file('profile_image')}}
                        </div>
                        {{Form::submit('Submit profile changes', ['class'=>'btn btn-primary'])}}<br><br>
                        {!! Form::close() !!}



                        {!! Form::open(['action' => 'PostsController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

                        <div class="panel-body">
                            <a href="/posts/create" class="btn btn-primary">Create post</a>
                            <a href="/pdf" class="btn btn-primary">Get your posts in PDF</a>
                            @if (Auth::user()->type == "admin")
                                <a href="/export" class="btn btn-primary">Export all users in EXCEL</a>
                            @endif
                            <h3>Your posts</h3>
                            @if(count($posts)>0)
                                <table class="table table-striped">
                                    @foreach($posts as $post)
                                        <tr>
                                            <td><img style="width:250px"
                                                     src="/storage/cover_images/{{$post->cover_image}}">
                                            </td>
                                            <td>{{$post->title}}</td>
                                            <td><a href="/posts/{{$post->id}}/edit" class="btn btn-default">Edit</a>
                                            </td>
                                            <td>
                                                {{-- Delete --}}
                                                {!!Form::open(['action'=>['PostsController@destroy', $post->id], 'method'=>'POST',
                                                'class'=>'focus-post-delete'])!!}
                                                {{Form::hidden('_method', 'DELETE')}}
                                                {{Form::submit('Delete', ['class'=>'btn btn-danger focus-post-btn'])}}
                                                {!! Form::close()!!}
                                            </td>
                                        </tr>
                                        </tr>
                                    @endforeach
                                </table>
                            @else
                                <p>You have no posts</p>
                            @endif
                        </div>
                        {!! Form::close()!!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

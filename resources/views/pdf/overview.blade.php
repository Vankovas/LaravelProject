<div text-align:center;>

<img  height="100px" src="{{storage_path('app/public/images/logo.png')}}">
   <h2> Posts overview of {{Auth::user()->name}}<h2>
    {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}

    <table>
        @foreach (Auth::user()->posts as $post)
        <p><img height="60px" src="{{storage_path('app/public/images/postbreak.png')}}"><p>
        <p> {!!$post->body!!} </p>
       <b> <p> {{$post->title}} </p></b>
        <img style="width:400px; height: 200px"
         src="{{public_path('storage/cover_images/'.$post->cover_image)}}">
        @endforeach
    </table>
</div>
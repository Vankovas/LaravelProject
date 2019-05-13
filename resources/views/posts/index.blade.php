@extends('app')

@section('title',"Posts")

@section('content')

    <h1 style="text-align:center;margin-top:1rem;">Posts</h1>
    <div style="margin:0 auto;width:450px;">
        <img src="{{ url('/') . Storage::url("public/images/posts.png") }}"/>
    </div>
    <div class="posts-container">
        {{-- Post Count Check --}}
        @if(count($posts) > 0)
            <?php $count = 0; ?>
            @foreach ($posts as $post)
                <?php $count++;?>
                {{-- Adding Odd/Even classes for styling --}}
                <div class="post <?php if ($count % 2 == 0) echo ' even'; else echo ' odd';?>">
                    {{-- Post Content --}}
                    <div class="row">
                        <div class="col-md-4 col-cm-4">
                            <img onmouseover="this.src = '{{Storage::url("cover_images/"."pixelated_". $post->cover_image)}}'"
                                 onmouseleave="this.src = '{{Storage::url("cover_images/". $post->cover_image)}}'"
                                 src="{{Storage::url("cover_images/". $post->cover_image)}}"
                                 style="width:100%"/>
                        </div>
                        <div class="col-md-4 col-cm-8">
                            <h3 class="post-headline"><a href="posts/{{$post->id}}">{{$post->title}}</a></h3>
                            <div class="post-body">{!!str_limit($post->body, $limit = 150, $end = '...') !!}</div>
                            <small class="post-time">Written on {{$post->created_at}}</small>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            {{-- If there are no posts --}}
            <p>No posts found</p>
        @endif
    </div>
    </div>
@endsection

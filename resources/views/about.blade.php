@extends('app')

@section('title',"About")

@section('content')
    <h1 style="text-align: center;margin:1rem 0 4rem 0; "> About the creators</h1>
    <div class="image-group-wrapper">
        <div class="image-group">
            <img src="{{Storage::url("images/". "Melis_picture.jpg")}}"/>
            <p>Melis Hasanova</p>
        </div>
        <div class="image-group">
            <img src="{{Storage::url("images/". "Ivan_picture.jpg")}}"/>
            <p>Ivan Vasilev</p>
        </div>
    </div>
    <p style="text-align: center;font-size: 2rem;">
        This website was created in order to provide comprehensive and useful information regarding leading a healthier lifestyle!
    </p>
@endsection

<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user();

        //Defining name and path
        $avatarName = $user->id . '_avatar' . time() . '.' . 'png';
        $location = storage_path('app/public/profile_images/') . $avatarName;

        //Uploading and resizing
        $image = $request->file('profile_image');
        $img = \Image::make($image->getRealPath())->resize(300, 300);
        $img->encode('png');

        //Defining dimensions
        $width = 300;
        $height = 300;
        $mask = \Image::canvas($width, $height);

        // draw a white circle
        $mask->circle($width, $width / 2, $height / 2, function ($draw) {
            $draw->background('#fff');
        });

        //Applying mask
        $img->mask($mask, false);

        //Adding text to the profile image as watermark
        $img->text('www.thehealthyway.com', 105, 285, function($font) {
            $font->color('#fdf6e3');
        });
        
        //Saving image
        $img->save($location);

        //Updating database
        $user->profile_image = $avatarName;
        $user->save();

        return back()
            ->with('success', 'You have successfully uploaded an image.');
    }
}

<?php

namespace App\Http\Controllers\Songs;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddSongToAlbumRequest;
use App\Http\Requests\CreateAlbumRequest;
use App\Http\Requests\GetAlbumRequest;
use Audio\Models\Albums;
use Auth\Models\User;
use Illuminate\Support\Str;

class AlbumController extends Controller
{
    public function createAlbum(CreateAlbumRequest $request)
    {
        $savedImgName = sha1($request->album_image->getClientOriginalName()).Str::random().$request->file('album_image')->extension();
        $request->album_image->storeAs('album_img', $savedImgName);
        $album = new Albums();
        $albumId = sha1($request->get('album_name').Str::random());
        $album->id = $albumId;
        $album->name = $request->get('album_name');
        $album->thumbnail = storage_path('app/album_img/'.$savedImgName);
        $album->save();
        $user = User::findOrfail($request->get('user_id'));
        $user->albums()->attach([$albumId]);

        return response('no errors');
    }

    public function addSongToAlbum(AddSongToAlbumRequest $request)
    {
        $album = Albums::findOrfail($request->get('album_id'));
        $album->songs->attach([$request->get('song_id')]);
    }

    public function deleteSongFromAlbum(AddSongToAlbumRequest $request)
    {
        $album = Albums::findOrfail($request->get('album_id'));
        $album->songs->detach([$request->get('song_id')]);
    }

    public function getAlbumsByUser(GetAlbumRequest $request)
    {
        return User::findOrfail($request->get('user_id'))->albums()->get();
    }
}

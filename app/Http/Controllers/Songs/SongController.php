<?php

namespace App\Http\Controllers\Songs;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetSongsRequest;
use Audio\Models\Song;

class SongController extends Controller
{
    public function getSongs(GetSongsRequest $request)
    {
        return Song::query()->getSongs($request->get('start'),
            $request->has('bathSize') ? $request->get('bathSize') : 2)->get();
    }
}

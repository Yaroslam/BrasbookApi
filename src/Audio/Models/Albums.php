<?php

namespace Audio\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Albums extends Model
{
    public $timestamps = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'name',
        'thumbnail',
    ];

    protected $table = 'albums';

    public function songs(): belongsToMany
    {
        return $this->belongsToMany(Song::class, 'albums_songs', 'album_id', 'song_id');
    }
}

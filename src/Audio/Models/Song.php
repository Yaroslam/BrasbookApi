<?php

namespace Audio\Models;

use Audio\QueryBuilders\SongQueryBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Song|SongQueryBuilder query()
 */
class Song extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'song_name',
        'song_time',
    ];

    protected $table = 'songs';

    public function newEloquentBuilder($query): SongQueryBuilder
    {
        return new SongQueryBuilder($query);
    }

    //    protected function songName(): Attribute
    //    {
    //        return Attribute::make(
    //            get: fn (string $value) => $this->homeDir().$value,
    //            set: fn (string $value) => $value,
    //        );
    //    }

    public function homeDir(): string
    {
        return '/opt/songs/';
    }
}

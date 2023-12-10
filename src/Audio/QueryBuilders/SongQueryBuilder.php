<?php

namespace Audio\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class SongQueryBuilder extends Builder
{
    public function getSongs(int $start, int $batchSize = 2): SongQueryBuilder
    {

        return $this->orderBy('song_name')
            ->whereBetween('id', [$start, $start + $batchSize]);
    }
}

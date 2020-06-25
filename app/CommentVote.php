<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CommentVote extends Model
{
    protected $guarded = [];
    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
}

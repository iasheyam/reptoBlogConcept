<?php

namespace App;

use http\Env\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Comment extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function post()
    {
        return $this->belongsTo('App\Post');
    }

    public function commentReplies()
    {
        return $this->hasMany('App\CommentReply');
    }

    //  todo couldn't use query builder.
//    public function scopeWithVote(Builder $query)
//    {
//        $voteType = ['id' => 5, 'title' => "UpVote"];
//
//        $query = DB::table('comment_votes');
//////            ->select('comment_id')
////            ->where('vote_type_id', $voteType['id'])
////            ->groupBy('comment_id')
//////            ->count('vote_type_id')
////            ->get()
//        );
//
//        $query->leftJoinSub(
//            'select comment_id, count(case vote_type_id when use($voteType[id]) then 1 else null end) as use($voteType[title]) from comment_votes group by comment_id',
//            'votes',
//            'comment_votes.comment_id',
//            '=',
//            'comments.id'
//        );
//    }

    public function vote($user = null, $request)
    {
        $this->votes()->updateOrCreate(
            ['user_id' => $user ? $user->id : auth()->id()],
            ['vote_type_id' => $request->voteType]
        );
    }

    public function isVotedBy(User $user)
    {
        return $user->votes()->where('comment_id', $this->id)->get()->isNotempty();
    }

    public function votes()
    {
        return $this->hasMany('App\CommentVote');
    }


}

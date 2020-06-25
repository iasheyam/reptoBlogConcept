<?php

use Illuminate\Database\Seeder;

class CommentVoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // makes 1000 factory instances and iterate over them to check their existence in the database
        // Todo Optimize the algorithm
        factory(App\CommentVote::class, 1000)->make()
            ->each(function ($commentVote) {
                if (DB::table('comment_votes')
                    ->where([
                        ['user_id', '=', $commentVote->user_id],
                        ['comment_id', '=', $commentVote->comment_id]
                    ])->get()
                    ->isEmpty()) {
                    $commentVote->save();
                }
            });
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoteTypesInVoteTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insert vote types
        DB::table('vote_types')->insert(
            array(
                'title' => 'Upvote',
                'created_at' => now(),
                'updated_at' => now()
            )
        );

        DB::table('vote_types')->insert(
            array(
                'title' => 'Downvote',
                'created_at' => now(),
                'updated_at' => now()
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('vote_types')->where('title', 'Upvote')->delete();
        DB::table('vote_types')->where('title', 'Downvote')->delete();
    }
}

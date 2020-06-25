<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Posts_Tags_Map;
use App\Tag;
use App\VoteType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Post;
use function GuzzleHttp\Promise\all;

class PostController extends Controller
{
    public function index()
    {

        if (\request('tag')) {
            $posts = Tag::where('name', \request('tag'))->firstorFail()->posts()->latest('updated_at')->get();
        }
        else{
            $posts = Post::with('tags')->latest()->get();
        }

        return view('pages/welcome', compact(['posts']));
    }

    public function show(Post $post)
    {
        $tags = $post->tags;
        return view('pages/post', compact(['post', 'tags']));
    }

    public function create()
    {
        $tags = $this->getTags();
        return view('pages/createPost', compact('tags'));
    }

    public function store()
    {

        $this->validatePost();
        $post = new Post(request(['title','body']));
        $post->user_id = auth()->user()->id;
        $post->image_url = 'img/post-3.jpg';
        $post->published_at = now();
        $post->save();
        $post->tags()->attach(request('tags'));
        return redirect(route('post.index'));
    }

    public function edit(Post $post)
    {
        $this->authorize('update-post', $post);
        $tags = $this->getTags();
        $thisPostTags = $post->tags;
        return view('pages/editPost', compact(['post', 'thisPostTags', 'tags']));
    }

    public function update(Post $post)
    {

        $this->validatePost();

        $post->update(request(['title', 'body']));

        $post->user_id = 1;

        $post->image_url = 'img/post-3.jpg';

        $post->published_at = now();

        $post->save();

        $post->tags()->sync(request('tags'));

        return redirect(route('post.show', $post));
    }

    // todo cant save $post->published_at as Carbon Object in database.
    //      couldnt figure out how to pass current time in create method

    protected function validatePost(): array
    {
        return request()->validate([

            'title' => 'required|string|between:3,40',
            'body' => 'required|string| between:3,1600',
            'tags' => 'exists:tags,id'
        ]);
    }

    /**
     * @return Tag[]|\Illuminate\Database\Eloquent\Collection
     */
    protected function getTags()
    {
        return Tag::all();
    }
}

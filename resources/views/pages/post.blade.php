@extends('layouts.master')
@section('content')

    <header>
        <!-- Page Header -->
        <div id="post-header" class="page-header">
            <div class="background-img" style="background-image: url('/img/post-page.jpg');"></div>
            <div class="container">
                <div class="row">
                    <div class="col-md-10">
                        <div class="post-meta">

                            @foreach($tags as $tag)
                                <a class="post-category cat-2" href="category.html">{{$tag->name}}</a>
                            @endforeach

                        </div>
                        <h1>{{$post->title}}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
    </header>
    <!-- /Header -->

    <!-- section -->
    <div class="section">
        <!-- container -->
        <div class="container">
            <!-- row -->
            <div class="row">
                <!-- Post content -->
                <div class="col-md-8">
                    <div class="section-row sticky-container">


                        <div class="main-post">
                            <span class="post-date">{{$post->updated_at->format('d-M-Y')}}</span>
                            <hr>
                            <p>{{$post->body}}</p>
                        </div>

                        <div class="post-shares sticky-shares">

                            @can('update-post', $post)
                                <a href="{{route('post.edit', $post->id)}}" class="edit-post"><i
                                        class="fa fa-pencil"></i></a>
                            @endcan
                            <a href="#" class="share-facebook"><i class="fa fa-facebook"></i></a>
                            <a href="#" class="share-twitter"><i class="fa fa-twitter"></i></a>
                            <a href="#" class="share-google-plus"><i class="fa fa-google-plus"></i></a>
                            <a href="#" class="share-pinterest"><i class="fa fa-pinterest"></i></a>
                            <a href="#" class="share-linkedin"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-envelope"></i></a>
                        </div>


                    </div>


                    <!-- author -->
                    <div class="section-row">
                        <div class="post-author">
                            <div class="media">
                                <div class="media-left">
                                    <img class="media-object" src="/img/author.png" alt="">
                                </div>
                                <div class="media-body">
                                    <div class="media-heading">
                                        <h3>{{$post->user->name}}</h3>
                                    </div>
                                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor
                                        incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                                        consequat.</p>
                                    <ul class="author-social">
                                        <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                                        <li><a href="#"><i class="fa fa-instagram"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /author -->
                    <hr>

                    <!-- comments -->
                    <div class="section-row">

                        {{--                    Show Login Popup to guest user to add Comment and Reply--}}
                        @guest()
                            <div class="card">
                                <h5 class="card-header">Hello Guest</h5>
                                <div class="card-body">
                                    <h5 class="card-title">Login to Add and Reply Comments</h5>
                                    <a href="/login" class="btn btn-primary">Login</a>
                                </div>
                            </div>
                    @else
                        <!-- Let a Auth User Add Comment -->
                            <div class="section-row">
                                <form class="post-addComment" action="{{route('comment.store', $post->id)}}"
                                      method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <textarea class="input" name="body"
                                                          placeholder="Leave a Comment"></textarea>
                                            </div>
                                            <button class="primary-button">Comment</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- /Add Comment -->
                    @endguest

                    <!-- Show Total Comment Count -->
                        <div class="section-title mt-4 mb-4">
                            <h2>
                                @if($post->comments()->count() > 0)

                                    {{$post->comments()->count()}} Comments

                                @else
                                    Be the first one to comment
                                @endif
                            </h2>
                        </div>

                        <div class="post-comments">
                        @foreach($post->comments()->latest()->get() as $comment)
                            <!-- comment -->
                                <div class="media mb-2">
                                    <div class="media-left">
                                        <img class="media-object" src="/img/avatar.png" alt="">
                                    </div>

                                    <div class="media-body">

                                        <div class="media-heading">
                                            <h4>{{$comment->user->name}}</h4>
                                            <p>{{$comment->body}}</p>
                                            <span class="time">{{$comment->created_at->format('d-M-Y')}}</span>

                                            <!-- Show all comment votes with their count -->
                                            @foreach($comment->votes()->get()
                                                            ->countBy(function ($item) {
                                                                return $item->vote_type_id;
                                                             })
                                                             ->mapWithKeys(function ($item, $key) {
                                                                $title = App\VoteType::findOrFail($key)->title;
                                                                return [$title => $item];
                                                            }) as $key=>$value)

                                                <a class="reply">{{$key . "(" . $value .  ")"}} </a>
                                            @endforeach


                                            <div class="btn-group btn-group-sm" role="group"
                                                 aria-label="Comment Actions">

                                            @auth
                                                <!-- Show all voting types as button -->
                                                    <div class="btn-group mr-2" role="group"
                                                         aria-label="Comment Reactions">

                                                        @foreach(App\VoteType::all() as $voteType)
                                                            <form method="POST"
                                                                  action="{{route('vote.store', $comment->id)}}">
                                                                @csrf
                                                                <input type="hidden" name="voteType"
                                                                       value="{{$voteType->id}}"/>

                                                                <button type="submit" class="btn btn-secondary

                                                            {{auth()->user()
                                                                    ->votes()
                                                                    ->get()
                                                                    ->where('comment_id', $comment->id)
                                                                    ->pluck('vote_type_id')
                                                                    ->contains($voteType->id) ? 'active' : ''}}

                                                                    ">
                                                                    {{$voteType->title}}

                                                                </button>

                                                            </form>
                                                        @endforeach

                                                    </div>
                                                    <!-- Show Reply Button to auth user -->
                                                    <div class="btn-group" role="group" aria-label="Reply Button">
                                                        <button type="button" class="btn btn-secondary .btn-sm"
                                                                onclick="showCommentForm()">Reply
                                                        </button>
                                                    </div>
                                                @endauth


                                            </div>


                                        </div>

                                        <!-- Show Total Comment Replies Count and Toggle Replies Visibility -->
                                        @if($comment->commentReplies->isNotEmpty())
                                            <a class="reply" onclick="showCommentReplies()">Show replies
                                                ({{$comment->commentReplies()->count()}})</a>
                                    @endif

                                    <!-- Add Reply -->
                                        <div class="section-row" id="addComment" style="display:none">
                                            <form class="post-addComment"
                                                  action="{{route('commentReply.store', $comment->id)}}"
                                                  method="POST">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <textarea class="input" name="body"
                                                                      placeholder="Reply Comment"></textarea>
                                                        </div>
                                                        <button class="primary-button">Reply Comment</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /Add Reply -->

                                        <!-- Comment replies -->
                                        <div class="section-row" id="commentReplies" style="display:none">
                                        @foreach($comment->commentReplies()->latest()->get() as $reply)
                                            <!-- reply -->
                                                <div class="media">
                                                    <div class="media-left">
                                                        <img class="media-object" src="/img/avatar.png" alt="">
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="media-heading">
                                                            <h4>{{$reply->user->name}}</h4>
                                                            <p>{{$reply->body}}</p>
                                                            <span
                                                                class="time">{{$reply->created_at->format('d-M-Y')}}</span>
                                                            @auth()
                                                                <a class="reply" onclick="showCommentForm()">Reply</a>
                                                            @endauth
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- /reply -->
                                            @endforeach
                                        </div>
                                        <!-- /Comment Replies -->

                                    </div>

                                </div>

                                <!-- comment -->
                        @endforeach
                        <!-- /comment -->
                        </div>
                    </div>
                    <!-- /comments -->


                </div>
                <!-- /Post content -->

                <!-- aside -->
                <div class="col-md-4">

                    <!-- post widget -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Most Read</h2>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="post.blade.php"><img src="/img/widget-1.jpg" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="post.blade.php">Tell-A-Tool: Guide To Web Design And
                                        Development Tools</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="post.blade.php"><img src="/img/widget-2.jpg" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="post.blade.php">Pagedraw UI Builder Turns Your Website
                                        Design Mockup Into Code Automatically</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="post.blade.php"><img src="/img/widget-3.jpg" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="post.blade.php">Why Node.js Is The Coolest Kid On The
                                        Backend Development Block!</a></h3>
                            </div>
                        </div>

                        <div class="post post-widget">
                            <a class="post-img" href="post.blade.php"><img src="/img/widget-4.jpg" alt=""></a>
                            <div class="post-body">
                                <h3 class="post-title"><a href="post.blade.php">Tell-A-Tool: Guide To Web Design And
                                        Development Tools</a></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /post widget -->

                    <!-- post widget -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Featured Posts</h2>
                        </div>
                        <div class="post post-thumb">
                            <a class="post-img" href="post.blade.php"><img src="/img/post-2.jpg" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-3" href="#">Jquery</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="post.blade.php">Ask HN: Does Anybody Still Use
                                        JQuery?</a></h3>
                            </div>
                        </div>

                        <div class="post post-thumb">
                            <a class="post-img" href="post.blade.php"><img src="/img/post-1.jpg" alt=""></a>
                            <div class="post-body">
                                <div class="post-meta">
                                    <a class="post-category cat-2" href="#">JavaScript</a>
                                    <span class="post-date">March 27, 2018</span>
                                </div>
                                <h3 class="post-title"><a href="post.blade.php">Chrome Extension Protects Against
                                        JavaScript-Based CPU Side-Channel Attacks</a></h3>
                            </div>
                        </div>
                    </div>
                    <!-- /post widget -->

                    <!-- catagories -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Catagories</h2>
                        </div>
                        <div class="category-widget">
                            <ul>
                                <li><a href="#" class="cat-1">Web Design<span>340</span></a></li>
                                <li><a href="#" class="cat-2">JavaScript<span>74</span></a></li>
                                <li><a href="#" class="cat-4">JQuery<span>41</span></a></li>
                                <li><a href="#" class="cat-3">CSS<span>35</span></a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /catagories -->

                    <!-- tags -->
                    <div class="aside-widget">
                        <div class="tags-widget">
                            <ul>
                                <li><a href="#">Chrome</a></li>
                                <li><a href="#">CSS</a></li>
                                <li><a href="#">Tutorial</a></li>
                                <li><a href="#">Backend</a></li>
                                <li><a href="#">JQuery</a></li>
                                <li><a href="#">Design</a></li>
                                <li><a href="#">Development</a></li>
                                <li><a href="#">JavaScript</a></li>
                                <li><a href="#">Website</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /tags -->

                    <!-- archive -->
                    <div class="aside-widget">
                        <div class="section-title">
                            <h2>Archive</h2>
                        </div>
                        <div class="archive-widget">
                            <ul>
                                <li><a href="#">January 2018</a></li>
                                <li><a href="#">Febuary 2018</a></li>
                                <li><a href="#">March 2018</a></li>
                            </ul>
                        </div>
                    </div>
                    <!-- /archive -->
                </div>
                <!-- /aside -->
            </div>
            <!-- /row -->
        </div>
        <!-- /container -->
    </div>
    <!-- /section -->
@endsection

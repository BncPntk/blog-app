<?php

    namespace App\Http\Controllers;

    use App\Models\Comment;
    use App\Models\Post;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    class CommentController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            //
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            //
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request, Post $post)
        {
            $validated = $request->validate([
                'comment' => 'required|string',
            ]);

            if (!$request->user()) {
                $guestKey = $request->session()->get('guest_key');
                if (!$guestKey) {
                    $guestKey = (string)Str::uuid();
                    $request->session()->put('guest_key', $guestKey);
                }
            }

            $comment = new Comment(['comment' => $validated['comment']]);

            if ($request->user()) {
                $comment->user()->associate($request->user());
            } else {
                $comment->guest_key = $guestKey;
            }

            $post->comments()->save($comment);

            return redirect()->route('posts.show', $post);
        }


        /**
         * Display the specified resource.
         */
        public function show(Comment $comment)
        {
            //
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Comment $comment)
        {
            //
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Comment $comment)
        {
            //
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Request $request, Comment $comment)
        {
            $comment->load('post');

            if ($request->user()) {
                $this->authorize('delete', $comment);
            } else {
                $guestKey = $request->session()->get('guest_key');
                if (!$guestKey || $comment->guest_key !== $guestKey) {
                    abort(403);
                }
            }

            $comment->delete();
            return back();
        }
    }

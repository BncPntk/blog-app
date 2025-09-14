<?php

    namespace App\Http\Controllers;

    use App\Models\Post;
    use Illuminate\Http\Request;

    class PostController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $posts = Post::with('user', 'comments')->latest()->get();

            return inertia('Posts/Index', [
                'posts' => $posts
            ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function create()
        {
            return inertia('Posts/Create');
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $request->user()->posts()->create($validated);

            return redirect()->route('posts.index');
        }

        /**
         * Display the specified resource.
         */
        public function show(Post $post)
        {
            $post->load('user', 'comments.user');

            return inertia('Posts/Show', [
                'post' => $post
            ]);
        }

        /**
         * Show the form for editing the specified resource.
         */
        public function edit(Post $post)
        {
            $this->authorize('update', $post);

            return inertia('Posts/Edit', [
                'post' => $post
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, Post $post)
        {
            $this->authorize('update', $post);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
            ]);

            $post->update($validated);

            return redirect()->route('posts.show', $post);
        }


        /**
         * Remove the specified resource from storage.
         */
        public function destroy(Post $post)
        {
            $this->authorize('delete', $post);

            $post->delete();

            return redirect()->route('posts.index');
        }
    }

<?php namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller {
    public function index()
    {
        $posts = Post::with('user')->get();
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required',
        ]);

        $post->update($request->all());

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }


    public function like(Post $post) {
        $like = new Like();
        $like->user_id = auth()->user()->id;
        $post->likes()->save($like);

        return redirect()->route('posts.show', $post)->with('success', 'Post liked successfully.');
    }

    public function comment(Request $request, Post $post) {
        $request->validate([
            'body' => 'required|max:255',
        ]);

        $comment = new Comment();
        $comment->body = $request->body;
        $comment->user_id = auth()->user()->id;
        $post->comments()->save($comment);

        return redirect()->route('posts.show', $post)->with('success', 'Comment added successfully.');
    }
}

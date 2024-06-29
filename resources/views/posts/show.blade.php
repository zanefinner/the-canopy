@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->body }}</p>
        <p>By: {{ $post->user->name }}</p>
        <p>Likes: {{ $post->likes->count() }}</p>
        
        <form action="{{ route('posts.like', $post) }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Like</button>
        </form>

        <h3>Comments</h3>
        @foreach ($post->comments as $comment)
            <div>
                <p>{{ $comment->body }}</p>
                <p>By: {{ $comment->user->name }}</p>
            </div>
        @endforeach

        <form action="{{ route('posts.comment', $post) }}" method="POST">
            @csrf
            <textarea name="body" rows="3" required></textarea>
            <button type="submit" class="btn btn-primary">Comment</button>
        </form>
    </div>
@endsection

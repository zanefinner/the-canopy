@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-body">
                <h1>{{ $post->title }}</h1>
                <p>{{ $post->body }}</p>
                <p>By: {{ $post->user->name }}</p>
                <p>Likes: {{ $post->likes->count() }}</p>
                
                <form action="{{ route('posts.like', $post) }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-primary">Like</button>
                </form>

                <h3>Comments</h3>
                @foreach ($post->comments as $comment)
                    <div class="card mb-2">
                        <div class="card-body">
                            <p>{{ $comment->body }}</p>
                            <p>By: {{ $comment->user->name }}</p>
                        </div>
                    </div>
                @endforeach

                <form action="{{ route('posts.comment', $post) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <textarea name="body" rows="3" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Comment</button>
                </form>
            </div>
        </div>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Back to Posts</a>
    </div>
@endsection

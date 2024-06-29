@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @foreach ($posts as $post)
            <div class="card mb-3">
                <div class="card-body">
                    <h2 class="card-title">
                        <a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a>
                    </h2>
                    <p class="card-text">{{ $post->body }}</p>
                    <p class="text-muted">By: {{ $post->user->name }}</p>
                    <p class="text-muted">Likes: {{ $post->likes->count() }}</p>
                    <form action="{{ route('posts.like', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary">Like</button>
                    </form>
                    <a href="{{ route('posts.edit', $post) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
        <a href="{{ route('posts.create') }}" class="btn btn-success">Create New Post</a>
    </div>
@endsection

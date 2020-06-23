@extends('layouts.app')

@section('extra-js')
    <script>
        function toggleReplyComment(id){
            let element = document.getElementById('replyComment-' + id);
            element.classList.toggle('d-none');
        }
    </script>
@endsection

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">{{ $topic->title }}</h5>
            <p>{{ $topic->content }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small>Posted at: {{$topic->created_at->format('d/m/Y à H:m')}}</small>
                <span class="badge badge-pill badge-dark p-2">{{ $topic->user->name}}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mt-2">
                    @can('update', $topic)

                <a href="{{ route('topics.edit', $topic)}}" class="btn btn-warning"> Edit Topic </a>
                @endcan
                @can('update', $topic)
                <form action="{{ route('topics.destroy', $topic)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                @endcan
                </div>
            </div>
        </div>
        <hr>
        <h5>Comments</h5>
        @forelse ($topic->comments as $comment)
            <div class="card mb-2">
                <div class="card-body d-flex justify-content-between">
                    <div>
                    {{ $comment->content }}
                    <div class="d-flex justify-content-between align-items-center">
                        <small>Posted at: {{$comment->created_at->format('d/m/Y à H:m')}}</small>
                        <span class="badge badge-pill badge-light p-2">{{ $comment->user->name}}</span>
                        </div>
                    </div>
                    <div>
                    @if (!$topic->solution && auth()->user()->id === $topic->user_id)
                    <solution-button topic-id="{{ $topic->id }}" comment-id="{{ $comment->id }}"></solution-button>  
                    @else
                    @if ($topic->solution === $comment->id)
                    <h4><span class="badge badge-success">Marked as solution</span></h4>                   
                    @endif
                    @endif
                    </div>
                </div>
            </div>
            @foreach ($comment->comments as $replyComment)
            <div class="card ml-5">
            <div class="card-body">
                {{ $replyComment->content }}
                <div class="d-flex justify-content-between align-items-center">
                    <small>Posted at: {{$replyComment->created_at->format('d/m/Y à H:m')}}</small>
                    <span class="badge badge-pill badge-light p-2">{{ $replyComment->user->name}}</span>
                    </div></div>
            </div>
            @endforeach

            @auth          
            <a class="badge badge-light" href="#" onclick="toggleReplyComment({{ $comment->id }})">Reply</a>
        <form action="{{ route('comments.storeReply', $comment) }}" method="POST" class="ml-5 mb-5 d-none" id="replyComment-{{ $comment->id }}">
        @csrf
                <div class="form-group">
                    <label for="replyComment">Add reply</label>
                    <textarea class="form-control @error('replyComment') is-invalid @enderror" name="replyComment" id="replyComment" rows="5"></textarea>
                    @error('replyComment')
                        <div class="invalid-feedback">
                            {{ $errors->first('replyComment') }}
                        </div>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Reply</button>
            </form>
            @endauth
        @empty
            <div class="alert alert-info">
                No Comment yet
            </div>
        @endforelse
    <form action="{{ route('comments.store', $topic) }}" method="post">
    @csrf
    <div class="form-group mt-5">
        <label for="content">Add Comment</label>
        <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="5"></textarea>
        @error('content')
<div class="invalid-feedback">{{ $errors->first('content') }}</div>   
    @enderror
    </div>
    
    <button class="btn btn-primary" type="submit">Add Comment</button>
    </form>
    </div>
@endsection
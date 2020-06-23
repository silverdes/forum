@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="list-group">
            @foreach ($topics as $topic)
            <div class="list-group-item">
            <h4><a href="{{ route('topics.show', $topic) }}">{{ $topic->title }}</a></h4>
            <p>{{$topic->content}}</p>
            <div class="d-flex justify-content-between align-items-center">
            <small>Posted at: {{$topic->created_at->format('d/m/Y à H:m')}}</small>
            <span class="badge badge-pill badge-dark p-2">{{ $topic->user->name}}</span>
            </div>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-3"> {{$topics->links() }}</div>
       
    </div>
@endsection
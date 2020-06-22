@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
            <h5 class="card-title">{{ $topic->title }}</h5>
            <p>{{ $topic->content }}</p>
            <div class="d-flex justify-content-between align-items-center">
                <small>Posted at: {{$topic->created_at->format('d/m/Y à H:m')}}</small>
                <span class="badge badge-danger p-2">{{ $topic->user->name}}</span>
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
    </div>
@endsection
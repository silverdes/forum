@extends('layouts.app')

@section('extra-js')
{!! NoCaptcha::renderJs() !!}
@endsection
@section('content')
    <div class="container">
        <h1>Add new Post</h1>
        <hr>
    <form action="{{ route('topics.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="title">Topic's Title</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror">
        @error('title')
    <div class="invalid-feedback">{{ $errors->first('title') }}</div>
    @enderror
    </div>
    <div class="form-group">
        <label for="content">Content</label>
        <textarea name="content" id="content" rows="5" class="form-control @error('content') is-invalid @enderror"></textarea>
        @error('content')
    <div class="invalid-feedback">{{ $errors->first('content') }}</div>
    @enderror
    </div>
    <div class="form-group">
        {!! NoCaptcha::display() !!}

        @if ($errors->has('g-recaptcha-response'))
        <span class="help-block">
            <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
        </span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">Add new Post</button>
    </form>
    </div>
@endsection
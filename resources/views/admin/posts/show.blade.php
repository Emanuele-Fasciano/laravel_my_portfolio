@extends('layouts.app')

@section('content')
    <section class="container">

        <h1 class="my-4 text-center">{{ $post->title }}</h1>
        <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">Torna alla lista</a>
        <div class="card my-4 m-auto" style="width: 60%;">
            <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">{{ $post->title }}</h5>
                <p class="card-text">{{ $post->text }}</p>
            </div>
        </div>
    </section>
@endsection

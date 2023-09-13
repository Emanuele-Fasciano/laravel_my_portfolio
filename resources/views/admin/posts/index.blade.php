@extends('layouts.app')

@section('content')
    <section class="container">

        <h1 class="my-5">Posts</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Abstract</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <th scope="row">{{ $post->id }}</th>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->getAbstract() }}</td>
                        <td><a href="{{ route('admin.posts.show', $post) }}"><i class="bi bi-eye"></i></a></td>
                    </tr>
                @empty
                    <h1>Non ci sono post</h1>
                @endforelse
            </tbody>
        </table>

        {{ $posts->links() }}
    </section>
@endsection

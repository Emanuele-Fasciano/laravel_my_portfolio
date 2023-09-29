@extends('layouts.app')

@section('content')
    <section class="container">
        <div class="head d-flex justify-content-between align-items-center">
            <h1 class="my-5">Posts</h1>
            <a class="btn btn-primary" href="{{ route('admin.posts.create') }}">Crea nuovo post</a>
        </div>
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
                        <td><a href="{{ route('admin.posts.show', $post) }}"><i class="bi bi-eye mx-2"></i></a>
                            <a href="{{ route('admin.posts.edit', $post) }}"><i class="bi bi-pencil mx-2"></i></a>
                            <i class="bi bi-trash mx-2 text-danger" data-bs-toggle="modal"
                                data-bs-target="#my-modal-{{ $post->id }}"></i>
                        </td>
                    </tr>
                @empty
                    <h1>Non ci sono post</h1>
                @endforelse
            </tbody>
        </table>

        {{ $posts->links() }}
    </section>

    @section('modals')
        @foreach ($posts as $post)
            <div class="modal fade" id="my-modal-{{ $post->id }}" tabindex="-1"
                aria-labelledby="my-modal-{{ $post->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="my-modal-{{ $post->id }}">Elimina post</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Sei sicuro di voler eliminare il post: "{{ $post->title }}"
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>

                            <form method="POST" action="{{ route('admin.posts.destroy', $post) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">Elimina</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endsection
@endsection

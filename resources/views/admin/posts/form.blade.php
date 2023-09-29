@extends('layouts.app')
@section('title')
    <div class="head d-flex justify-content-between align-items-center my-4">
        @if ($post->id)
            <h1>Modifica {{ $post->title }}</h1>
        @else
            <h1>Crea nuovo post</h1>
        @endif
        <a class="btn btn-primary" href="{{ route('admin.posts.index') }}">Torna alla lista</a>
    </div>
@endsection
@section('content')
    @if ($post->id)
        <form class="my-5 row" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" method="POST">
            @method('put')
        @else
            <form class="my-5 row" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" method="POST">
    @endif
    @csrf
    <div class="col-6">
        <label class="mt-4 form-label" for="title">Title</label>
        <input type="text" name="title" id="title" value="{{ old('title', $post->title) }}"
            class="form-control @error('title') is-invalid @enderror">
        @error('title')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="col-4">
        <label class="mt-4 form-label" for="image">Image</label>
        <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
        @error('image')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="anteprima col-2">
        <img src="{{ $post->image ? asset('storage/' . $post->image) : 'https://www.areafit.it/wp-content/uploads/2022/08/placeholder.png' }}"
            class="img-fluid" alt="" id="image_preview">
    </div>

    <div>
        <label class="mt-4 form-label" for="text">Text</label>
        <textarea type="text" name="text" id="text" class="form-control @error('text') is-invalid @enderror">{{ old('text', $post->text) }}</textarea>
        @error('text')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>
    <input class="btn btn-primary mt-4 col offset-11 me-2" type="submit" value="Salva">
    </form>
@endsection

@section('script')
    <script>
        const imageEl = document.getElementById('image');
        const imagePreviewEl = document.getElementById('image_preview');
        const imagePlaceholder = imagePreviewEl.src;
        imageEl.addEventListener(
            'change', () => {
                if (imageEl.files && imageEl.files[0]) {
                    const reader = new FileReader();
                    reader.readAsDataURL(imageEl.files[0]);
                    reader.onload = e => {
                        imagePreviewEl.src = e.target.result;
                    }
                } else {
                    imagePreviewEl.src = imagePlaceholder;
                }
            });
    </script>
@endsection

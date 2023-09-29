<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts =  Post::orderBy('updated_at', 'DESC')->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $post = new Post;
        return view('admin.posts.form', compact('post'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpg, png, jpeg',
                'text' => 'required|string'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'title.max:100' => 'Il titolo deve avere un massimo di 100 caratteri',
                'image.image' => 'Il file caricato deve essere un\' immagine',
                'image.mimes' => 'L\' immagine deve essere nei seguenti formati: jpg, png, jpeg',
                'text.required' => 'Il conutenuto è obbligatorio',
                'text.string' => 'Il contenuto deve essere una stringa'
            ]
        );


        $data = $request->all();

        // uso la classe helper 'Arr'(va importata) per controllare se l'immagine è stata caricata (dato che è nullable),
        // se è stata caricata inseriscila nello storage
        if (Arr::exists($data, 'image')) {
            $pathImg = Storage::put('uploads/posts', $data['image']);
            $data['image'] = $pathImg;  // salvo il path dell' immagine nel database
        }

        $post = new Post;
        $post->fill($data);
        $post->slug = Str::of($post->title)->slug('-');
        $post->save();

        return to_route('admin.posts.show', $post)
            ->with('message', 'Post creato con successo!'); // crea una variabile flash (message) 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $request->validate(
            [
                'title' => 'required|string|max:100',
                'image' => 'nullable|image|mimes:jpg, png, jpeg',
                'text' => 'required|string'
            ],
            [
                'title.required' => 'Il titolo è obbligatorio',
                'title.string' => 'Il titolo deve essere una stringa',
                'title.max:100' => 'Il titolo deve avere un massimo di 100 caratteri',
                'image.image' => 'Il file caricato deve essere un\' immagine',
                'image.mimes' => 'L\' immagine deve essere nei seguenti formati: jpg, png, jpeg',
                'text.required' => 'Il conutenuto è obbligatorio',
                'text.string' => 'Il contenuto deve essere una stringa'
            ]
        );


        $data = $request->all();

        // uso la classe helper 'Arr'(va importata) per controllare se l'immagine è stata caricata (dato che è nullable),
        if (Arr::exists($data, 'image')) {
            if ($post->image) Storage::delete($post->image); // elimino la vecchia immagine del post
            $pathImg = Storage::put('uploads/posts', $data['image']); // aggiungo la nuova immagine
        }

        $post->fill($request->all());
        $post->slug = Str::of($post->title)->slug('-');
        $post->image = $pathImg; // salvo il path dell' immagine nel database
        $post->save();


        return to_route('admin.posts.show', $post)
            ->with('message', 'Post modificato con successo!'); // crea una variabile flash (message)
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();

        return to_route('admin.posts.index')
            ->with('message', 'Post eliminato con successo!') // crea una variabile flash (message)
            ->with('message_type', 'danger'); // crea un' altra variabile flash (message_type) per dinamicizzare il colore dell'alert
    }
}

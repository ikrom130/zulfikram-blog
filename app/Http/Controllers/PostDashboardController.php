<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PostDashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::latest()->where('author_id', Auth::user()->id);

        if (request('searchPost')) {
            $posts->where('title', 'like', '%' . request('searchPost') . '%');
        }

        return view('dashboard.index', ['posts' => $posts->paginate(7)->withQueryString()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.createPost');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $request->validate([
        //     'title' => 'required|min:2|max:255',
        //     'category_id' => 'required',
        //     'body' => 'required',
        // ]);

        Validator::make($request->all(), [
            'title' => 'required|unique:posts|min:2|max:255',
            'category_id' => 'required',
            'body' => 'required|min:20',
        ],
        [
            'title.required' => 'Field :attribute harus diisi!.',
            'title.unique' => ':attribute sudah ada, silahkan ganti yang lain!.',
            'title.min' => 'Filed :attribute minimal harus 2 karakter!.',
            'title.max' => 'Field :attribute maksimal harus 255 karakter!.',
            'category_id.required' => 'Harus pilih salah satu :attribute.',
            'body.required' => 'Field :attribute tidak boleh kosong!.',
            'body.min' => ':attribute harus lebih dari :min karakter'
        ],
        [
            'title' => 'Judul',
            'category_id' => 'Category',
            'body' => 'Isi Post',
        ])->validate();

        Post::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'author_id' => Auth::user()->id,
            'category_id' => $request->category_id,
            'body' => $request->body,
        ]);

        return redirect('/dashboard')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.editPost', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //validation data
        $request->validate([
            'title' => 'required|min:2|max:255|unique:posts,title,' . $post->id,
            'category_id' => 'required',
            'body' => 'required',
        ]);

        //action update data
        $post->update([
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'category_id' => $request->category_id,
            'body' => $request->body,
        ]);

        //redirect
        return redirect('/dashboard')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect('/dashboard')->with('success', 'Post has been deleted!');
    }
}

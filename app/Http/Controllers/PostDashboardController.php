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

        return view('dashboard.show', ['posts' => $posts->paginate(7)->withQueryString()]);
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
            'body' => 'required',
        ],
        [
            'title.required' => 'Field :attribute harus diisi!.',
            'title.unique' => ':attribute sudah ada, silahkan ganti yang lain!.',
            'title.min' => 'Filed :attribute minimal harus 2 karakter!.',
            'title.max' => 'Field :attribute maksimal harus 255 karakter!.',
            'category_id.required' => 'Harus pilih salah satu :attribute.',
            'body.required' => 'Field :attribute tidak boleh kosong!.',
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

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

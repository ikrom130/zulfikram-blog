<?php

use App\Models\Post;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('home', ['title' => 'Home Page']);
});

Route::get('/home', function () {
    return view('home', ['title' => 'Home Page']);
});

Route::get('/services', function () {
    $posts = Post::latest()
        ->filter(request(['search', 'category', 'author']))
        ->paginate(5)
        ->withQueryString();

    return view('services', ['title' => 'Service Page', 'posts' => $posts]);
});

Route::get('/about', function () {
    return view('about', ['title' => 'About Me']);
});

Route::get('/article/{post:slug}', function (Post $post) {

    return view('article', ['title' => 'Single Post', 'post' => $post]);
});

Route::get('/contact', function () {
    return view('contact', ['title' => 'About Page']);
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

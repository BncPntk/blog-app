<?php

    use App\Http\Controllers\CommentController;
    use App\Http\Controllers\PostController;
    use App\Http\Controllers\ProfileController;
    use Illuminate\Foundation\Application;
    use Illuminate\Support\Facades\Route;
    use Inertia\Inertia;


    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->middleware(['auth', 'verified'])->name('dashboard');

    Route::middleware('auth')->group(function () {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });

    require __DIR__ . '/auth.php';


    Route::get('/', [PostController::class, 'index'])->name('home');

    Route::middleware('auth')->group(function () {
        Route::resource('posts', PostController::class)->except(['index', 'show']);
    });

    Route::resource('posts', PostController::class)->only(['index', 'show']);

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


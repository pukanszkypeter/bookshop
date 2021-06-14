<?php

use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\BookController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resources([
    'books' => BookController::class,
    'genres' => GenreController::class,
]);

Route::get('/', function () {
    return redirect()->route('books.index');
});

Route::get('/home', function () {
    return redirect()->route('books.index');
});

Route::get('/search', [BookController::class, 'search'])->name('books.search');

Route::get('/reader/rentals/pending', [BorrowController::class, 'pendingReader'])->name('reader.borrows.index.pending');

Route::get('/reader/rentals/rejected', [BorrowController::class, 'rejectedReader'])->name('reader.borrows.index.rejected');

Route::get('/reader/rentals/accepted', [BorrowController::class, 'acceptedReader'])->name('reader.borrows.index.accepted');

Route::get('/reader/rentals/returned', [BorrowController::class, 'returnedReader'])->name('reader.borrows.index.returned');

Route::get('/reader/rentals/delay', [BorrowController::class, 'delayReader'])->name('reader.borrows.index.delay');

Route::get('/reader/rentals/{borrowID}', [BorrowController::class, 'show'])->name('reader.borrows.show');

Route::get('/reader/borrows/{book}', [BorrowController::class, 'create'])->name('reader.borrows.create');

Route::post('/reader/borrows', [BorrowController::class, 'store'])->name('reader.borrows.store');

Route::get('/reader/profile', [HomeController::class, 'reader'])->name('reader.profile');

Route::get('/librarian/profile', [HomeController::class, 'librarian'])->name('librarian.profile');

Route::get('/librarian/rentals/pending', [BorrowController::class, 'pendingLibrarian'])->name('librarian.borrows.index.pending');

Route::get('/librarian/rentals/rejected', [BorrowController::class, 'rejectedLibrarian'])->name('librarian.borrows.index.rejected');

Route::get('/librarian/rentals/accepted', [BorrowController::class, 'acceptedLibrarian'])->name('librarian.borrows.index.accepted');

Route::get('/librarian/rentals/returned', [BorrowController::class, 'returnedLibrarian'])->name('librarian.borrows.index.returned');

Route::get('/librarian/rentals/delay', [BorrowController::class, 'delayLibrarian'])->name('librarian.borrows.index.delay');

Route::get('/librarian/rentals/{borrowID}', [BorrowController::class, 'edit'])->name('librarian.borrows.edit');

Route::post('/librarian/borrows', [BorrowController::class, 'update'])->name('librarian.borrows.update');

Auth::routes();

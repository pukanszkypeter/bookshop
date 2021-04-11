<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Genre;
use App\Models\User;
use Illuminate\Http\Request;
use Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $books = Book::paginate(9);
        $genres = Genre::all();
        $usersCount = User::readers();
        $booksCount = Book::count(); //availableCount();
        $genresCount = Genre::count();
        return view('books.index', ['books' => $books, 'genres' => $genres, 'usersCount' => $usersCount, 'booksCount' => $booksCount, 'genresCount' => $genresCount]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('books.create', ['genres' => $genres]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date|before:today',
                'language_code' => 'required|min:2|max:2',
                'pages' => 'required|integer|min:1|max:3000',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i|unique:books',
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'attachment' => 'file|nullable|mimes:jpg,png|max:1024',
                'in_stock' => 'required|integer|min:0|max:3000'
            ],
            [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute field must be at least: :min long.',
                'max' => 'The :attribute field must be max: :max long.',
                'integer' => 'The :attribute field must be a number.',
                'attachment.max' => 'The file size can only be max 1 MB.',
                'released_at.before' => 'Release date can only be in the past.',
                'unique' => 'This ISBN already exists.',
            ]
        );

        if ($request->hasFile('attachment')) {

            $file = $request->file('attachment');
            $nextID = Book::all()->last()->id + 1;
            $fileName = 'cover_' . $nextID . '.' . $file->extension();
            Storage::disk('book_covers')->put('/' . $fileName, $file->get());
            $validated['cover_image'] = $fileName;

        }

        $book = Book::create($validated);

        $book->genres()->attach($request->genres);

        $request->session()->flash('book-created', $book->title);
        return redirect()->route('books.create');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        $genres = Genre::all();
        return view('books.edit', ['genres' => $genres, 'book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {

        $validated = $request->validate(
            [
                'title' => 'required|min:3|max:255',
                'authors' => 'required|min:3|max:255',
                'released_at' => 'required|date|before:today',
                'language_code' => 'required|min:2|max:2',
                'pages' => 'required|integer|min:1|max:3000',
                'isbn' => 'required|regex:/^(?=(?:\D*\d){10}(?:(?:\D*\d){3})?$)[\d-]+$/i|unique:books,' . $book->id,
                'description' => 'nullable',
                'genres' => 'nullable',
                'genres.*' => 'integer|distinct|exists:genres,id',
                'in_stock' => 'required|integer|min:0|max:3000',
                'remove_cover' => 'nullable|boolean',
                'attachment' => 'file|nullable|mimes:jpg,png|max:1024',
            ],
            [
                'required' => 'The :attribute field is required.',
                'min' => 'The :attribute field must be at least: :min long.',
                'max' => 'The :attribute field must be max: :max long.',
                'integer' => 'The :attribute field must be a number.',
                'attachment.max' => 'The file size can only be max 1 MB.',
                'released_at.before' => 'Release date can only be in the past.',
                'unique' => 'This ISBN already exists.',
            ]
        );

        if($request->remove_cover == 1) {
            Storage::disk('book_covers')->delete('/' . $book->cover_image);
            $validated['cover_image'] = null;
        }

        if ($request->hasFile('attachment')) {
            if($book->hasAttachment()) {
                Storage::disk('book_covers')->delete('/' . $book->cover_image);
                $validated['cover_image'] = null;
            }
            $file = $request->file('attachment');
            $fileName = 'cover_' . $book->id . '.' . $file->extension();
            Storage::disk('book_covers')->put('/' . $fileName, $file->get());
            $validated['cover_image'] = $fileName;

        }

        $book->update($validated);

        $book->genres()->detach();
        $book->genres()->attach($request->genres);

        $request->session()->flash('book-updated', $book->title);
        return redirect()->route('books.edit', $book);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $book = Book::find($id);

        if ($book->borrows()->count() > 0) {
            $request->session()->flash('book-delete-failed', $book->borrows()->count());
            return redirect()->route('books.index');
        }
        else {
            if ($book->hasAttachment()) {
                Storage::disk('book_covers')->delete('/' . $book->cover_image);
            }
            $title = $book->title;
            $book->delete();

            $request->session()->flash('book-deleted', $title);
            return redirect()->route('books.index');
        }

    }
}

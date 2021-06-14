<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\User;

class BorrowController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Book $book)
    {
        return view('reader.borrows.create', ['book' => $book]);
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
                'description' => 'nullable|max:255',
            ],
            [
                'max' => 'The :attribute field must be max: :max long.',
            ]
        );

        $userID = $request->input('userID');
        $bookID = $request->input('bookID');
        Borrow::create([
            'reader_id' => $userID,
            'book_id' => $bookID,
            'status' => 'PENDING',
            'reader_message' => $validated['description'],
        ]);

        $book = Book::findOrFail($bookID);

        $request->session()->flash('borrow-created', $book->title);
        return redirect()->route('books.show', $book);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $borrowID
     * @return \Illuminate\Http\Response
     */
    public function show($borrowID)
    {
        $borrow = Borrow::find($borrowID);
        $reader = User::find($borrow->reader_id);
        $request_librarian = User::find($borrow->request_managed_by);
        $return_librarian = User::find($borrow->return_managed_by);
        $book = Book::find($borrow->book_id);

        return view('reader.borrows.show', ['borrow' => $borrow, 'reader' => $reader, 'request_librarian' => $request_librarian,
        'return_librarian' => $return_librarian, 'book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($borrowID)
    {
        $borrow = Borrow::find($borrowID);
        $reader = User::find($borrow->reader_id);
        $request_librarian = User::find($borrow->request_managed_by);
        $return_librarian = User::find($borrow->return_managed_by);
        $book = Book::find($borrow->book_id);

        return view('librarian.borrows.edit', ['borrow' => $borrow, 'reader' => $reader, 'request_librarian' => $request_librarian,
        'return_librarian' => $return_librarian, 'book' => $book]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validated = $request->validate(
            [
                'deadline' => 'nullable|after:today',
                'request_processed_message' => 'nullable|max:255'
            ],
            [
                'deadline.after' => 'Deadline can only be in the future.',
                'max' => 'The note length can only be max. 255 character.'
            ]
        );

        if ($request->has('status')) {

            $borrow = Borrow::find($request->input('id'));
            $librarian = User::find($request->input('librarian'));

            if ($request->input('status') == 'ACCEPTED') {
                $borrow->update([
                    'status' => 'ACCEPTED',
                    'request_processed_at' => date('Y.m.d'),
                    'request_managed_by' => $librarian->id,
                    'request_processed_message' => $request->input('request_processed_message'),
                    'deadline' => str_replace('-','.',$request->input('deadline'))
                ]);
            } else if ($request->input('status') == 'REJECTED') {
                $borrow->update([
                    'status' => 'REJECTED',
                    'request_processed_at' => date('Y.m.d'),
                    'request_managed_by' => $librarian->id,
                    'request_processed_message' => $request->input('request_processed_message')
                ]);
            } else if ($request->input('status') == 'RETURNED') {
                $borrow->update([
                    'status' => 'RETURNED',
                    'returned_at' => date('Y.m.d'),
                    'return_managed_by' => $librarian->id
                ]);
            }

            $request->session()->flash('borrow-updated');
            return redirect()->route('librarian.borrows.edit', $borrow->id);

        } else {

            $borrow = Borrow::find($request->input('id'));
            $request->session()->flash('borrow-updated-wrong');
            return redirect()->route('librarian.borrows.edit', $borrow->id);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function pendingReader() {
        return view('reader.borrows.types.pending');
    }

    public function rejectedReader() {
        return view('reader.borrows.types.rejected');
    }

    public function acceptedReader() {
        return view('reader.borrows.types.accepted');
    }

    public function returnedReader() {
        return view('reader.borrows.types.returned');
    }

    public function delayReader() {
        return view('reader.borrows.types.delayed');
    }

    public function pendingLibrarian() {
        $pendings = Borrow::where('status', 'PENDING')->get();
        return view('librarian.borrows.types.pending', ['pendings' => $pendings]);
    }

    public function rejectedLibrarian() {
        $rejected = Borrow::where('status', 'REJECTED')->get();
        return view('librarian.borrows.types.rejected', ['rejected' => $rejected]);
    }

    public function acceptedLibrarian() {
        $accepted = Borrow::where('status', 'ACCEPTED')->get();
        return view('librarian.borrows.types.accepted', ['accepted' => $accepted]);
    }

    public function returnedLibrarian() {
        $returned = Borrow::where('status', 'RETURNED')->get();
        return view('librarian.borrows.types.returned', ['returned' => $returned]);
    }

    public function delayLibrarian() {
        $delayed = Borrow::where('status', 'ACCEPTED')->where('deadline', '<', date('Y.m.d'))->get();
        return view('librarian.borrows.types.delayed', ['delayed' => $delayed]);
    }
}

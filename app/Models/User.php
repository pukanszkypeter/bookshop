<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Book;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_librarian'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // User 1-N Borrow - reader
    public function borrows() {
        return $this->hasMany(Borrow::class, 'reader_id');
    }

    // User 1-N Borrow - request_manager
    public function requests() {
        return $this->hasMany(Borrow::class, 'request_managed_by');
    }

    // User 1-N Borrow - return_manager
    public function returns() {
        return $this->hasMany(Borrow::class, 'return_managed_by');
    }

    // Librarian
    public function isLibrarian() {
        if ($this->is_librarian == 1) {
            return true;
        }
        else {
            return false;
        }
    }

    // Get Readers
    public static function readers() {
        $all = User::all();
        $counter = 0;
        foreach($all as $al) {
            if (!$al->isLibrarian()) {
                $counter = $counter + 1;
            }
        }
        return $counter;
    }

    // Already Borrowed
    public function isAlreadyBorrowed(Book $book) {

        $result = false;

        $borrows = $this->borrows;
        foreach($borrows as $borrow) {
            if ($borrow->book_id == $book->id) {
                if($borrow->status == 'ACCEPTED' || $borrow->status == 'PENDING') {
                    $result = true;
                }
            }
        }

        return $result;
    }

    public function getBorrowsByStatus(String $status) {
        $borrows = $this->borrows();

        if ($status == 'PENDING') {

            return $borrows->where('status', 'PENDING')->get();

        }
        else if ($status == 'ACCEPTED') {

            return $borrows->where('status', 'ACCEPTED')->get();

        }
        else if ($status == 'RETURNED') {

            return $borrows->where('status', 'RETURNED')->get();

        }
        else if ($status == 'REJECTED') {

            return $borrows->where('status', 'REJECTED')->get();

        }
    }

    public function getDelayedBorrows() {

        $borrows = $this->getBorrowsByStatus('ACCEPTED');
        $delayedBorrows = [];
        $dateNow = date('Y.m.d');

        for($i = 0; $i < $borrows->count(); $i++) {
            if ( $borrows[$i]->deadline < $dateNow ) {
                array_push($delayedBorrows, $borrows[$i]);
            }
        }

        return $delayedBorrows;
    }

    public function getDelayedBorrowsFromPast() {

        $borrows = $this->getBorrowsByStatus('RETURNED');
        $delayedBorrows = [];

        for($i = 0; $i < $borrows->count(); $i++) {
            if ( $borrows[$i]->deadline < $borrows[$i]->returned_at ) {
                array_push($delayedBorrows, $borrows[$i]);
            }
        }

        return $delayedBorrows;
    }

}

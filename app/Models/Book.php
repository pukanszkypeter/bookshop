<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'authors',
        'description',
        'released_at',
        'cover_image',
        'pages',
        'language_code',
        'isbn',
        'in_stock',
        'attachment_original_name',
        'attachment_hash_name'
    ];

    // Book N-N Genre
    public function genres() {
        return $this->belongsToMany(Genre::class)->withTimestamps();
    }

    // Book 1-N Borrow
    public function borrows() {
        return $this->hasMany(Borrow::class, 'book_id');
    }

    // Available Books Count
    public static function availableBooks() {
        $books = Book::all();
        $counter = 0;
        foreach($books as $book) {
            if ($book->isAvailable()) {
                $counter = $counter + 1;
            }
        }
        return $counter;
    }

    // ACCEPTED Borrows
    public function getAcceptedBorrows() {
        $list = $this->borrows()->get();
        $accepted = [];
        foreach ($list as $li) {
            if ($li->status == 'ACCEPTED') {
                array_push($accepted, $li);
            }
        }
        return $accepted;
    }

    // ACCEPTED Borrows Count
    public function getAcceptedBorrowsCount() {
        $list = $this->borrows()->get();
        $accepted = [];
        foreach ($list as $li) {
            if ($li->status == 'ACCEPTED') {
                array_push($accepted, $li);
            }
        }
        $length = count($accepted);
        return $length;
    }

    // Available Counts
    public function getAvaliableCount() {
        $list = $this->getAcceptedBorrows();
        $out_stock = count($list);
        $in_stock = $this->in_stock;

        $available = $in_stock - $out_stock;

        return $available;
    }

    // Available
    public function isAvailable() {
        $in_stock = $this->getAvaliableCount();

        if ($in_stock > 0) {
            return true;
        } else {
            return false;
        }
    }

    // Cover Image URL
    public function hasAttachment() {
        return $this->attachment_hash_name;
    }

    // Format Date
    public function dateFormat() {
        $date = new DateTime($this->released_at);
        return date_format($date, 'Y. m. d.');
    }

}

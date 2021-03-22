<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;

    protected $fillable = [
        'reader_id',
        'book_id',
        'status',
        'request_processed_at',
        'request_managed_by',
        'request_processed_message',
        'deadline',
        'returned_at',
        'return_managed_by'
    ];

    // Book 1-N Borrow
    public function book() {
        return $this->belongsTo(Book::class);
    }

    // User 1-N Borrow - reader
    public function reader() {
        return $this->belongsTo(User::class);
    }

    // User 1-N Borrow - request_manager
    public function request_manager() {
        return $this->belongsTo(User::class);
    }

    // User 1-N Borrow - return_manager
    public function return_manager() {
        return $this->belongsTo(User::class);
    }
}

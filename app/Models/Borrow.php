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
        'reader_message',
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
        return $this->belongsTo(Book::class, 'book_id');
    }

    // User 1-N Borrow - reader
    public function reader() {
        return $this->belongsTo(User::class, 'reader_id');
    }

    // User 1-N Borrow - request_manager
    public function request_manager() {
        return $this->belongsTo(User::class, 'request_managed_by');
    }

    // User 1-N Borrow - return_manager
    public function return_manager() {
        return $this->belongsTo(User::class, 'return_managed_by');
    }
}

<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

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

}

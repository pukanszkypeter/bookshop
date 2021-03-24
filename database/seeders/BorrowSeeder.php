<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Borrow;

class BorrowSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('borrows')->truncate();

        $possible_status = ['PENDING', 'ACCEPTED', 'REJECTED', 'RETURNED'];

        Borrow::create([ // PENDING
            'reader_id' => 1,
            'book_id' => 4,
            'status' => $possible_status[0],
            'request_processed_at' => NULL,
            'request_managed_by' => NULL,
            'request_processed_message' => NULL,
            'deadline' => NULL,
            'returned_at' => NULL,
            'return_managed_by' => NULL,
        ]);

        $date = date('Y.m.d', time());
        $deadline = date('Y.m.d', strtotime('+20 day', time()));
        $returned_at = date('Y.m.d', strtotime('+18 day', time()));

        Borrow::create([ // ACCEPTED
            'reader_id' => 3,
            'book_id' => 15,
            'status' => $possible_status[1],
            'request_processed_at' => $date,
            'request_managed_by' => 7,
            'request_processed_message' => "Have fun reading!",
            'deadline' => $deadline,
            'returned_at' => NULL,
            'return_managed_by' => NULL,
        ]);

        Borrow::create([ // ACCEPTED
            'reader_id' => 4,
            'book_id' => 15,
            'status' => $possible_status[1],
            'request_processed_at' => $date,
            'request_managed_by' => 6,
            'request_processed_message' => "Have fun reading!",
            'deadline' => $deadline,
            'returned_at' => NULL,
            'return_managed_by' => NULL,
        ]);

        Borrow::create([ // REJECTED
            'reader_id' => 5,
            'book_id' => 10,
            'status' => $possible_status[2],
            'request_processed_at' => $date,
            'request_managed_by' => 9,
            'request_processed_message' => "You have book debts, please return it!",
            'deadline' => NULL,
            'returned_at' => NULL,
            'return_managed_by' => NULL,
        ]);

        Borrow::create([ // RETURNED
            'reader_id' => 4,
            'book_id' => 12,
            'status' => $possible_status[3],
            'request_processed_at' => $date,
            'request_managed_by' => 6,
            'request_processed_message' => "Have fun reading!",
            'deadline' => $deadline,
            'returned_at' => $returned_at,
            'return_managed_by' => 7,
        ]);
    }
}

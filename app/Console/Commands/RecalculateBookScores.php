<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;

class RecalculateBookScores extends Command
{
    protected $signature   = 'books:recalculate-scores';
    protected $description = 'Recalculate smart ranking scores for all books';

    public function handle(): void
    {
        $books = Book::with('reviews')->get();

        $this->info("Recalculating scores for {$books->count()} books...");

        $bar = $this->output->createProgressBar($books->count());
        $bar->start();

        foreach ($books as $book) {
            // Order count sync
            $orderCount = $book->orders()
                ->whereIn('status', ['confirmed', 'shipped', 'delivered'])
                ->count();

            $book->update(['order_count' => $orderCount]);
            $book->updateScore();

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('All book scores recalculated successfully!');
    }
}
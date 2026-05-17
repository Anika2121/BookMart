<?php

namespace App\Mail;

use App\Models\Book;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PriceDropAlert extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Book $book,
        public float $oldPrice,
        public User $user
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: '📉 Price Drop Alert — ' . $this->book->title);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.price-drop-alert');
    }
}
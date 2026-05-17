<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'book_id',
        'user_id',
        'rating',
        'comment',
        'helpful_count',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function helpfulVotes()
    {
        return $this->hasMany(ReviewHelpfulVote::class);
    }

    public function isHelpfulVotedBy(?int $userId): bool
    {
        if (!$userId) return false;
        return $this->helpfulVotes()->where('user_id', $userId)->exists();
    }
}
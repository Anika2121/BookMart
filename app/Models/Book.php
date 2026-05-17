<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Mail\PriceDropAlert;
use Illuminate\Support\Facades\Mail;

class Book extends Model
{
    protected $fillable = [
        'title', 'author', 'isbn', 'publisher', 'language',
        'pages', 'published_year', 'sample_pages', 'price',
        'condition', 'user_id', 'category_id', 'image',
        'status', 'description', 'view_count', 'order_count',
        'score', 'is_featured',
    ];

    protected $casts = [
        'price'          => 'decimal:2',
        'pages'          => 'integer',
        'published_year' => 'integer',
        'view_count'     => 'integer',
        'order_count'    => 'integer',
        'score'          => 'decimal:4',
        'is_featured'    => 'boolean',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function seller()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function averageRating(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function isWishlistedBy(?int $userId): bool
    {
        if (!$userId) return false;
        return $this->wishlists()->where('user_id', $userId)->exists();
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available';
    }

    public function calculateScore(): float
    {
        $orderScore   = min($this->order_count * 10, 40);
        $avgRating    = $this->reviews()->avg('rating') ?? 0;
        $ratingScore  = ($avgRating / 5) * 30;
        $reviewCount  = $this->reviews()->count();
        $reviewScore  = min($reviewCount * 1.5, 15);
        $daysSince    = now()->diffInDays($this->created_at);
        $recencyScore = max(0, 15 - ($daysSince * 0.5));

        return round($orderScore + $ratingScore + $reviewScore + $recencyScore, 4);
    }

    public function updateScore(): void
    {
        $this->update(['score' => $this->calculateScore()]);
    }

    public function notifyPriceDrop(float $oldPrice): void
    {
        if ($this->price >= $oldPrice) return;

        $wishlists = $this->wishlists()->where('price_alert', true)->with('user')->get();

        foreach ($wishlists as $wishlist) {
            try {
                Mail::to($wishlist->user->email)->send(new PriceDropAlert($this, $oldPrice, $wishlist->user));
            } catch (\Exception $e) {
                // Continue even if mail fails
            }
        }
    }
}
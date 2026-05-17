<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'avatar',
        'google_id',
        'facebook_id',
        'deletion_requested_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at'     => 'datetime',
        'password'              => 'hashed',
        'deletion_requested_at' => 'datetime',
    ];

    public function isBuyer(): bool
    {
        return $this->role === 'buyer';
    }

    public function isSeller(): bool
    {
        return $this->role === 'seller';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasRequestedDeletion(): bool
    {
        return $this->deletion_requested_at !== null;
    }

    public function books()
    {
        return $this->hasMany('App\Models\Book');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'buyer_id');
    }

    public function buyerOrders()
    {
        return $this->hasMany('App\Models\Order', 'buyer_id');
    }

    public function sellerOrders()
    {
        return $this->hasManyThrough(
            'App\Models\Order',
            'App\Models\Book',
            'user_id',
            'book_id'
        );
    }

    public function reviews()
    {
        return $this->hasMany('App\Models\Review');
    }

    public function wishlists()
    {
        return $this->hasMany('App\Models\Wishlist');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }
}
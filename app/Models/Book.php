<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'tags',
        'author',
        'description',
        'image'
    ];

    protected function averageRating(): Attribute
    {
        return new Attribute(
            get: fn (): float => round(Book::find($this->id)->ratings()->avg('rating'),2)
        );
    }

    protected $appends = ['average_rating'];

    /**
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class, 'book_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'book_id');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'book_collection');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_book');
    }

}

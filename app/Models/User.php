<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected function followerCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => $this->followers()->count()
        );
    }

    protected function followingCount(): Attribute
    {
        return new Attribute(
            get: fn (): int => $this->followings()->count()
        );
    }

    protected $appends = ['follower_count', 'following_count'];


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at',
        'email_verified_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id');
    }

    public function books()
    {
        return $this->belongsToMany(Book::class, 'user_book');
    }

    public function collections()
    {
        return $this->hasMany(Collection::class, 'user_id');
    }

    public function followings()
    {
        return $this->hasMany(Following::class, 'follower_id');
    }

    public function followers()
    {
        return $this->hasMany(Following::class, 'following_id');
    }

}

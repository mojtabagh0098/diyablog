<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Mode;
use Illuminate\Database\Eloquent\Relations\HasMany;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all of the role for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
     public function role()
     {
         return $this->belongsTo('App\Models\Role');
     }

    /**
     * Get all of the post for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function post(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Get all of the comments for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comment(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }
}

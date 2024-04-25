<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
     protected $fillable = [
         'id', 'fname', 'lname', 'username', 'email', 'password',
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
     * The attributes for the primary key.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id';
    /**
     * The attributes disabling auto increment
     *
     * @var array<int, string>
     */
    public $incrementing = false;


    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //relationship with posts table
    public function posts() {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function products() {
        return $this->hasMany(Product::class, 'seller_id');
    }
}

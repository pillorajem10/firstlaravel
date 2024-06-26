<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'posts';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // fillables
    protected $fillable = ['title', 'body'];

    //model relationship (apply foreign key)
    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}

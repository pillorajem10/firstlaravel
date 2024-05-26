<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // Table Name
    protected $table = 'products';

    // Primary Key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // fillables
    protected $fillable = [
      'name',
      'price',
      'image',
      'stocks',
      'description',
    ];

    //model relationship (apply foreign key)
    public function seller() {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}

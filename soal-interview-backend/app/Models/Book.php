<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Book extends Model
{
    use HasFactory;

    protected $table = "books";
    protected $fillable = ["title", "author", "category_id", "is_borrowed"];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'content_id'
    ];

    public function item()
    {
        return $this->hasOne(Item::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}

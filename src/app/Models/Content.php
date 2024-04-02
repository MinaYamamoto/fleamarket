<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function category()
    {
        return $this->belongsToMany(Category::class);
    }

    public function categorycontent() {
        return $this->hasMany(CategoryContent::class);
    }

}

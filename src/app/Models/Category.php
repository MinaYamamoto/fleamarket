<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function content()
    {
        return $this->belongsToMany(Content::class);
    }

    public function categorycontent() {
        return $this->hasMany(CategoryContent::class);
    }

}

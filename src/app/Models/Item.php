<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_content_id',
        'condition_id',
        'name',
        'brand_name',
        'explanation',
        'price',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);
    }

    public function category_content()
    {
        return $this->belongsTo(CategoryContent::class);
    }

    public function comment()
    {
        return $this->hasMany(Comment::class);
    }

    public function mylist()
    {
        return $this->hasMany(Mylist::class);
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function scopeKeywordSearch($query, $keyword)
    {
        if(!empty($keyword)) {
            $query->where('name', 'like', '%' . $keyword. '%');
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'translation_lang', 'name', 'slug', 'image', 'status', 'translation_of');
    }

    public function getStatus()
    {
        return $this->status == '1' ? 'مفعل' : 'غير مفعل';
    }

//    public function getImageAttribute($val)
//    {
//        return $val !== null ? asset('assets/images/' . $val) : "";
//    }

    public function categories()
    {
        return $this->hasMany(self::class, 'translation_of');
    }

    public function vendors()
    {
        return $this->hasMany(Vendor::class, 'category_id');
    }
}

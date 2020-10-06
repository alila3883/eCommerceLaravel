<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['category_id'];

    public function scopeStatus($query)
    {
        return $query->where('status', 1);
    }

        public function getLogoAttribute($val)
    {
        return $val !== null ? asset('assets/images/' . $val) : "";
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'category_id', 'name', 'logo', 'mobile', 'status');
    }

    public function category()
    {
        return $this->belongsTo(MainCategory::class, 'category_id');
    }

    public function getStatus()
    {
        return $this->status == 1 ? 'مفعل' : 'غير مفعل';
    }

}

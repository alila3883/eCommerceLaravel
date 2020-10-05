<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function getStatus()
    {
        return $this->status == '1' ? 'مفعل' : 'غير مفعل';
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'abbr', 'name', 'direction', 'status');
    }
}

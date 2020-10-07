<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Vendor extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = ['password', 'category_id'];

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }

        public function getLogoAttribute($val)
    {
        return $val !== null ? asset('assets/images/' . $val) : "";
    }

    public function scopeSelection($query)
    {
        return $query->select('id', 'category_id', 'name', 'logo', 'mobile', 'status', 'password', 'address', 'email');
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

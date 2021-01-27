<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    protected $fillable = [
        'model',
        'year',
        'brand_id'
    ];

    protected $hidden = ['brand'];

    protected $appends = ['brand_name'];

    public $timestamps = false;

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function getBrandNameAttribute()
    {
        return $this->brand->name;
    }
}

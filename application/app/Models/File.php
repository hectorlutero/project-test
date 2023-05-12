<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function users()
    {
        return $this->morphTo('entities');
    }
    public function products()
    {
        return $this->morphTo('entities');
    }
    public function services()
    {
        return $this->morphTo('entities');
    }
    public function serviceCategories()
    {
        return $this->morphTo('entities');
    }
    public function productCategories()
    {
        return $this->morphTo('entities');
    }
    public function media()
    {
        return $this->morphTo('entities');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
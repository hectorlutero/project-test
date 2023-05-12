<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceGallery extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function files()
    {
        return $this->morphOne(File::class, "serviceCategories", "entities_type", "entities_id");
    }
}
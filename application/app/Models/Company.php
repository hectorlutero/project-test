<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $guarded = [];

    public function category()
    {

        return $this->belongsTo(CompanyCategory::class, 'company_category_id');

    }

    public function products()
    {

        return $this->hasMany(Product::class, 'company_id');

    }

    public function services()
    {

        return $this->hasMany(Service::class, 'company_id');

    }

    public function user()
    {

        return $this->belongsTo(User::class, 'user_id');

    }

    public function images()
    {
        return $this->hasMany(CompanyImage::class, 'company_id', 'id');
    }

    public function files()
    {
        return $this->morphMany(File::class, "companies", "entities_type", "entities_id");
    }

    public function logo()
    {
        return $this->belongsTo(File::class, 'logo_id');
    }

    public function getStatusRenderAttribute()
    {
        switch ($this->status) {
            case "active":
                return '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Ativo</span>';
            case "pending_approval":
                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Pendente Aprovação</span>';
            case "banned":
                return '<span class="bg-red-100 text-red-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Banido</span>';

        }
    }
}
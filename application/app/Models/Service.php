<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function files()
    {
        return $this->morphMany(File::class, "services", "entities_type", "entities_id");
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function categories()
    {

        return $this->hasManyThrough(ServiceCategory::class, 'services_categories');

    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusRenderAttribute()
    {
        switch ($this->status) {
            case "PUBLISHED":
                return '<span class="bg-green-100 text-green-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Publicado</span>';
            case "DRAFT":
                return '<span class="bg-yellow-100 text-yellow-800 text-sm font-medium mr-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Rascunho</span>';
        }
    }
}
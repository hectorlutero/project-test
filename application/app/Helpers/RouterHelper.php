<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Route;

class RouterHelper
{

    public static function addAdminRouteBlock($base, $controller): void
    {
        $baseName = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[1] : $base;
        $basePluralStr = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[0] . "." . \Illuminate\Support\Str::plural($baseName) : \Illuminate\Support\Str::plural($baseName);
        $basePlural = \Illuminate\Support\Str::plural($baseName);
        Route::get("/$basePlural", "App\\Http\\Controllers\\Admin\\$controller@showList")->name("$basePluralStr.index");
        Route::get("/$basePlural/busca", "App\\Http\\Controllers\\Admin\\$controller@search")->name("$basePluralStr.search");
        Route::get("/$baseName/{id}", "App\\Http\\Controllers\\Admin\\$controller@showEntry")->name("$base.show");
        Route::post("/$baseName/import", "App\\Http\\Controllers\\Admin\\$controller@importEntries")->name("$base.import");
        Route::post("/$baseName/mass-action/", "App\\Http\\Controllers\\Admin\\$controller@updateEntries")->name("$base.save.many");
        Route::post("/$baseName/{id}", "App\\Http\\Controllers\\Admin\\$controller@updateEntry")->name("$base.save");
        Route::delete("/$baseName/mass-action/", "App\\Http\\Controllers\\Admin\\$controller@deleteEntries")->name("$base.delete.many");
        Route::delete("/$baseName/delete", "App\\Http\\Controllers\\Admin\\$controller@deleteEntry")->name("$base.delete");
        Route::get("/$baseName/{id}/gallery", "App\\Http\\Controllers\\Admin\\$controller@showGallery")->name("$base.gallery");
        Route::post("/$basePlural/{id}/{entity_type}", "App\\Http\\Controllers\\Admin\\$controller@updateMedia")->name("$base.gallery.save");
        Route::delete("/$baseName/gallery/delete", "App\\Http\\Controllers\\Admin\\$controller@deleteMedia")->name("$base.gallery.delete");
        Route::get("/$baseName/export/spreadsheet-model/download", "App\\Http\\Controllers\\Admin\\$controller@exportModel")->name("$base.export");
    }
    public static function addCustomerRouteBlock($base, $controller): void
    {
        $baseName = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[1] : $base;
        $basePluralStr = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[0] . "." . \Illuminate\Support\Str::plural($baseName) : \Illuminate\Support\Str::plural($baseName);
        $basePlural = \Illuminate\Support\Str::plural($baseName);
        Route::get("/$basePlural/be-partner", "App\\Http\\Controllers\\Customer\\$controller@index")->name("$base.index");
    }
    public static function addPartnerRouteBlock($base, $controller): void
    {
        $baseName = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[1] : $base;
        $basePluralStr = \Illuminate\Support\Str::contains($base, ".") ? explode(".", $base)[0] . "." . \Illuminate\Support\Str::plural($baseName) : \Illuminate\Support\Str::plural($baseName);
        $basePlural = \Illuminate\Support\Str::plural($baseName);
        Route::get("/$basePlural", "App\\Http\\Controllers\\Partner\\$controller@showList")->name("$basePluralStr.index");
        Route::get("/$basePlural/busca", "App\\Http\\Controllers\\Partner\\$controller@search")->name("$basePluralStr.search");
        Route::get("/$baseName/{id}/{company_id?}", "App\\Http\\Controllers\\Partner\\$controller@showEntry")->name("$base.show");
        Route::post("/$baseName/import", "App\\Http\\Controllers\\Partner\\$controller@importEntries")->name("$base.import");
        Route::post("/$baseName/mass-action/", "App\\Http\\Controllers\\Partner\\$controller@updateEntries")->name("$base.save.many");
        Route::post("/$baseName/{id}", "App\\Http\\Controllers\\Partner\\$controller@updateEntry")->name("$base.save");
        Route::delete("/$baseName/mass-action/", "App\\Http\\Controllers\\Partner\\$controller@deleteEntries")->name("$base.delete.many");
        Route::delete("/$baseName/delete", "App\\Http\\Controllers\\Partner\\$controller@deleteEntry")->name("$base.delete");
        Route::get("/$baseName/{id}/gallery/show", "App\\Http\\Controllers\\Partner\\$controller@showGallery")->name("$base.gallery");
        Route::post("/$basePlural/{id}/{entity_type}/save", "App\\Http\\Controllers\\Partner\\$controller@updateMedia")->name("$base.gallery.save");
        Route::delete("/$baseName/gallery/delete", "App\\Http\\Controllers\\Partner\\$controller@deleteMedia")->name("$base.gallery.delete");
        Route::get("/$baseName/export/spreadsheet-model/download", "App\\Http\\Controllers\\Partner\\$controller@exportModel")->name("$base.export");
    }

}
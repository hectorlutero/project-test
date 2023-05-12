<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyCategory extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function children(){

        return $this->hasMany(Company::class,'company_category_id');

    }

    public function getCapabilitiesAttribute(){
        $str = "<span style='line-height: 18px !important;'>";
        if ($this->allow_products == 'Y') $str .= "Produtos ✅<br/>";
        else $str .= "Produtos 🟥<br/>";

        if ($this->allow_services == 'Y') $str .= "Serviços ✅";
        else $str .= "Serviços 🟥";

        $str .= "</span>";

        return $str;
    }
}

<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModelHelper
{

    public static function is_nullable(string $field_name, Model $model)
    {
        if (is_null(static::$_columns_info)) {
            static::$_columns_info = DB::select('show columns from ' . $model->getConnection()->getName() . "." . $model->gettable());
        }
        if (is_null(static::$_nullable_fields)) {
            static::$_nullable_fields = array_map(function ($fld) {
                return $fld->Field;
            }, array_filter(static::$_columns_info, function ($v) {
                return $v->Null == 'YES';
            }));
        }

        return in_array($field_name, static::$_nullable_fields);
    }

    public static function checkDefaultValues(Model $model, $fields)
    {
        $schema = Schema::getColumnListing($model->getTable());
        foreach ($schema as $key => $value) {
            $fixed = str_replace("`", "", $key);
            unset($schema[$key]);
            $schema[$fixed] = $value;
        }

        $checkedFields = [];

        foreach ($fields as $key => $value) {
            if ($value == null || $value == "" || $value == "null") {

                switch ($schema[$key]->getType()->getName()) {
                    case "string":
                        $value = self::is_nullable($key, $model) ? null : "";
                        break;
                    case "integer":
                        $value = 0;
                        break;
                    default:
                        $value = self::get_default_value($key, $model);
                        break;
                }
            }

            $checkedFields[$key] = $value;
        }


        return $checkedFields;
    }

    public static function mountJoinToSearch($table, $field, $collection)
    {

        $joined = false;
        $joinedField = "";

        if ($field != "id" && str_contains($field, '.')) {

            $exploded = explode(".", $field);
            $field = $exploded[0];
            $joinedField = $exploded[1];
            $joinedSingular = Str::singular($field);
            $collection = $collection->join($field, $table . ".$joinedSingular" . "_id", '=', "$field.id");
            $joined = true;
        }

        return [
            'filtered' => $collection,
            'orderBy' => $joined === true ? $field . "." . $joinedField : $field,
            'joined' => $joined
        ];
    }

    public static function generateWhereBlocks($fields, $search){
        $rawQuery = "(";
        $i = 0;
        $len = count($fields);

        foreach ($fields as $field) {
            $rawQuery .= " $field LIKE '%" . $search . "%' ";
            if ($i != $len - 1) $rawQuery .= " OR ";
            $i++;
        }
        $rawQuery .= ")";

        return $rawQuery;
    }

    public static function getModelByPluralName($pluralName) {
        $modelName = Str::studly(Str::singular($pluralName));
        $modelName = !in_array($modelName, ['Permission', 'Role']) ? "\\App\\Models\\".$modelName : "\\Spatie\\Permission\\Models\\".$modelName;
        return $modelName::get();
    }
}

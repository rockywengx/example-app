<?php

namespace App\Models\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Code extends Model
{
    protected $table='codes';
    use HasFactory;
    protected $fillable = [
        'name',
        'key',
        'value',
        'disabled'
    ];

    public static function rules($id = null,
        $name = null,
        $key = null,
        $value = null)
    {

        $unique_rule = Rule::unique('codes')
            ->where(function ($query) use ($name, $key, $value){
                return $query->where('name', $name)
                    ->where('key', $key)
                    ->where('value', $value);
            })
            ->ignore($id);

        return [
            'name' => 'required|string|max:255,' . $unique_rule,
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'value2' => 'string|max:255',
            'disabled' => 'boolean',
        ];
    }

    public function getRouteKeyName()
    {
        return 'name';
    }


    protected $primaryKey = ['name', 'key', 'value'];

    public $incrementing = false;

}

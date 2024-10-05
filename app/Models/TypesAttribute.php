<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypesAttribute extends Model
{
    use HasFactory,CanSort;
    protected $fillable = [
        'title',
        'slug',
    ];
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Тип атрибута'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Код атрибута'
        ],
    ];
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Тип атрибута',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Код атрибута',
            'validation' => 'required'
        ],
    ];

    public function attributes()
    {
        return $this->hasMany(AttributeItem::class, 'type_attribute_id');
    }
}

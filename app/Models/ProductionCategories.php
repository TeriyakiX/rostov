<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionCategories extends Model
{
    use HasFactory, CanSort;

    protected $fillable = [
        'slug',
        'title',
        'text',
        'active'
    ];
    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Код производства'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Название производства'
        ],
        'active' => [
            'type' => 'yes_no',
            'title' => 'Отображен на сайте'
        ],
    ];
    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название производства',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Код производства',
            'validation' => 'required'
        ],
        'text'=>[
            'type' => 'text_large',
            'title' => 'Текст для производства',
        ],
        'photos' => [
            'type' => 'photos',
            'title' => 'Фотографии'
            ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],

    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }
    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}

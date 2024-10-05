<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AkciiSlider extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'sort',
        'photo_desktop',
        'url'
    ];
    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'sort' => [
            'type' => 'plain',
            'title' => 'Номер сортировки'
        ],
        'url' => [
            'type' => 'plain',
            'title' => 'Ссылка'
        ]
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'sort' => [
            'type' => 'text',
            'title' => 'Номер сортировки'
        ],
        'photo_desktop' => [
            'type' => 'photo',
            'prefix' => 'hero',
            'title' => 'Фотография'
        ],
        'url' => [
            'type' => 'text',
            'title' => 'Ссылка на кнопке "Подробнее"'
        ]
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

}

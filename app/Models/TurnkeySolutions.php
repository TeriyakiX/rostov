<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnkeySolutions extends Model
{
    use HasFactory, CanSort;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'seo_description',
        'system_composition',
        ];

    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Заголовок'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Ссылка'
        ],
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Заголовок',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Ссылка'
        ],
        'photos' => [
            'type' => 'photos',
            'title' => 'Фотографии'
        ],
        'tags' => [
            'type' => 'tags',
            'title' => 'Теги',
            'model' => TagsCategories::class
        ],
        'system_composition' => [
            'type' => 'editor',
            'title' => 'Состав системы'
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'solution_tags',
            'solution_id', 'tag_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class,'photoable');
    }
}

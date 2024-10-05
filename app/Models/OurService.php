<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OurService extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'filepath',

        'seo_title',
        'seo_description',
        'seo_keywords',

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
        'title' => [
            'type' => 'plain',
            'title' => 'Заголовок'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Ссылка (slug)'
        ],
        'active' => [
            'type' => 'yes_no',
            'title' => 'Отображен на сайте'
        ]
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
        'seo_title' => [
            'type' => 'text',
            'title' => 'SEO title'
        ],
        'seo_description' => [
            'type' => 'text',
            'title' => 'SEO description'
        ],
        'seo_keywords' => [
            'type' => 'text',
            'title' => 'SEO keywords'
        ],
        'body' => [
            'type' => 'editor',
            'title' => 'Содержимое'
        ],
        'filepath' => [
            'type' => 'photo',
            'title' => 'Фотография'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ]
    ];

    /**
     * @param $query
     * @return mixed
     */
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}

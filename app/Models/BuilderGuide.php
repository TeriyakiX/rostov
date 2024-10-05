<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderGuide extends Model
{
    use HasFactory, CanSort;
    protected $fillable = [
        'title',
        'description',
        'active',
        'slug'
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
        'description' => [
            'type' => 'editor',
            'title' => 'Описание',
            'validation' => 'required'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],
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

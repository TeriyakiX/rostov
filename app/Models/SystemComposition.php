<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemComposition extends Model
{
    use HasFactory, CanSort;
    protected $fillable = ['title', 'slug', 'description'];
    protected $table = 'system_composition';

    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'plain',
            'title' => 'Заголовок'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Ссылка'
        ],
        'description' => [
            'type' => 'editor',
            'title' => 'Описание'
        ],
    ];
}

<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use HasFactory, CanSort;

    /** @var string[] $fillable */
    protected $fillable = [
        'title',
        'slug',
    ];
    protected $table = 'order_statuses';

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
            'title' => 'Название статусв'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Код статуса'
        ],
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название статуса',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Ссылка типа (url slug)',
            'validation' => 'required'
        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents()
    {
        return $this->hasMany(Documentation::class, 'file_type_id');
    }
}

<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfficeHour extends Model
{
    use HasFactory,CanSort;

    protected $fillable = [
        'day',
        'hours',
    ];

    /**
     * @var string[]
     * Поля для отображения в админке
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'days' => [
            'type' => 'plain',
            'title' => 'День недели'
        ],
        'hours' => [
            'type' => 'plain',
            'title' => 'Часы работы'
        ],
    ];

    /**
     * @var string[]
     * Поля для редактирования в админке
     */
    public const ADMIN_EDIT = [
        'days' => [
            'type' => 'text',
            'title' => 'День недели',
            'validation' => 'required|max:50'
        ],
        'hours' => [
            'type' => 'text',
            'title' => 'Часы работы',
            'validation' => 'required|max:50'
        ],
    ];

    /**
     * Форматированное представление рабочего времени
     *
     * @return string
     */
    public function formattedHours(): string
    {
        return "{$this->day}: {$this->hours}";
    }
}

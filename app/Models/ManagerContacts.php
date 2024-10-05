<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerContacts extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'email',
        'phone',
    ];
    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'email' => [
            'type' => 'plain',
            'title' => 'почта'
        ],
        'phone' => [
            'type' => 'plain',
            'title' => 'номер телефона'
        ]
    ];
    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'email' => [
            'type' => 'text',
            'title' => 'Электронная почта',
        ],
        'phone'=>[
            'type'=>'text',
            'title'=>'Номер телефона',
        ]
        ];
}

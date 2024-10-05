<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\CanSort;

class Feedback extends Model
{
    use HasFactory, CanSort;
    protected $table = 'feedback';
    protected $fillable = ['name', 'phone_number', 'email', 'body'];
    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'name' => [
            'type' => 'plain',
            'title' => 'Имя'
        ],
        'phone_number' => [
            'type' => 'plain',
            'title' => 'Телефон'
        ],
        'email' => [
            'type' => 'plain',
            'title' => 'Емайл'
        ],
        'body' => [
            'type' => 'plain',
            'title' => 'Содержимое'
        ],
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'name' => [
            'type' => 'text',
            'title' => 'Имя',
            'validation' => 'required'
        ],
        'phone_number' => [
            'type' => 'text',
            'title' => 'Телефон'
        ],
        'email' => [
            'type' => 'text',
            'title' => 'Емайл'
        ],
        'body' => [
            'type' => 'editor',
            'title' => 'Содержимое'
        ],
    ];
}

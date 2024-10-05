<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsefulChapter extends Model
{
    use  HasFactory, CanSort;
protected $table='useful_chapter';
    protected $fillable = [
        'title',
        'slug',
        'active',
        'sort'
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
            'title' => 'Ссылка(slug)'
        ],
        'active' => [
            'type' => 'yes_no',
            'title' => 'Отображен на сайте'
        ],
        'sort'=>[
            'type'=>'plain',
            'title'=>'Номер сортировки'
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
            'title' => 'slug',

        ],
        'url' => [
            'type' => 'text',
            'title' => 'Ссылка на страницу',
            'validation' => 'required'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],
        'sort' => [
            'type' => 'text',
            'title' => '№ сортировки'
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

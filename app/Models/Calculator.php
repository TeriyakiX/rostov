<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calculator extends Model
{
    use HasFactory,CanSort;
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'seo_title',
        'seo_description',
        'active',
        'image',
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
            'title' => 'Ссылка (slug)'
        ],
        'sort'=>[
            'type'=>'plain',
            'title'=>'Номер сортировки'
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
        'sort' => [
            'type' => 'text',
            'title' => '№ сортировки'
        ],
        'body' => [
            'type' => 'editor',
            'title' => 'Содержимое',
            'validation' => 'required'
        ],
        'image'=>[
            'type'=>'photo',
            'title'=>'Картинка'
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
    /**
     * @return string
     */
    public function mainPhotoPath()
    {

        $mainPhotoPath = $this->image??null;
        if ($mainPhotoPath) {
            return url('/') . '/upload_images/' . $mainPhotoPath;
        } else {
            return url('/') . '/img/no-image.png';
        }
    }
}

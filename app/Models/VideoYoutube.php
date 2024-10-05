<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VideoYoutube extends Model
{
    use HasFactory, CanSort;

    protected $fillable = [
        'title',
        'slug',
        'description',
		'image'
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
		'description' => [
            'type' => 'plain',
            'title' => 'Описание'
        ], 
		'image'=>[
            'type'=>'photo',
            'title'=>'Изображение для превью'
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
        'description' => [
            'type' => 'editor',
            'title' => 'Описание'
        ], 
		'image'=>[
            'type'=>'photo',
            'title'=>'Изображение для превью'
        ]
    ];
	
	
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

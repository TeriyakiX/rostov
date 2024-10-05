<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\IndexSlider
 *
 * @property int $id
 * @property int|null $sort
 * @property string $title
 * @property string|null $description
 * @property string|null $photo_desktop
 * @property string|null $photo_mobile
 * @property string|null $url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider query()
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider wherePhotoDesktop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider wherePhotoMobile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|IndexSlider whereUrl($value)
 * @mixin \Eloquent
 */
class IndexSlider extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'sort',
        'description',
        'photo_desktop',
        'photo_mobile',
        'url'
    ];

    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'sort' => [
            'type' => 'plain',
            'title' => 'Номер сортировки'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Заголовок'
        ],
        'description' => [
            'type' => 'plain',
            'title' => 'Короткое описание'
        ],
        'url' => [
            'type' => 'plain',
            'title' => 'Ссылка'
        ]
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'sort' => [
            'type' => 'text',
            'title' => 'Номер'
        ],
        'title' => [
            'type' => 'text',
            'title' => 'Заголовок',
            'validation' => 'required'
        ],
        'description' => [
            'type' => 'text',
            'title' => 'Короткое описание'
        ],
        'photo_desktop' => [
            'type' => 'photo',
            'prefix' => 'hero',
            'title' => 'Фоновая фотография десктоп'
        ],
        'photo_mobile' => [
            'type' => 'photo',
            'prefix' => 'hero',
            'title' => 'Фоновая фотография мобильная'
        ],
        'url' => [
            'type' => 'text',
            'title' => 'Ссылка на кнопке "Подробнее"'
        ]
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class,'photoable');
    }
}

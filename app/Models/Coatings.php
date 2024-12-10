<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Coatings
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\CoatingsAttribute[] $attributeItems
 * @property-read int|null $attribute_items_count
// * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $relatedProducts
// * @property-read int|null $related_products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Product statusActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVendorCode($value)
 * @mixin \Eloquent
 */
class Coatings extends Model
{
    use HasFactory, CanSort;

    protected $guarded = [];


    protected $fillable = [
        'is_popular',
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
            'title' => 'Название атрибута'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Код атрибута'
        ],
        'is_popular' => [
            'type' => 'yes_no',
            'title' => 'Популярное',
        ],
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название покрытия',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Ссылка покрытия (url slug)',
            'validation' => 'required'
        ],
        'protective_layer' => [
            'type' => 'text',
            'title' => 'Защитный слой Zn'
        ],
        'protective_layer_description' => [
            'type' => 'text',
            'title' => 'Описание защитного слоя'
        ],
        'metal_thickness' => [
            'type' => 'text',
            'title' => 'Толщина металла'
        ],
        'metal_thickness_description' => [
            'type' => 'text',
            'title' => 'Описание толщина металла'
        ],
        'polymer_coating_thickness' => [
            'type' => 'text',
            'title' => 'Толщина полимерного покрытия'
        ],
        'polymer_coating_thickness_description' => [
            'type' => 'text',
            'title' => 'Описание толщина полимерного покрытия'
        ],
        'guarantee' => [
            'type' => 'text',
            'title' => 'Гарантия'
        ],
        'guarantee_description' => [
            'type' => 'text',
            'title' => 'Описание гарантии'
        ],
        'light_fastness' => [
            'type' => 'text',
            'title' => 'Цветостойкость'
        ],
        'light_fastness_description' => [
            'type' => 'text',
            'title' => 'Описание цветостойкости'
        ],
        'description' => [
            'type' => 'editor',
            'title' => 'Описание'
        ],
        'photos' => [
            'type' => 'photos',
            'title' => 'Фотографии'
        ],
        'is_popular' => [
            'type' => 'checkbox',
            'title' => 'Популярное покрытие',
            'validation' => 'boolean',
        ],
//        'attributes' => [
//            'type' => 'attributes',
//            'title' => 'Атрибуты'
//        ],
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class,'photoable');
    }

    /**
     * @return string
     */
    public function mainPhotoPath()
    {
        $photos = $this->photos;
        $firstPhoto = $photos ? $photos->first() : null;
        if($firstPhoto) {
            return url('/') . '/upload_images/' . $firstPhoto->path;
        } else {
            return url('/') . '/img/no-image.png';
        }
    }

    public function attributesArray()
    {
        $itemAttributes = $this->attributeItems;
        $productAttributes = [];
        foreach ($itemAttributes as $attribute) {
            $productAttributes[$attribute->attribute_item_id]['model'] = $attribute->attribute;
            $productAttributes[$attribute->attribute_item_id]['options'][] = $attribute->option;
        }
        return $productAttributes;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeItems()
    {
        return $this->hasMany(CoatingsAttribute::class, 'coatings_id');
    }
}

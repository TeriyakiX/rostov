<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OptionItem
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AttributeItem[] $attributeItems
 * @property-read int|null $attribute_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OptionItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OptionItem extends Model
{
    use HasFactory, CanSort;

    protected $fillable = [
        'slug',
        'title'
    ];


    /**
     * @var string[]
     */
    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'slug' => [
            'type' => 'plain',
            'title' => 'Код опции'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Название опции'
        ]
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название опции',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Код опции',
            'validation' => 'required'
        ],
        'attributeItems' => [
            'type' => 'belongsToMany',
            'title' => 'Атрибуты опции',
            'model' => AttributeItem::class
        ],
    ];

    public function product_attribute()
    {
        return $this->belongsTo(ProductAttribute::class, 'id',
            'option_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributeItems()
    {
        return $this->belongsToMany(AttributeItem::class, 'attribute_item_option_item',
            'option_item_id', 'attribute_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function attributeCoatings()
    {
        return $this->belongsToMany(AttributeItem::class, 'attribute_coatings_option_coatings',
            'option_coatings_id', 'attribute_coatings_id');
    }
}

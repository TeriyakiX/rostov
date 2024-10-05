<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AttributeItem
 *
 * @property int $id
 * @property string|null $slug
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\OptionItem[] $optionItems
 * @property-read int|null $option_items_count
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeItem whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AttributeItem extends Model
{
    use HasFactory, CanSort;

    protected $fillable = [
        'slug',
        'title',
        'type_attribute_id',
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
            'title' => 'Код атрибута'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Название атрибута'
        ]
    ];

    /**
     * @var string[]
     */
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название атрибута',
            'validation' => 'required'
        ],
        'slug' => [
            'type' => 'text',
            'title' => 'Код атрибута',
            'validation' => 'required'
        ],
        'options' => [
            'type' => 'options',
            'title' => 'Опции атрибута'
        ],
        'optionItems' => [
            'type' => 'belongsToMany',
            'title' => 'Опции атрибута',
            'model' => OptionItem::class
        ],
        'type_attribute_id' => [
            'type' => 'belongsTo',
            'title' => 'Тип атрибута',
            'model' => TypesAttribute::class
        ],
    ];


   
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function optionItems()
    {
        return $this->belongsToMany(OptionItem::class, 'attribute_item_option_item',
            'attribute_item_id', 'option_item_id');
    }

    public function optionCoatings()
    {
        return $this->belongsToMany(OptionItem::class, 'attribute_coatings_option_coatings',
            'attribute_coatings_id', 'option_coatings_id');
    }

    public function typesAttributes()
    {
        return $this->belongsTo(TypesAttribute::class, 'type_attribute_id');
    }

}

<?php

namespace App\Models;

use App\Services\RalToRgb;
use App\Traits\CanSort;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Services\Shop\Contracts\Product as ProductContract;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $title
 * @property string|null $slug
 * @property string|null $vendor_code
 * @property string $price
 * @property string|null $promo_price
 * @property bool|null $is_novelty
 * @property int|null $is_promo
 * @property string|null $description
 * @property string|null $length_list
 * @property string|null $colors_list
 * @property int|null $show_calculator
 * @property float|null $thickness
 * @property float|null $list_width_full
 * @property float|null $list_width_useful
 * @property float|null $custom_length_from
 * @property float|null $custom_length_to
 * @property float|null $min_square_meters
 * @property int|null $sort
 * @property int|null $brand_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int|null $status_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductAttribute[] $attributeItems
 * @property-read int|null $attribute_items_count
 * @property-read \App\Models\Brand|null $brand
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ProductCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @property-read \Illuminate\Database\Eloquent\Collection|Product[] $relatedProducts
 * @property-read int|null $related_products_count
 * @method static \Database\Factories\ProductFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Product statusActive()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereColorsList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCustomLengthFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCustomLengthTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsNovelty($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereIsPromo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLengthList($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereListWidthFull($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereListWidthUseful($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinSquareMeters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product wherePromoPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShowCalculator($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSort($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereThickness($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereVendorCode($value)
 * @mixin \Eloquent
 */
class Product extends Model implements ProductContract
{
    use HasFactory, CanSort;

    const TYPE_LIST = 1;
    const TYPE_LONG = 2;
    const TYPE_PIECE = 3;
    const TYPE_PACK = 4;
    const TYPE_NAMES = [
        1 => 'Лист',
        2 => 'Длинномерный товар',
        3 => 'Штучный товар',
        4 => 'Пачка'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_DISABLED = 2;
    const STATUS_ARCHIVE = 3;
    const STATUS_NAMES = [
        1 => 'Опубликован',
        2 => 'Не опубликован',
        3 => 'В архиве'
    ];

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'slug',
        'unit_id',
        'brand_id',
        'coatings_id',
        'coatings_description',
        'profile_type',
        'profile_type_description',
        'manufacturer',
        'manufacturer_description',
        'vendor_code',
        'is_novelty',
        'is_promo',
        'end_promo_date',
        'end_novelty_date',
        'minimum_batch',
        'description',
        'list_width_full',
        'list_width_useful',
        'custom_length_from',
        'custom_length_to',
        'length_list',
        'thickness',
        'thickness_description',
        'colors_list',
        'show_calculator',
        'min_square_meters',
        'status_id',
        'price',
        'promo_price',
        'sort',
    ];

    protected $casts = [
        'end_novelty_date' => 'datetime',
        'end_promo_date' => 'datetime',
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
            'title' => 'Ссылка на товар'
        ],
        'sort' => [
            'type' => 'plain',
            'title' => '№ сортировки'
        ],
        'is_novelty' => [
            'type' => 'yes_no',
            'title' => 'Новинка'
        ],
        'is_promo' => [
            'type' => 'yes_no',
            'title' => 'Акция'
        ],
        'show_calculator' => [
            'type' => 'yes_no',
            'title' => 'Отобразить калькулятор'
        ],
        'end_novelty_date' => [
            'type' => 'dateTime',
            'title' => 'Время окончания новинки',
        ],
        'end_promo_date' => [
            'type' => 'dateTime',
            'title' => 'Время окончания акции',
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
        'vendor_code' => [
            'type' => 'text',
            'title' => 'Код товара (артикул)'
        ],
        'unit_id' => [
            'type' => 'belongsTo',
            'title' => 'Единица измерения',
            'model' => UnitsOfProducts::class,

        ],

        'list_width_full' => [
            'type' => 'text',
            'title' => 'Ширина полная в мм'
        ],
        'list_width_useful' => [
            'type' => 'text',
            'title' => 'Ширина полезная в мм'
        ],
        'length_list' => [
            'type' => 'text',
            'title' => 'Перечень длин через точку с запятой в мм (1000;1500)'
        ],
        'colors_list' => [
            'type' => 'text',
            'title' => 'Перечень доступных RAL цветов через точку с запятой (8024;6021;1021)'
        ],
        'thickness' => [
            'type' => 'text',
            'title' => 'Толщина через пробел в мм (77мм 66мм)'
        ],
        'thickness_description' => [
            'type' => 'text',
            'title' => 'Описание для толщины'
        ],
        'profile_type' => [
            'type' => 'text',
            'title' => 'Тип профиля через пробел (ПН ПС)'
        ],
        'profile_type_description' => [
            'type' => 'text',
            'title' => 'Описание для профиля'
        ],
        'manufacturer' => [
            'type' => 'text',
            'title' => 'Производитель через пробел (АВС ЮТМ)'
        ],
        'manufacturer_description' => [
            'type' => 'text',
            'title' => 'Описание для Производителя'
        ],
        'custom_length_from' => [
            'type' => 'text',
            'title' => 'Длина на заказ от в мм'
        ],
        'custom_length_to' => [
            'type' => 'text',
            'title' => 'Длина на заказ до в мм'
        ],
        'min_square_meters' => [
            'type' => 'text',
            'title' => 'Минимальная площадь заказа в м²'
        ],
        'brand_id' => [
            'type' => 'belongsTo',
            'title' => 'Бренд',
            'model' => Brand::class
        ],
        'photos' => [
            'type' => 'photos',
            'title' => 'Фотографии'
        ],
        'categories' => [
            'type' => 'categories',
            'title' => 'Категории',
            'model' => ProductCategory::class
        ],
        'coatings_id' => [
            'type' => 'belongsTo',
            'title' => 'Покрытия',
            'model' => Coatings::class
        ],
        'coatings_description' => [
            'type' => 'text',
            'title' => 'Описание для Покрытии'
        ],
        'related_products' => [
            'type' => 'multiselect',
            'title' => 'Сопутствующие товары',
            'relation' => 'relatedProducts',
            'model' => Product::class
        ],
        'similar_products' => [
            'type' => 'multiselectSimilar',
            'title' => 'Аналогичные товары',
            'relation' => 'similarProducts',
            'model' => Product::class
        ],
        'attributes' => [
            'type' => 'attributes',
            'title' => 'Атрибуты'
        ],
        'description' => [
            'type' => 'editor',
            'title' => 'Описание'
        ],
        'is_novelty' => [
            'type' => 'checkbox',
            'title' => 'Новинка'
        ],
        'is_promo' => [
            'type' => 'checkbox',
            'title' => 'Акция'
        ],
        'price' => [
            'type' => 'text',
            'title' => 'Цена',
        ],
        'promo_price' => [
            'type' => 'text',
            'title' => 'Акционная цена'
        ],
        'end_promo_date' => [
            'type' => 'dateTime',
            'title' => 'Время окончания акции'
        ],
        'end_novelty_date' => [
            'type' => 'dateTime',
            'title' => 'Время окончания новинки'
        ],
        'sort' => [
            'type' => 'text',
            'title' => '№ сортировки'
        ],
        'show_calculator' => [
            'type' => 'checkbox',
            'title' => 'Отобразить калькулятор квадратных метров'
        ],
        'status_id' => [
            'type' => 'belongsTo',
            'title' => 'Статус',
            'model' => ProductStatus::class
        ],
        'files' => [
            'type' => 'files',
            'title' => 'Документация'
        ]
    ];


    /**
     * @param $query
     * @return mixed
     */
    public function scopeStatusActive($query)
    {
        return $query->where('status_id', self::STATUS_ACTIVE);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(ProductCategory::class, 'product_product_category',
            'product_id', 'product_category_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function similarProducts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_similar_product',
            'product_id', 'similar_product_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function relatedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_related_product',
            'product_id', 'related_product_id');
    }

//    public function analogProducts()
//    {
//        return $this->belongsToMany(Product::class,'product_analog_product',
//            'product_id', 'analog_product_id');
//    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    /**
     * @return string
     */
    public function mainPhotoPath()
    {
        $photos = $this->photos;
        $firstPhoto = $photos ? $photos->first() : null;
        if ($firstPhoto) {
            return url('/') . '/upload_images/' . $firstPhoto->path;
        } else {
            return url('/') . '/img/no-image.png';
        }
    }

    /**
     * @return string
     */
    public function showLink()
    {
        return route('index.products.show', ['category' => ($this->categories->first() ? $this->categories->first()->slug : null), 'product' => $this->slug]);
    }

    /**
     * @return array
     */
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
     * @return array|null
     */
    public function colorsArray()
    {
        $colorsList = $this->colors_list;
        if ($colorsList) {
            $ralToRgb = new RalToRgb();
            $colorsArray = explode(';', $colorsList);
            foreach ($colorsArray as $index => $color) {
                $colorsArray[$index] = ['ral' => $color, 'rgb' => $ralToRgb->index($color)];
            }
            return $colorsArray;
        }
        return null;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function attributeItems()
    {

        return $this->hasMany(ProductAttribute::class, 'product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * @param $query
     * @param $orderBy
     * @return mixed
     */


    /**
     * {@inheritdoc}
     *
     * @param integer $quantity
     * @param bool|true $withDiscount
     * @return float
     */
    public function getPrice($quantity = 1, $withDiscount = true)
    {
        if ($this->promo_price) {
            $price = $this->promo_price;
        } else {
            $price = $this->price;
        }
        return $price * $quantity;
    }

    public function getFormattedEndPromoDate(): string
    {

        if (!isset($this->end_promo_date)) {
            return 'Акционный товар';
        }

        return 'Акция действует до ' . Carbon::parse($this->end_promo_date)->format('d.m.y');
    }

    /**
     * @return false|string[]
     */
    public function getLengthList()
    {
        $lengts = $this->length_list;
        return explode(';', $lengts);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class, 'fileable');
    }

    /**
     * @return string
     */
    public function millsToText($field)
    {
        $widthInMilimeters = $this->$field;
        if ($widthInMilimeters >= 1000) {
            return $widthInMilimeters / 1000 . ' м';
        }
        return $widthInMilimeters . ' мм';
    }

}

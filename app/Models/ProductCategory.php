<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductCategory
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property int|null $parent_id
 * @property string|null $seo_title
 * @property string|null $seo_keywords
 * @property string|null $seo_description
 * @property string|null $seo_text
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductCategory|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection|ProductCategory[] $subcategories
 * @property-read int|null $subcategories_count
 * @method static \Database\Factories\ProductCategoryFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSeoText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
use Illuminate\Database\Migrations\Migration;
class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
class ProductCategory extends Model
{
    use HasFactory, CanSort;

	private $descendants = [];

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'sort',
        'seo_title',
        'seo_keywords',
        'seo_description',
        'seo_text',
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
        'parent_id' => [
            'type' => 'belongsTo',
            'title' => 'Родительская категория',
            'relation_name' => 'parent',
            'relation_title' => 'title'
        ],
        'sort' => [
            'type' => 'plain',
            'title' => '№ сортировки'
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
        'parent_id' => [
            'type' => 'parentCategories',
            'relation_name' => 'parent',
            'title' => 'Родительская категория',
            'model' => ProductCategory::class
        ], 'image'=>[
            'type'=>'photo',
            'title'=>'Изображение для родительской категории'
        ],
        'seo_title' => [
            'type' => 'text',
            'title' => 'SEO title'
        ],
        'seo_description' => [
            'type' => 'text',
            'title' => 'SEO description'
        ],
        'seo_keywords' => [
            'type' => 'text',
            'title' => 'SEO keywords'
        ],
        'sort' => [
            'type' => 'text',
            'title' => '№ сортировки'
        ],
        'seo_text' => [
            'type' => 'text',
            'title' => 'SEO text'
        ]
    ];

    /**
     * @param $query
     * @param $orderBy
     * @return mixed
     */
   


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subcategories()
    {

        return $this->hasMany(self::class, 'parent_id','id');
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function products()
    {
        return $this->belongsToMany(Product::class,'product_product_category',
            'product_category_id', 'product_id');
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

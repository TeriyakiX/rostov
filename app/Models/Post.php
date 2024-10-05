<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Post
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property int|null $show_in_header
 * @property int|null $show_in_footer
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\PostCategory[] $categories
 * @property-read int|null $categories_count
 * @method static \Illuminate\Database\Eloquent\Builder|Post active()
 * @method static \Database\Factories\PostFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|Post newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Post query()
 * @method static \Illuminate\Database\Eloquent\Builder|Post showInFooter()
 * @method static \Illuminate\Database\Eloquent\Builder|Post showInHeader()
 * @method static \Illuminate\Database\Eloquent\Builder|Post sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereShowInFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereShowInHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Post whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'slug',
        'body',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'active',
        'show_in_header',
        'show_in_footer',
        'image',
        'preview',
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
        'active' => [
            'type' => 'yes_no',
            'title' => 'Отображен на сайте'
        ],
        'show_in_header' => [
            'type' => 'yes_no',
            'title' => 'Отобразить в шапке'
        ],
        'show_in_footer' => [
            'type' => 'yes_no',
            'title' => 'Отобразить в футере'
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
        'categories' => [
            'type' => 'belongsToMany',
            'title' => 'Категории',
            'model' => PostCategory::class
        ],
        'sort' => [
            'type' => 'text',
            'title' => '№ сортировки'
        ],
        'body' => [
            'type' => 'editor',
            'title' => 'Содержимое'
        ],
        'image'=>[
            'type'=>'photo',
            'title'=>'Картинка. Необходима для  статьи.'
        ],
        'preview'=>[
            'type'=>'text',
            'title'=>'Краткое описание(анонс) статьи'
        ],
        'tags' => [
            'type' => 'tags',
            'title' => 'Теги',
            'relation' => 'tags',
            'model' => TagsCategories::class
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],
        'show_in_header' => [
            'type' => 'checkbox',
            'title' => 'Отобразить в шапке'
        ],
        'show_in_footer' => [
            'type' => 'checkbox',
            'title' => 'Отобразить в футере'
        ],
        'files' => [
            'type' => 'files|mimes:jpeg,png,pdf',
            'title' => 'Файлы'
        ]
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
     * @param $query
     * @return mixed
     */
    public function scopeShowInFooter($query)
    {
        return $query->where('show_in_footer', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeShowInHeader($query)
    {
        return $query->where('show_in_header', true);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function files()
    {
        return $this->morphMany(File::class,'fileable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(PostCategory::class, 'post_category_post', 'post_id', 'post_category_id');
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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'stati_tags',
            'post_id', 'tag_id');
    }
}

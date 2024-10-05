<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\PostCategory
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property int|null $show_in_header
 * @property int|null $show_in_footer
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property int $active
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read int|null $posts_count
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory active()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory showInFooter()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory showInHeader()
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereShowInFooter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereShowInHeader($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PostCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PostCategory extends Model
{
    use HasFactory, CanSort;


    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
        'slug',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'show_in_footer',
        'show_in_header',
        'active'
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
        'show_in_header' => [
            'type' => 'checkbox',
            'title' => 'Отобразить в шапке'
        ],
        'show_in_footer' => [
            'type' => 'checkbox',
            'title' => 'Отобразить в футере'
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function posts()
    {
        return $this->belongsToMany(Post::class, 'post_category_post', 'post_category_id', 'post_id');
    }
}

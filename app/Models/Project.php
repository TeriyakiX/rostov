<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Project
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string $body
 * @property string|null $seo_title
 * @property string|null $seo_description
 * @property string|null $seo_keywords
 * @property int $active
 * @property int $is_photo_project
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Photo[] $photos
 * @property-read int|null $photos_count
 * @method static \Illuminate\Database\Eloquent\Builder|Project active()
 * @method static \Illuminate\Database\Eloquent\Builder|Project isPhotoProject()
 * @method static \Illuminate\Database\Eloquent\Builder|Project isProject()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Project query()
 * @method static \Illuminate\Database\Eloquent\Builder|Project sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereIsPhotoProject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSeoDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSeoKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSeoTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Project whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Project extends Model
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
        'is_photo_project'
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
        'body' => [
            'type' => 'editor',
            'title' => 'Содержимое'
        ],
        'related_products' => [
            'type' => 'multiselect',
            'title' => 'Товары, которые могут вам подойти',
            'relation' => 'relatedProjects',
            'model' => Product::class
        ],
        'attributes' => [
            'type' => 'attributes',
            'title' => 'Атрибуты'
        ],
        'photos' => [
            'type' => 'photos',
            'title' => 'Фотографии'
        ],
        'is_photo_project' => [
            'type' => 'checkbox',
            'title' => 'Фотопроект'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ]
    ];

    public function attributesArray()
    {
        $itemAttributes = $this->attributeItems;
        $projectAttributes = [];
        foreach ($itemAttributes as $attribute) {
            $projectAttributes[$attribute->attribute_item_id]['model'] = $attribute->attribute;
            $projectAttributes[$attribute->attribute_item_id]['options'][] = $attribute->option;
        }
        return $projectAttributes;
    }

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
    public function scopeIsPhotoProject($query)
    {
        return $query->where('is_photo_project', true);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeIsProject($query)
    {
        return $query->where('is_photo_project', false);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function photos()
    {
        return $this->morphMany(Photo::class, 'photoable');
    }

    public function attributeItems()
    {
        return $this->hasMany(ProjectAttribute::class, 'project_id');
    }

    public function relatedProjects()
    {
        return $this->belongsToMany(Product::class,'project_related_product',
            'project_id', 'related_product_id');
    }

}

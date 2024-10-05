<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TagsCategories extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[] $fillable
     */
    protected $fillable = [
        'title',
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'tags_categories_tags',
            'tags_category_id', 'tag_id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function brandTags()
    {
        return $this->belongsToMany(Tags::class, 'tags_categories_tags',
            'tags_category_id', 'tag_id')->join('brand_tags','tags_categories_tags.tag_id','brand_tags.tag_id')->distinct();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function statiTags()
    {
        return $this->belongsToMany(Tags::class, 'tags_categories_tags',
            'tags_category_id', 'tag_id')->join('stati_tags','tags_categories_tags.tag_id','stati_tags.tag_id')->distinct();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function solutionTags()
    {
        return $this->belongsToMany(Tags::class, 'tags_categories_tags',
            'tags_category_id', 'tag_id')->join('solution_tags','tags_categories_tags.tag_id','solution_tags.tag_id')->distinct();
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function documentsTags()
    {
        return $this->belongsToMany(Tags::class, 'tags_categories_tags',
            'tags_category_id', 'tag_id')->join('files_tags','tags_categories_tags.tag_id','files_tags.tag_id')->distinct();
    }
}

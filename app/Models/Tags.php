<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use HasFactory,CanSort;
    protected $table='tags';
    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
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
    ];
    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Заголовок',
            'validation' => 'required'
        ],
        'categories' => [
            'type' => 'belongsToMany',
            'title' => 'Категории',
            'model' => TagsCategories::class
        ],

        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(TagsCategories::class, 'tags_categories_tags', 'tag_id', 'tags_category_id');
    }
    public function stati(){
        return $this->hasOne(StatiTags::class,'tag_id','stati_tags.tag_id');
    }
    public function brand(){
        return $this->hasOne(BrandTags::class,'tag_id','brand_tags.tag_id');
    }
    public function solution(){
        return $this->hasOne(SolutionTags::class,'tag_id','solution_tags.tag_id');
    }

}

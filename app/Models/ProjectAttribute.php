<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectAttribute extends Model
{
    use HasFactory;

    const EXCEPT_PARAMS = [
        'page',
        'orderBy',
        'isPromo',
        'isNovelty'
    ];

    protected $fillable = [
        'slug',
        'title',
        'project_id',
        'attribute_item_id',
        'option_item_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(AttributeItem::class, 'attribute_item_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(OptionItem::class, 'option_item_id');
    }
}

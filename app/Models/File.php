<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\File
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $filepath
 * @property int|null $fileable_id
 * @property string|null $fileable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|File newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|File query()
 * @method static \Illuminate\Database\Eloquent\Builder|File sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFileableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereFilepath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|File whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class File extends Model
{
    use HasFactory, CanSort;

    public $fillable = [
        'title',
        'filepath',
        'active',
        'file_type_id',
        'fileable_id',
        'fileable_type',
    ];

    public const ADMIN_VIEW = [
        'id' => [
            'type' => 'plain',
            'title' => 'ID'
        ],
        'title' => [
            'type' => 'plain',
            'title' => 'Название файла'
        ],

    ];

    public const ADMIN_EDIT = [
        'title' => [
            'type' => 'text',
            'title' => 'Название файла',
            'validation' => 'required'
        ],
        'active' => [
            'type' => 'checkbox',
            'title' => 'Отобразить на сайте'
        ],
        'tags' => [
            'type' => 'tags',
            'title' => 'Теги',
            'model' => TagsCategories::class
        ],
        'file_type_id' => [
            'type' => 'belongsTo',
            'title' => 'Название типа',
            'model' => DocumentType::class
        ],
    ];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tags::class, 'files_tags',
            'file_id', 'tag_id');
    }
}

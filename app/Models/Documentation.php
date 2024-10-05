<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Documentation
 *
 * @property int $id
 * @property string|null $title
 * @property string $file_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Documentation whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Documentation extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'file_path',
        'title'
    ];
}

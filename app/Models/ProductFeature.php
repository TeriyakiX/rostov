<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductFeature
 *
 * @property int $id
 * @property string $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductFeature whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductFeature extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title'
    ];
}

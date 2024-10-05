<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\ProductStatus
 *
 * @property int $id
 * @property string|null $title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ProductStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'title'
    ];
}

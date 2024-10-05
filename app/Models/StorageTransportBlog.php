<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\StorageTransportBlog
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog query()
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StorageTransportBlog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class StorageTransportBlog extends Model
{
    use HasFactory, CanSort;
}

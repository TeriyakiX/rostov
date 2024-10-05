<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\OrderInvoice
 *
 * @property int $id
 * @property string|null $title
 * @property string $file_path
 * @property int|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderInvoice whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class OrderInvoice extends Model
{
    use HasFactory, CanSort;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'file_path'
    ];
}

<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CashlessPaymentDocument
 *
 * @property int $id
 * @property string|null $title
 * @property string $file_path
 * @property int|null $order_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument query()
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CashlessPaymentDocument whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CashlessPaymentDocument extends Model
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

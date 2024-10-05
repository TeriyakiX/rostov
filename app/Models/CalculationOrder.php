<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\CalculationOrder
 *
 * @property int $id
 * @property string|null $name
 * @property string|null $phone_number
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder wherePhoneNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CalculationOrder whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class CalculationOrder extends Model
{
    use HasFactory, CanSort;
}

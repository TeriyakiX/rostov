<?php

namespace App\Models;

use App\Traits\CanSort;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\InstallationInstruction
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction query()
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction sort(array $sortArray)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|InstallationInstruction whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class InstallationInstruction extends Model
{
    use HasFactory, CanSort;
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CoatingsAttribute extends Model
{
    use HasFactory;

    protected $table = 'coatings_attributes';
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coating()
    {
        return $this->belongsTo(Coatings::class, '	coatings_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function attribute()
    {
        return $this->belongsTo(AttributeItem::class, 'attribute_coatings_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function option()
    {
        return $this->belongsTo(OptionItem::class, 'option_coatings_id');
    }
}

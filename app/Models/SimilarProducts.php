<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimilarProducts extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table='product_similar_product';
}

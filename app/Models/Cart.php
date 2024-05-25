<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_ids',
    ];

    // Relationship with User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor for product_ids
    public function getProductIdsAttribute($value)
    {
        return explode(';', $value);
    }

    // Mutator for product_ids
    public function setProductIdsAttribute($value)
    {
        if (is_array($value)) {
            $this->attributes['product_ids'] = implode(';', $value);
        } else {
            $this->attributes['product_ids'] = $value;
        }
    }
}


<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'currency',
        'stock_quantity',
        'mark_id'
    ];

    public function mark(): BelongsTo
    {
        return $this->belongsTo(Mark::class);
    }

    public function translations(): HasMany{
        return $this->hasMany(ProductLanguage::class);
    }

    public function bodyParts(): BelongsToMany{
        return $this->belongsToMany(BodyPart::class);
    }

    public function productTypes(): BelongsToMany{
        return $this->belongsToMany(ProductType::class);
    }

    public function skinTypes(): BelongsToMany{
        return $this->belongsToMany(SkinType::class);
    }

    public function skinConcerns(): BelongsToMany{
        return $this->belongsToMany(SkinConcern::class);
    }

    public function extras(): BelongsToMany{
        return $this->belongsToMany(Extra::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)
            ->using(OrderProduct::class)
            ->withPivot('quantity')
            ->withTimestamps();
    }
}

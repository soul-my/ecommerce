<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $table = 'products';
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function pricing()
    {
        return $this->hasOne(ProductPricing::class, 'product_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class, 'product_id', 'id');
    }

    public function seo()
    {
        return $this->hasOne(ProductSeo::class, 'product_id', 'id');
    }

    public function scopeActiveProducts($query)
    {
        return $query->where('status', 1);
    }

    public function scopeWithAssociates($query)
    {
        return $query->with('category')
        ->with('pricing')
        ->with('images')
        ->with('variants')
        ->with('seo');
    }

    public function scopeTransactionsBetween($query, $from, $to)
    {
        return $query->whereBetween('created_at', [$from, $to]);
    }

    public function scopeFilter($query, $request)
    {
        return $query->where(function($query) use ($request)
        {
            if(isset($request['search']))
            {
                $query->where('title', 'like' , '%' . $request['search'] . '%')
                ->orWhere('description', 'like', '%' . $request['search'] . '%');
            }
        });
    }
}

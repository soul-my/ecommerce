<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $table = 'categories';
    protected $guarded = [];

    protected const FEATURED = 'Featured';
    protected const NON_FEATURED = 'Non-featured';

    protected const ACTIVE = 'Active';
    protected const INACTIVE = 'In-active';

    public function child()
    {
        return $this->hasMany(ChildCategory::class, 'category_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function scopeActiveCategories($query)
    {
        return $query->with('child')->where('status', 1);
    }

    public function scopeWithAssociates($query)
    {
        return $query->with('products')->with('child');
    }

    public function scopeWithFeatured($query)
    {
        return $query->where('featured', 1);
    }

    public function getFeaturedNameAttribute()
    {
        if($this->featured == 0)
            return self::NON_FEATURED;

        if($this->featured == 1)
            return self::FEATURED;
    }

    public function getStatusNameAttribute()
    {
        if($this->status == 0)
            return self::ACTIVE;

        if($this->status == 1)
            return self::INACTIVE;
    }

    public function scopeFilter($query, $request)
    {
        return $query->where(function($query) use ($request)
        {
            if(isset($request['search']))
            {
                $query->where('name', 'like' , '%' . $request['search'] . '%')
                ->orWhere('status', 'like', '%' . $request['search'] . '%');

                if($request['search'] == 'featured')
                {
                    $query->orWhere('featured', 1);
                }

                if($request['search'] == 'non-featured')
                {
                    $query->orWhere('featured', 0);
                }

                if($request['search'] == 'active')
                {
                    $query->orWhere('status', 1);
                }

                if($request['search'] == 'in-active')
                {
                    $query->orWhere('status', 0);
                }
            }


        });
    }
}

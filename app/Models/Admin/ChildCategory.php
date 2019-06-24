<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ChildCategory extends Model
{
    //
    protected $table = 'child_categories';
    protected $guarded = [];
    
    protected const ACTIVE = 'Active';
    protected const INACTIVE = 'In-active';

    public function getStatusNameAttribute()
    {
        if($this->status == 0)
            return self::ACTIVE;

        if($this->status == 1)
            return self::INACTIVE;
    }
}

<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use App\Models\Admin\Category;

class CategoryComposer
{
    protected $category;

    public function __construct(Category $category)
    {
        $this->category = Category::activeCategories()->get();
    }


    public function compose(View $view)
    {
        $view->with('categories', $this->category);
    }
}
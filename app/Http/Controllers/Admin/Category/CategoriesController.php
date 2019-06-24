<?php

namespace App\Http\Controllers\Admin\Category;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin\Category;
use App\Models\Admin\ChildCategory;

//validation
use App\Http\Requests\Validations\Admin\CategoryValidation;
use App\Http\Requests\Validations\Admin\ChildCategoryValidation;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing($category_id = null)
    {
        //
        $type = 0;
        $request = \Request::only('search');

        if($category_id == null)
        {
            $categories = Category::filter($request)->get();
        }
        else
        {
            $type = 1;
            $categories = Category::where('id', $category_id)->filter($request)->with('child')->first();
            $categories = $categories->child;
        }

        return view('admin.categories.listing', compact('categories', 'type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($category_id = null)
    {
        //
        if($category_id)
        {
            $category = Category::find($category_id)->first();
            return view('admin.categories.create', compact('category'));
        }
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeParent(CategoryValidation $request)
    {
        $validated = $request->validated();

        if($validated)
        {
            $category = Category::create([
                "name" => $request->name,
                "status" => $request->status,
                "featured" => $request->featured,
            ]);
        }

        return redirect()->route("admin.categories.listing")->with('status', 'new category has been saved');
    }

    public function storeChild(ChildCategoryValidation $request, $category_id)
    {
        $validated = $request->validated();
        if($validated)
        {
            $category = ChildCategory::create(
            [
                'category_id' => $category_id,
                "name" => $request->name,
                "status" => $request->status,
            ]);
        }

        return redirect()->route("admin.categories.listing", ['category_id' => $category_id])->with('status', 'new category has been saved');
    }

    public function activate($cat_id, $type)
    {
        if($type == 'parent')
        {
            $category = Category::find($cat_id);
            $category->status = 1;

            if($category->save())
            {
                return back()->with('status', 'category has been activated');
            }
        }elseif($type == 'child')
        {
            $child = ChildCategory::find($cat_id);
            $child->status = 1;

            if($child->save())
            {
                return back()->with('status', 'child category has been activated');
            }
        }
        else
        {
            abort(404);
        }
    }


    public function deactivate($cat_id, $type)
    {
        if($type == 'parent')
        {
            $category = Category::find($cat_id);
            $category->status = 0;

            if($category->save())
            {
                return back()->with('status', 'category has been deactivated');
            }
        }elseif($type == 'child')
        {
            $child = ChildCategory::find($cat_id);
            $child->status = 0;

            if($child->save())
            {
                return back()->with('status', 'child category has been deactivated');
            }
        }
        else
        {
            abort(404);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($parent_category, $child_category = null)
    {
        //
        if($child_category)
        {
            $category = ChildCategory::find($child_category);
            $type = 1;
        }
        else
        {
            $category = Category::find($parent_category);
            $type = 0;
        }

        return view('admin.categories.edit', compact('category', 'type'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($parent_category, $child_category = null)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateParent(Request $request, $parent_category)
    {
        //
        $category = Category::find($parent_category);
        $category->name = $request->name;
        $category->status = $request->status;
        $category->featured = $request->featured;

        if($category->save())
        {
            return back()->with('status', 'your data has been updated');
        }

        return back()->withErrors(['errors' => 'Opps! error while updating your data']);
    }

    public function updateChild(Request $request, $child_category)
    {
        //
        $category = ChildCategory::find($child_category);
        $category->name = $request->name;
        $category->status = $request->status;   

        if($category->save())
        {
            return back()->with('status', 'your data has been updated');
        }

        return back()->withErrors(['errors' => 'Opps! error while updating your data']);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

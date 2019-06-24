<?php

namespace App\Http\Controllers\Admin\Product;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

//models
use App\Models\Admin\Product;
use App\Models\Admin\Category;
use App\Models\Admin\ProductImage;
use App\Models\Admin\ProductPricing;
use App\Models\Admin\ProductVariant;
use App\Models\Admin\ProductSeo;

//validations
use App\Http\Requests\Validations\Admin\ProductValidation;

//others
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listing()
    {
        //
        $request = \Request::only('search');
        $products = Product::filter($request)->get();

        return view('admin.products.listing', ['products' => $products, 'request' => $request]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::where('status', 1)->get();

        return view('admin.products.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductValidation $request)
    {
        $validated = $request->validated();
        if($validated)
        {
            DB::beginTransaction();
            try
            {
                $product = Product::create([
                    "title" => $request->title,
                    "category_id" => $request->category,
                    "description" => $request->description,
                    "sku" => $request->sku? $request->sku : '',
                    "barcode" => $request->barcode? $request->barcode : '',
                    "quantity" => $request->quantity,
                    "allow_buy" => $request->allowbuy ? $request->allowbuy : 0,
                ]);

                if($product)
                {
                    if($request->hasFile('files'))
                    {
                        $files = $request->file('files');
                        foreach($files as $file)
                        {
                            $upload = Storage::put('public/images/products/' . $product->id . '/', $file);
                            if($upload)
                            {
                                $filename = basename($upload);
                                $exists = Storage::exists('public/images/products/' . $product->id . '/' . $filename);

                                if($exists)
                                {
                                    $url = 'images/products/' . $product->id . '/' . $filename;
                                    ProductImage::create([
                                        "product_id" => $product->id,
                                        "url" => $url,
                                    ]);
                                }
                            }
                        }
                    }

                    $pricing = ProductPricing::create([
                        "product_id" => $product->id,
                        "base_price" => $request->base,
                        "sell_price" => $request->sell,
                    ]);

                    if($request->variant_key_1 || $request->variant_key_2 || $request->variant_key_3)
                    {
                        $variant_keys = array();

                        for($i = 1; $i < 3; $i++)
                        {
                            if($request->{'variant_key_' . $i })
                            {
                                array_push($variant_keys, $i); //save the index
                            }
                        }

                        foreach($variant_keys as $key)
                        {
                            $variant = ProductVariant::create([
                                "product_id" => $product->id,
                                "key" => $request->{'variant_key_' . $key },
                                "value" => $request->{'variant_value_' . $key },
                            ]);
                        }
                    }

                    if($request->pagetitle)
                    {
                        ProductSeo::create([
                            "product_id" => $product->id,
                            "page_title" => $request->pagetitle,
                            "meta_description" => $request->metadescription,
                        ]);
                    }
                }
            }
            catch(\Exception $e)
            {
                throw $e;
                DB::rollBack();
                return back()->withInput()->withErrors(['error' => $e->getMessage()]);
            }

            DB::commit();
            return redirect()->route('admin.products.edit', ['id' => $product->id])->with('status', 'your item has been stored');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
       abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('status', 1)->get();
        $product = Product::where('id', $id)
        ->with('category')
        ->with('pricing')
        ->with('images')
        ->with('variants')
        ->with('seo')
        ->first();


        return view('admin.products.edit', ['product' => $product, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductValidation $request, $id)
    {
        $validated = $request->validated();
        if($validated)
        {
            DB::beginTransaction();
            try
            {
                $product = Product::where('id', $id)
                ->with('category')
                ->with('pricing')
                ->with('images')
                ->with('variants')
                ->with('seo')->first();

                $product->update(
                [
                    "title" => $request->title,
                    "category_id" => $request->category,
                    "description" => $request->description,
                    "sku" => $request->sku? $request->sku : '',
                    "barcode" => $request->barcode? $request->barcode : '',
                    "quantity" => $request->quantity,
                    "allow_buy" => $request->allowbuy ? $request->allowbuy : 0,
                ]);

                if($product)
                {
                    if($request->hasFile('files'))
                    {
                        $files = $request->file('files');

                        foreach($product->images() as $image)
                        {
                            foreach($files as $file)
                            {
                                $upload = Storage::put('public/images/products/' . $product->id . '/', $file);

                                if($upload)
                                {
                                    $filename = basename($upload);
                                    $exists = Storage::exists('public/images/products/' . $product->id . '/' . $filename);

                                    if($exists)
                                    {
                                        $url = 'images/products/' . $product->id . '/' . $filename;
                                        $image->createOrUpdate(
                                        [
                                            "url" => $url,
                                        ]);
                                    }
                                }
                            }
                        }
                    }

                    $product->pricing->update([
                        "base_price" => $request->base,
                        "sell_price" => $request->sell,
                    ]);


                    if($request->pagetitle)
                    {
                        $product->seo->update([
                            "product_id" => $product->id,
                            "page_title" => $request->pagetitle,
                            "meta_description" => $request->metadescription,
                        ]);
                    }
                }
            }
            catch(\Exception $e)
            {
                DB::rollBack();
                throw $e;
                return back()->withInput()->withErrors(['error' => $e->getMessage() . $e->getLine()]);
            }

            DB::commit();
            return back()->with('status', 'Product has been updated!');
        }
    }

    public function activate($pro_id)
    {
        $product = Product::find($pro_id);
        $product->status = 1;

        if($product->save())
        {
            return back()->with('status', 'product has been deactivated');
        }


        return back()->withErrors(['error' => 'Failed to change product status']);
    }


    public function deactivate($pro_id)
    {

        $product = Product::find($pro_id);
        $product->status = 0;

        if($product->save())
        {
            return back()->with('status', 'product has been deactivated');
        }


        return back()->withErrors(['error' => 'Failed to change product status']);
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

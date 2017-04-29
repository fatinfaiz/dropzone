<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Brand;
use App\State;
use App\Category;
use App\Subcategory;
use App\Area;
use App\Http\Requests\CreateProductRequest;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //eager loading relationship to prevent multiple db queries
        $products = Product::with('brand','subcategory','area','user');
        //conditional searching

        if (!empty($request->search_anything)){

            $search_anything = $request->search_anything;

            $products = $products->where(function($query) use ($search_anything){
                $query->orWhere('product_name','like','%'.$request->search_anything.'%')
                ->orWhere('product_description','like','%'.$request->search_anything.'%');
            });
        }
        //paginate the data
        $products = $products->paginate(5);



        $brands = Brand::pluck('brand_name','id');
        $states = State::pluck('state_name','id');
        $categories = Category::pluck('category_name','id');

        return view('products.index',compact('products','brands','states','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //compact gune utk hantr data kepd form
        $brands = Brand::pluck('brand_name','id');
        $states = State::pluck('state_name','id');
        $categories = Category::pluck('category_name','id');

        return view('products.create', compact('states','brands','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $product = new Product;

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->brand_id = $request->brand_id;
        $product->product_price = $request->product_price;
        $product->area_id = $request->area_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->condition = $request->condition;

        $product->user_id = auth()->id();

        if($request->hasFile('product_image'))
        {
            $path = $request->product_image->store('images');
            $product->product_image = $request->product_image->hashName();
        }

        $product->save();

        flash('Product successfully inserted')->success();
//selepas berjaya simpan, set success message

        return redirect()->route('products.index');
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dptkn maklumat produk sediada
        $product = Product::find($id);

        $brands = Brand::pluck('brand_name','id');
        $states = State::pluck('state_name','id');
        $categories = Category::pluck('category_name','id');

        $areas = $this->getStateAreas($product->area->state_id);
        $subcategories = $this->getCategoriesSubcategories($product->subcategory->category_id);

        return view('products.edit',compact('states','brands','categories','product', 'areas', 'subcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $product = Product::findOrFail($id);

        $product->product_name = $request->product_name;
        $product->product_description = $request->product_description;
        $product->brand_id = $request->brand_id;
        $product->product_price = $request->product_price;
        $product->area_id = $request->area_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->condition = $request->condition;

        // if($request->hasFile('product_image'))
        // {
        //     $path = $request->product_image->store('images');
        //    // $product->product_image = $request->product_image->hashName();
        // }
        // }

        $product->save();

        flash('Product successfully updated')->success();

        return redirect()->route('products.edit',$product->id);

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

    public function getStateAreas($state_id){

        $areas = Area::whereStateId($state_id)->pluck('area_name','id');
        return $areas;

       // echo 'dah sampai controller ha, ni state id yang di pass kan'.$state_id;
    }

    public function getCategoriesSubcategories($category_id){
        $subcategories = Subcategory::whereCategoryId($category_id)->pluck('subcategory_name','id');
        return $subcategories;
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Specification;
use App\Models\SpecificationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        try{
            $query = Product::with('category', 'brand', 'primaryImage');

            if($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if($request->category) {
                $category = Category::with('children')->find($request->category);
                if($category && $category->children()->count() > 0) {
                    $childIds = $category->children()->pluck('id')->toArray();
                    $query->whereIn('id', $childIds);
                }
                else{
                    $query->where('category_id', $request->category);
                }
            }

            if($request->brand) {
                $query->where('brand_id', $request->brand);
            }

            if ($request->stock == 'out') {
                $query->where('stock', '=',0);
            }
            else if($request->stock == 'low'){
                $query->where('stock', '>', 0)->where('stock', '<=', 5);
            }
            else if($request->stock == 'in'){
                $query->where('stock', '>', 5);
            }


            if($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            }
            else if($request->sort == 'price_asc') {
                $query->orderBy('price', 'asc');
            }
            else if($request->sort == 'price_desc') {
                $query->orderBy('price', 'desc');
            }
            else {
                $query->orderBy('id', 'asc');
            }

            $this->data['products'] = $query->paginate(10);
            $this->data['categories'] = Category::whereNull('parent_id')->with('children')->get();
            $this->data['brands'] = Brand::all();

            return view('admin.products.index', $this->data);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.products.index');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $this->data['categories'] = Category::whereNull('parent_id')
                ->with('children')
                ->get();
            $this->data['brands'] = Brand::all();
            $this->data['specTypes'] = SpecificationType::all();
            return view('admin.products.create', $this->data);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error creating the product!');
        }

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateProductRequest $request)
    {
        $product = Product::create([
           'name' => $request->name,
           'price' => $request->price,
           'description' => $request->description,
           'stock' => $request->stock,
           'category_id' => $request->category_id,
           'brand_id' => $request->brand_id,
        ]);

        if($request->specs){
            foreach ($request->specs as $spec) {
                if($spec['type_id'] && $spec['value']){
                    Specification::create([
                        'product_id' => $product->id,
                        'specification_type_id' => $spec['type_id'],
                        'value' => $spec['value'],
                    ]);
                }
            }
        }

//        if ($request->hasFile('images')) {
//            foreach ($request->file('images') as $index => $image) {
//                $filename = time() . '_' . $image->getClientOriginalName();
//                $image->move(public_path('img/products'), $filename);
//
//                $img = ProductImage::create([
//                    'product_id' => $product->id,
//                    'image' => $filename,
//                    'is_primary' => $index === 0, // first image is primary
//                ]);
//            }
//        }
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('uploads', 'public');
                $filename = explode('/', $path)[1];

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $filename,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        //dd($product, $img);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $this->data['product'] = Product::with('category', 'brand', 'specifications','primaryImage')->where('id', $id)->first();
            $this->data['categories'] = Category::whereNull('parent_id')->with('children')->get();
            $this->data['brands'] = Brand::all();
            $this->data['specTypes'] = SpecificationType::all();
            return view('admin.products.edit', $this->data);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Product not found!');
        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try{
            $product = Product::find($id);
            if(!$product) {
                return redirect()->route('admin.products.index')->with('error', 'Product not found!');
            }

            $product->update([
                'name' => $request->name,
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $request->stock,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
            ]);

            if ($request->specs) {
                $product->specifications()->delete();
                foreach ($request->specs as $spec) {
                    if ($spec['type_id'] && $spec['value']) {
                        Specification::create([
                            'product_id' => $product->id,
                            'specification_type_id' => $spec['type_id'],
                            'value' => $spec['value'],
                        ]);
                    }
                }
            }

//            if ($request->hasFile('images')) {
//                foreach ($request->file('images') as $image) {
//                    $filename = time() . '_' . $image->getClientOriginalName();
//                    $image->move(public_path('img/products'), $filename);
//                    ProductImage::create([
//                        'product_id' => $product->id,
//                        'image' => $filename,
//                        'is_primary' => false,
//                    ]);
//                }
//            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('uploads', 'public');
                    $filename = explode('/', $path)[1];

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $filename,
                        'is_primary' => false,
                    ]);
                }
            }

            return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');

        }
        catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error editing product!');
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $product = Product::find($id);
            if(!$product) {
                return redirect()->route('admin.products.index')->with('error', 'Product not found!');
            }

            $product->delete();
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.'
            ]);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Error deleting the product!');
        }
    }

    public function deleteImage(string $id)
    {
        try {
            $image = ProductImage::findOrFail($id);

            // Don't allow deleting if it's the only image
            $imageCount = ProductImage::where('product_id', $image->product_id)->count();
            if ($imageCount <= 1) {
                return response()->json(['success' => false, 'message' => 'Cannot delete the only image!']);
            }

            // If deleting primary, set another as primary
            if ($image->is_primary) {
                $newPrimary = ProductImage::where('product_id', $image->product_id)
                    ->where('id', '!=', $id)
                    ->first();
                if ($newPrimary) {
                    $newPrimary->update(['is_primary' => true]);
                }
            }

            $image->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }

    public function setPrimaryImage(string $id)
    {
        try {
            $image = ProductImage::findOrFail($id);

            // Remove primary from all images of this product
            ProductImage::where('product_id', $image->product_id)
                ->update(['is_primary' => false]);

            // Set new primary
            $image->update(['is_primary' => true]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Something went wrong!']);
        }
    }
}

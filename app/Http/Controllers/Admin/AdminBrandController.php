<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBrandRequest;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminBrandController extends Controller
{
    public function index(Request $request)
    {
        try{
            $query = Brand::withCount('products');

            if($request->search){
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->products == 'has') {
                $query->has('products');
            }
            elseif ($request->products == 'none') {
                $query->doesntHave('products');
            }

            if ($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            }
            elseif ($request->sort == 'most') {
                $query->orderBy('products_count', 'desc');
            }
            elseif ($request->sort == 'least') {
                $query->orderBy('products_count', 'asc');
            }
            else {
                $query->orderBy('id', 'asc');
            }

            $this->data['brands'] = $query->paginate(10);
            return view('admin.brands.index', $this->data);
        }
        catch(\Exception $e){
            return redirect()->route('admin.dashboard')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBrandRequest $request)
    {
        try{
            Brand::create([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.brands.index')->with('success', 'Brand has been created!');
        }
        catch(\Exception $e){
            return redirect()->route('admin.brands.index')->with('error', 'Error creating the brand');
        }
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
            $this->data['brand'] = Brand::findOrFail($id);
            return view('admin.brands.edit', $this->data);
        }
        catch(\Exception $e){
            return redirect()->route('admin.brands.index')->with('error', 'Error updating the brand!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $brand = Brand::findOrFail($id);
            $brand->update([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.brands.index')->with('success', 'Brand has been updated!');

        }
        catch(\Exception $e){
            return redirect()->route('admin.brands.index')->with('error', 'Error updating the brand!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $brand = Brand::findOrFail($id);
            $products = Product::where('brand_id', $brand->id)->get();
            if($products->count() > 0){
                return response()->json([
                    'success' => false,
                    'message' => 'You cant delete this brand because it contains products!'
                ]);
            }
            if(!$brand){
                return redirect()->route('admin.brands.index')->with('error', 'Brand not found!');
            }
            $brand->delete();
            return response()->json([
                'success' => true,
                'message' => 'Brand deleted successfully!'
            ]);
        }
        catch(\Exception $e){
            return redirect()->route('admin.brands.index')->with('error', 'Error deleting the brand!');
        }
    }
}

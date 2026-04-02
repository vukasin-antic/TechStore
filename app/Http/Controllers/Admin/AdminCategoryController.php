<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    public function index(Request $request  )
    {
        try{
            $query = Category::withCount('products');

            if($request->search)
            {
                $query->where('name', 'like', '%'.$request->search.'%');
            }

            if($request->type == 'parent') {
                $query->whereNull('parent_id')->with('children');
            }
            else if($request->type == 'child') {
                $query->whereNotNull('parent_id');
            }
            else{
                $query->with('children');
            }
            if ($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            } elseif ($request->sort == 'most') {
                $query->orderBy('products_count', 'desc');
            } elseif ($request->sort == 'least') {
                $query->orderBy('products_count', 'asc');
            } else {
                $query->orderBy('id', 'asc');
            }
            $this->data['categories'] = $query->paginate(10);
            return view('admin.categories.index', $this->data);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->data['categories'] = Category::whereNull('parent_id')->get();
        return view('admin.categories.create', $this->data);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCategoryRequest $request)
    {
        try{
            Category::create([
                'name' => $request->name,
                'parent_id' => $request->parent_id,
            ]);

            return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
        }
        catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Error creating the category!');
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
        try {
            $this->data['category'] = Category::findOrFail($id);
            $this->data['categories'] = Category::whereNull('parent_id')->get();
            return view('admin.categories.edit', $this->data);
        } catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Category not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $category->update([
                'name' => $request->name,
                'parent_id' => $request->parent_id ?: null,
            ]);
            return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
        }
        catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Error updating the category!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $category = Category::findOrFail($id);
            $products = Product::where('category_id', $id)->get();
            if($products->count() > 0){
                return response()->json([
                    'success' => false,
                    'message' => 'You cant delete this category because it contains products!'
                ]);
            }
            if($category->children->count() > 0)
            {
                return response()->json([
                    'success' => false,
                    'message' => 'You cant delete this category because it contains other categories!'
                ]);
            }
            if(!$category){
                return redirect()->route('admin.categories.index')->with('error', 'Category not found!');
            }
            $category->delete();
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.categories.index')->with('error', 'Error deleting the category!');

        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateSpecificationRequest;
use App\Models\Specification;
use App\Models\SpecificationType;
use Illuminate\Http\Request;

class AdminSpecificationController extends Controller
{
    public function index(Request $request)
    {
        try{
            $query = SpecificationType::withCount('specifications');

            if($request->search){
                $query->where('name', 'like', '%' . $request->search . '%');
            }
            if ($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            }
            elseif ($request->sort == 'most') {
                $query->orderBy('specifications_count', 'desc');
            } elseif ($request->sort == 'least') {
                $query->orderBy('specifications_count', 'asc');
            } else {
                $query->orderBy('id', 'asc');
            }


            $this->data['specifications'] = $query->paginate(10);
            return view('admin.specifications.index', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.dashboard')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.specifications.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateSpecificationRequest $request)
    {
        try{
            SpecificationType::create([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.specifications.index')->with('success', 'Specification created!');
        }
        catch (\Exception $exception){
            return redirect()->route('admin.specifications.index')->with('error', 'Error creating specification!');
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
            $this->data['specification'] = SpecificationType::findOrFail($id);
            return view('admin.specifications.edit', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.specifications.index')->with('error', 'Error updating specification!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateSpecificationRequest $request, string $id)
    {
        try{
            $specification = SpecificationType::findOrFail($id);
            $specification ->update([
                'name' => $request->name,
            ]);
            return redirect()->route('admin.specifications.index')->with('success', 'Specification updated!');
        }
        catch (\Exception $exception){
            return redirect()->route('admin.specifications.index')->with('error', 'Error updating specification!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $specification = SpecificationType::findOrFail($id);
            $product = Specification::where('specification_type_id', $specification->id)->get();

            if($product->count() > 0){
                return response()->json([
                    'success' => false,
                    'message' => 'You can’t delete this specification because it is assigned to one or more products!'
                ]);
            }
            if(!$specification){
                return redirect()->route('admin.specifications.index')->with('error', 'Specification not found!');
            }

            $specification->delete();
            return response()->json([
                'success' => true,
                'message' => 'Specification deleted successfully!'
            ]);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.specifications.index')->with('error', 'Error deleting specification!');
        }
    }
}

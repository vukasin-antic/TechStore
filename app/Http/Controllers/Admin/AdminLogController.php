<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Log;
use Illuminate\Http\Request;

class AdminLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Log::latest();

            if($request->search){
                $query->where('user', 'like', '%' . $request->search . '%')
                      ->orWhere('route', 'like', '%' . $request->search . '%');
            }

            if ($request->date_from) {
                $query->whereDate('date', '>=', $request->date_from);
            }

            if ($request->date_to) {
                $query->whereDate('date', '<=', $request->date_to);
            }

            if ($request->route) {
                $query->where('route', 'like', '%' . $request->route . '%');
            }
            $this->data['logs'] = $query->paginate(20);
            return view('admin.logs.index', $this->data);

        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Something went wrong');

        }

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            Log::findOrFail($id)->delete();
            return response()->json([
                'success' => true,
                'message' => 'Log deleted successfully!'
            ]);
        }
        catch (\Exception $e)
        {
            return redirect()->back()->with('error', 'Something went wrong');
        }
    }

    public function clearAll()
    {
        try{
            Log::truncate();
            return response()->json([
                'success' => true,
                'message' => 'All logs cleared!'
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong!'
            ]);
        }
    }
}

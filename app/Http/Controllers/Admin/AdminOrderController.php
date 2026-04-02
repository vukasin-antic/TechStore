<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = Order::with('user', 'orderItems');

            if($request->search){
                $query->where('order_number', 'like', '%'.$request->search.'%');
            }
            if($request->status){
                $query->where('status', $request->status);
            }
            if ($request->discount) {
                $query->where('discount', $request->discount == 'yes' ? true : false);
            }
            if($request->date_from){
                $query->whereDate('created_at', '>=', $request->date_from);
            }
            if($request->date_to){
                $query->whereDate('created_at', '<=', $request->date_to);
            }
            if ($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            } elseif ($request->sort == 'price_asc') {
                $query->orderBy('total_price', 'asc');
            } elseif ($request->sort == 'price_desc') {
                $query->orderBy('total_price', 'desc');
            } else {
                $query->orderBy('id', 'asc');
            }

            $this->data['orders'] = $query->paginate(10);
            return view('admin.orders.index', $this->data);

        }
        catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Something went wrong!');
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
        try{
            $this->data['order'] = Order::with('orderItems.product', 'user')->findOrFail($id);
            return view('admin.orders.show', $this->data);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $this->data['order'] = Order::with('orderItems.product', 'user')->findOrFail($id);
            return view('admin.orders.edit', $this->data);
        } catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, string $id)
    {
        try{
            $order = Order::findOrFail($id);

            if ($order->status === 'cancelled') {
                return redirect()->back()->with('error', 'Cancelled orders cannot be modified!');
            }

            $order->update([
                'status' => $request->status,
            ]);

            return redirect()->route('admin.orders.index')->with('success', 'Order status updated!');
        }
        catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Something went wrong!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $order = Order::with('orderItems.product')->findOrFail($id);

            if($order->status !== 'cancelled'){
                return response()->json([
                    'success' => false,
                    'message' => 'Order cannot be deleted if its not cancelled!'
                ]);
            }
            foreach ($order->orderItems as $item) {
                $item->product->increment('stock', $item->quantity);
            }

            $order->delete();
            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully!'
            ]);
        }
        catch (\Exception $e) {
            return redirect()->route('admin.orders.index')->with('error', 'Order not found!');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try{
            $query = User::withCount('orders');

            if($request->search){
                $query->where('first_name', 'like', '%'.$request->search.'%')
                      ->orWhere('last_name', 'like', '%'.$request->search.'%')
                      ->orWhere('email', 'like', '%'.$request->search.'%')
                      ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ['%'.$request->search.'%']);
            }

            if($request->role){
                $query->where('role', $request->role);
            }
            if ($request->orders == 'has') {
                $query->has('orders');
            }
            elseif ($request->orders == 'none') {
                $query->doesntHave('orders');
            }
            if ($request->sort == 'newest') {
                $query->orderBy('id', 'desc');
            } else {
                $query->orderBy('id', 'asc');
            }

            $this->data['users'] = $query->paginate(15);
            return view('admin.users.index', $this->data);
        }
        catch (\Exception $exception){
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
        try{
            $this->data['user'] = User::with('orders.orderItems.product')->findOrFail($id);
            return view('admin.users.show', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.users.index')->with('error', 'User not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try{
            $this->data['user'] = User::findOrFail($id);
            return view('admin.users.edit', $this->data);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.users.index')->with('error', 'User not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        try{
            $user = User::findOrFail($id);

            if($user->id == session('user')['id'] && $request->role !== $user->role){
                return redirect()->back()->with('error', 'You cannot change your own role!');
            }

            $newData = [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'role' => ($user->id == session('user')['id']) ? $user->role : $request->role,
            ];

            if($user->first_name === $newData['first_name'] &&
                $user->last_name  === $newData['last_name']  &&
                $user->email      === $newData['email']      &&
                $user->role       === $newData['role'])
            {
                return redirect()->route('admin.users.index')->with('info', 'No changes were made.');
            }

            $user->update($newData);

            return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
        }
        catch (\Exception $exception){
            return redirect()->route('admin.users.index')->with('error', 'Error updating user!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $user = User::findOrFail($id);

            if(!$user) {
                return redirect()->route('admin.users.index')->with('error', 'User not found!');
            }
            if($user->id == session('user')['id']){
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account!'
                ]);
            }
            $user->delete();
            return response()->json([
                'success' => true,
                'message' => 'User with email: ' . $user->email .' deleted successfully!'
            ]);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.users.index')->with('error', 'Error deleting user!');
        }
    }

    public function ban(string $id)
    {
        try{
            $user = User::findOrFail($id);
            if ($user->id == session('user')['id']) {
                return response()->json([
                    'success' => false,
                    'message' =>'You cannot ban your own account!'
                ]);
            }
            $user->update(['is_banned' => !$user->is_banned]);
            $action = $user->is_banned ? 'banned' : 'unbanned';

            return response()->json(['success' => true, 'message' => "User {$action} successfully!", 'is_banned' => $user->is_banned]);
        }
        catch (\Exception $exception){
            return redirect()->route('admin.users.index')->with('error', 'Error banning user!');
        }
    }
}

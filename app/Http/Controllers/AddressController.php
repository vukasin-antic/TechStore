<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{


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
    public function store(NewAddressRequest $request)
    {
        try{
            if($request->is_default){
                Address::where('user_id', session('user')['id'])->update(['is_default' => 0]);
            }

            Address::create([
                'user_id' => (session('user')['id']),
                'label' => $request->label,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'is_default' => $request->boolean('is_default'),
            ]);


            return redirect()->route('profile.edit')->with('address_success', 'Address created successfully!');
        }
        catch(\Exception $e){
            return redirect()->route('profile.edit')->with('error', 'Error creating address');

        }

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressRequest $request, string $id)
    {
        try{
            if($request->is_default){
                Address::where('user_id', session('user')['id'])->update(['is_default' => 0]);
            }

            $address = Address::where('user_id', session('user')['id'])->findOrFail($id);
            $address->update([
                'label' => $request->label,
                'address' => $request->address,
                'city' => $request->city,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'is_default' => $request->is_default == null ? 0 : 1,
            ]);

            return redirect()->route('profile.edit')->with('address_success', 'Address updated successfully!');
        }
        catch(\Exception $e){
            return redirect()->route('profile.edit')->with('error', 'Error updating address');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $address = Address::where('user_id', session('user')['id'])->findOrFail($id);
            $address->delete();

            return redirect()->route('profile.edit')->with('address_success', 'Address deleted successfully!');
        }
        catch(\Exception $e){
            return redirect()->route('profile.edit')->with('error', 'Error deleting address');
        }
    }
}

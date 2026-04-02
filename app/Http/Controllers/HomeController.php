<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(){
        $this->data ['products'] = Product::with('category', 'brand', 'primaryImage')->take(8)->get();
        return view('pages.main', $this->data);
    }
}

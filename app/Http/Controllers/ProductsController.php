<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function __construct()
    {
        // Require authentication for all except index and show
        $this->middleware('auth')->except(['index']);
        // Only admin can create, update, delete
        $this->middleware('admin')->except(['index', 'purchaseForm', 'purchase']);
    }

    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'quantity_available' => 'required|integer|min:0',
        ]);

        Product::create($request->only('name', 'price', 'quantity_available'));

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function purchaseForm(Product $product)
    {
        return view('products.purchase', compact('product'));
    }

    public function purchase(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $quantity = $request->input('quantity');

        if ($quantity > $product->quantity_available) {
            return back()->withErrors(['quantity' => 'Not enough quantity available.']);
        }

        $totalPrice = $product->price * $quantity;

        // Create transaction
        Transaction::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $quantity,
            'total_price' => $totalPrice,
        ]);

        // Update product quantity
        $product->decrement('quantity_available', $quantity);

        return redirect()->route('products.index')->with('success', 'Purchase successful!');
    }
}
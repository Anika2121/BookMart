<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = array_sum(array_column($cart, 'subtotal'));
        return view('cart.index', compact('cart', 'total'));
    }

    public function add(Request $request, Book $book)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$book->id])) {
            $cart[$book->id]['quantity']++;
            $cart[$book->id]['subtotal'] = $cart[$book->id]['quantity'] * $book->price;
        } else {
            $cart[$book->id] = [
                'id'       => $book->id,
                'title'    => $book->title,
                'author'   => $book->author,
                'price'    => $book->price,
                'image'    => $book->image,
                'quantity' => 1,
                'subtotal' => $book->price,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart.index')->with('success', 'Book added to cart!');
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->route('cart.index')->with('success', 'Book removed from cart!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared!');
    }
}
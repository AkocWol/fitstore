<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = $request->session()->get('cart', []);
        $total = 0;
        $count = 0;

        foreach ($cart as $line) {
            $total += ($line['price'] * $line['qty']);
            $count += $line['qty'];
        }

        return view('cart', compact('cart', 'total', 'count'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'product_id' => ['required','integer','exists:products,id'],
            'qty'        => ['nullable','integer','min:1'],
        ]);

        $qty = $data['qty'] ?? 1;
        $product = Product::findOrFail($data['product_id']);

        $cart = $request->session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['qty'] += $qty;
        } else {
            // Stel een veilige placeholder voor image samen (optioneel)
            $rawImg = $product->image_url ?? $product->image ?? $product->image_path ?? null;
            $isFull = is_string($rawImg) && (str_starts_with($rawImg, 'http://') || str_starts_with($rawImg, 'https://'));
            $imgSrc = $rawImg
                ? ($isFull ? $rawImg : asset('storage/' . ltrim($rawImg, '/')))
                : (file_exists(public_path('images/placeholder.png'))
                    ? asset('images/placeholder.png')
                    : 'https://placehold.co/100x100?text=%20');

            $cart[$product->id] = [
                'id'    => $product->id,
                'name'  => $product->name,
                'price' => (float) $product->price,
                'qty'   => (int) $qty,
                'image' => $imgSrc,
            ];
        }

        $request->session()->put('cart', $cart);

        return redirect()->route('cart')
            ->with('success', "{$product->name} is added to the cart.");
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'qty' => ['required','integer','min:1'],
        ]);

        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            $cart[$id]['qty'] = (int) $data['qty'];
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', 'Aantal bijgewerkt.');
    }

    public function remove(Request $request, $id)
    {
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            $request->session()->put('cart', $cart);
        }
        return back()->with('success', 'Product verwijderd uit winkelwagen.');
    }

    public function clear(Request $request)
    {
        $request->session()->forget('cart');
        return back()->with('success', 'Winkelwagen geleegd.');
    }
}

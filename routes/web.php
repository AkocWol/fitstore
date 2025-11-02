<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;

// Homepage
Route::get('/', fn () => view('welcome'))->name('home');

// Shop (publiek)
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// ---- CART & CHECKOUT (alleen voor ingelogde gebruikers) ----
Route::middleware('auth')->group(function () {

    // Hulpfunctie om cart-data uit sessie te halen
    function getCartData()
    {
        $cart = session('cart', []);
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $qty = $cart[$product->id];
                $subtotal = $product->price * $qty;
                $items[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'qty' => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return [$items, $total];
    }

    // Cart bekijken
    Route::get('/cart', function () {
        [$items, $total] = getCartData();
        return view('cart', compact('items', 'total'));
    })->name('cart');

    // Product toevoegen aan cart
    Route::post('/cart/add', function (Request $request) {
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('qty', 1));

        $product = Product::find($productId);
        if (!$product) {
            return back()->with('error', 'Product niet gevonden.');
        }

        $cart = session('cart', []);
        $cart[$productId] = ($cart[$productId] ?? 0) + $qty;
        session(['cart' => $cart]);

        return redirect()->route('cart')->with('success', 'Product toegevoegd aan je winkelwagen.');
    })->name('cart.add');

    // Product verwijderen
    Route::post('/cart/remove', function (Request $request) {
        $productId = (int) $request->input('product_id');
        $cart = session('cart', []);
        unset($cart[$productId]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product verwijderd.');
    })->name('cart.remove');

    // Hele winkelwagen leegmaken
    Route::post('/cart/clear', function () {
        session()->forget('cart');
        return back()->with('success', 'Winkelwagen geleegd.');
    })->name('cart.clear');

    // Aantal bijwerken (qty)
    Route::post('/cart/update', function (Request $request) {
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('qty', 1));

        $cart = session('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] = $qty;
            session(['cart' => $cart]);
            return back()->with('success', 'Aantal bijgewerkt.');
        }

        return back()->with('error', 'Product zit niet (meer) in je winkelwagen.');
    })->name('cart.update');

    // Checkout bekijken
    Route::get('/checkout', function () {
        [$items, $total] = getCartData();
        return view('checkout', compact('items', 'total'));
    })->name('checkout');

    // Checkout afronden (demo)
    Route::post('/checkout/place', function (Illuminate\Http\Request $request) {
        [$items, $total] = getCartData();
        if (empty($items)) {
            return redirect()->route('shop')->with('error', 'Je winkelwagen is leeg.');
        }

        // Validate the chosen payment method
        $data = $request->validate([
            'payment' => ['required', 'in:ideal,card'],
        ]);

        $labels = [
            'ideal' => 'iDEAL (demo)',
            'card'  => 'Creditcard (demo)',
        ];

        // (In a real checkout, you'd store order info here)
        session()->forget('cart');

        // Redirect back to checkout with success message
        return redirect()
            ->route('checkout')
            ->with('success', 'Betaling geslaagd (demo).')
            ->with('paid_with', $labels[$data['payment']] ?? 'Onbekend')
            ->with('paid_total', $total);
    })->name('checkout.place');

    // Orders bekijken
    Route::get('/orders', fn () => view('orders'))->name('orders');

    // Account (profiel)
    Route::get('/account', [ProfileController::class, 'edit'])->name('account');
    Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';

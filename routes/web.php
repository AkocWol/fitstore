<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Product;

// ========================
// Public
// ========================

// Homepage
Route::get('/', fn () => view('welcome'))->name('home');

// Shop (publiek)
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

Route::view('/about', 'about')->name('about');

// ========================
// CART & CHECKOUT (alleen voor ingelogde gebruikers)
// ========================
Route::middleware('auth')->group(function () {

    // ------------------------
    // Helper: cart-data uit sessie
    // ------------------------
    function getCartData()
    {
        $cart = session('cart', []); // [productId => qty]
        $items = [];
        $total = 0;

        if (!empty($cart)) {
            $products = Product::whereIn('id', array_keys($cart))->get();
            foreach ($products as $product) {
                $qty = $cart[$product->id];
                $subtotal = $product->price * $qty;
                $items[] = [
                    'id'       => $product->id,
                    'name'     => $product->name,
                    'price'    => $product->price,
                    'qty'      => $qty,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return [$items, $total];
    }

    // ------------------------
    // CART
    // ------------------------

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

        return redirect()->route('cart')->with('success', 'Added to cart.');
    })->name('cart.add');

    // Aantal bijwerken (qty)
    Route::post('/cart/update', function (Request $request) {
        $productId = (int) $request->input('product_id');
        $qty = max(1, (int) $request->input('qty', 1));

        $cart = session('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] = $qty;
            session(['cart' => $cart]);
            return back()->with('success', 'Amounth changed');
        }

        return back()->with('error', 'Product is  not anymore in the cart.');
    })->name('cart.update');

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


    // ------------------------
    // CHECKOUT
    // ------------------------

    // NEW: start checkout via knop (zet een sessie-vlag)
    Route::post('/checkout/start', function () {
        [$items, $total] = getCartData();
        if (empty($items)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }
        session(['checkout_ready' => true]);
        return redirect()->route('checkout');
    })->name('checkout.start');

    // UPDATED: Checkout alleen tonen als via de knop gestart
    Route::get('/checkout', function () {
        if (!session('checkout_ready')) {
            return redirect()->route('cart')->with('error', 'Open the checkout using the button "Go to checkout".');
        }

        [$items, $total] = getCartData();

        // (Optioneel: single-use vlag — uncomment als je wilt)
        // session()->forget('checkout_ready');

        return view('checkout', compact('items', 'total'));
    })->name('checkout');

    // UPDATED: Checkout afronden (demo) + vlag opruimen
    Route::post('/checkout/place', function (Request $request) {
        [$items, $total] = getCartData();
        if (empty($items)) {
            return redirect()->route('shop')->with('error', 'Your cart is empty');
        }

        // Validate the chosen payment method
        $data = $request->validate([
            'payment' => ['required', 'in:ideal,card'],
        ]);

        $labels = [
            'ideal' => 'iDEAL (demo)',
            'card'  => 'Creditcard (demo)',
        ];

        // DEMO: cart legen + toegangsvlag verwijderen
        session()->forget('cart');
        session()->forget('checkout_ready');

        // Blijf op checkout met duidelijke melding
        return redirect()
            ->route('checkout')
            ->with('success', 'Betaling geslaagd (demo).')
            ->with('paid_with', $labels[$data['payment']] ?? 'Onbekend')
            ->with('paid_total', $total);
    })->name('checkout.place');

    // (Laat staan, ook al gebruik je 'm nu niet)
    Route::get('/orders', fn () => view('orders'))->name('orders');


    // ------------------------
    // ACCOUNT (profiel)
    // ------------------------
    Route::get('/account', [ProfileController::class, 'edit'])->name('account');
    Route::patch('/account', [ProfileController::class, 'update'])->name('account.update');
    Route::delete('/account', [ProfileController::class, 'destroy'])->name('account.destroy');
});

require __DIR__ . '/auth.php';

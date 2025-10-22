<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $q        = trim((string) $request->query('q', ''));
        $sort     = $request->query('sort', 'newest'); // newest|latest|price_asc|price_desc|name_asc|name_desc
        $category = $request->query('category');
        $maxPrice = $request->query('max_price');

        $products = Product::query()
            // FULL-TEXT: alleen kolommen die bestaan
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($qq) use ($q) {
                    $qq->where('name', 'like', "%{$q}%");

                    if (Schema::hasColumn('products', 'description')) {
                        $qq->orWhere('description', 'like', "%{$q}%");
                    }
                    if (Schema::hasColumn('products', 'sku')) {
                        $qq->orWhere('sku', 'like', "%{$q}%");
                    }
                });
            })
            // Category alleen als kolom bestaat
            ->when($category && Schema::hasColumn('products', 'category'), function ($q2) use ($category) {
                $q2->where('category', $category);
            })
            // Max price (price is DECIMAL in jouw migratie)
            ->when(is_numeric($maxPrice), fn ($q2) => $q2->where('price', '<=', (float) $maxPrice))
            // Sorteren
            ->when(true, function ($q2) use ($sort) {
                switch ($sort) {
                    case 'price_asc':  $q2->orderBy('price', 'asc');  break; // goedkoop → duur
                    case 'price_desc': $q2->orderBy('price', 'desc'); break; // duur → goedkoop
                    case 'name_asc':   $q2->orderBy('name', 'asc');   break;
                    case 'name_desc':  $q2->orderBy('name', 'desc');  break;
                    case 'latest':
                    case 'newest':
                    default:           $q2->latest();                 break;
                }
            })
            ->paginate(12)
            ->withQueryString();

        // Partial JSON voor Alpine
        if ($request->boolean('partial')) {
            return response()->json([
                'grid'       => view('shop.grids._product-grid', ['products' => $products])->render(),
                'pagination' => view('shop.partials._pagination', ['paginator' => $products])->render(),
            ]);
        }

        return view('shop', compact('products'));
    }
}

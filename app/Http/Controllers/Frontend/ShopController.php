<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\OrderStatusEnums;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\RecentView;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Tag;
use Illuminate\Http\Request;

class ShopController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::with('subCategories')->get();
        $tags = Tag::all();
        $sizes = Size::all();
        $colors = Color::all();
        $brands = Brand::all();

        // Base Query 
        $query = Product::with(['tags'])->where('is_active', 1);

        // Search Query
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {

            // Check if category exists
            $singleCategory = Category::where('slug', $request->category)->first();


            if ($singleCategory) {
                // If category exists, add it to the request
                $existingCategories = $request->input('categories', []);

                // Check if category is already added
                if (!in_array($singleCategory->id, $existingCategories)) {
                    $existingCategories[] = $singleCategory->id;
                    $request->merge(['categories' => $existingCategories]);
                }
            }
        }

        // Subcategory Filter
        if ($request->filled('subcategory')) {
            $singleSubCategory = SubCategory::where('slug', $request->subcategory)->first();

            if ($singleSubCategory) {
                $existingSubCategories = $request->input('subcategories', []);

                if (!in_array($singleSubCategory->id, $existingSubCategories)) {
                    $existingSubCategories[] = $singleSubCategory->id;
                    $request->merge(['subcategories' => $existingSubCategories]);
                }
            }
        }

        // Single Brand Check
        if ($request->filled('brand')) {
            
            // Check if brand exists
            $singleBrand = Brand::where('slug', $request->brand)->first();

            if ($singleBrand) {
                $existingBrands = $request->input('brands', []);

                // Check if brand is already added
                if (!in_array($singleBrand->id, $existingBrands)) {
                    $existingBrands[] = $singleBrand->id;
                    $request->merge(['brands' => $existingBrands]);
                }
            }
        }

        // Category Filter
        if ($request->filled('categories')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->whereIn('category_id', $request->categories);
            });
        }

        if ($request->filled('subcategories')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->whereIn('sub_category_id', $request->subcategories);
            });
        }

        if ($request->filled('brands')) {
            $query->whereHas('details', function ($q) use ($request) {
                $q->whereIn('brand_id', $request->brands);
            });
        }

        // Price Filter (Min & Max)
        if ($request->filled('min_price') && $request->filled('max_price')) {
            $query->whereBetween('selling_price', [$request->min_price, $request->max_price]);
        }

        // Color Filter (Checking inside variants)
        if ($request->filled('colors')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('color_id', $request->colors);
            });
        }

        // Size Filter (Checking inside variants)
        if ($request->filled('sizes')) {
            $query->whereHas('variants', function ($q) use ($request) {
                $q->whereIn('size_id', $request->sizes);
            });
        }

        // Tag Filter
        if ($request->filled('tags')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->whereIn('tags.id', $request->tags); // pivot table check
            });
        }

        // Sorting
        if ($request->filled('sort')) {
            if ($request->sort == 'low_to_high') {
                $query->orderBy('selling_price', 'asc');
            } elseif ($request->sort == 'high_to_low') {
                $query->orderBy('selling_price', 'desc');
            }
        } else {
            $query->latest(); // Default sorting
        }

        $products = $query->paginate(20)->withQueryString();

        $recentlyAdded = Product::where('is_active', 1)->latest()->take(3)->get();

        // AJAX Request Check
        if ($request->ajax()) {
            $html = view('frontend.shop.partials.product_list', compact('products'))->render();

            return response()->json([
                'html' => $html,
                'total' => $products->total()
            ])->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
                'Vary' => 'X-Requested-With'
            ]);
        }

        return view('frontend.shop.index', compact('categories', 'products', 'recentlyAdded', 'tags', 'sizes', 'colors', 'brands'));
    }

    public function show(string $slug)
    {
        $product = Product::with([
            'variants.color:id,name,color_code',
            'variants.size:id,name',
            'galleries',
            'details.category',
            'tags',
            'productReviews' => function ($q) {
                $q->where('is_approved', true)->latest();
            },
            'productReviews.user'
        ])->where('slug', $slug)
            ->firstOrFail();

        // ================= RECENTLY VIEWED LOGIC (DATABASE) =================

        if (auth('web')->check()) {
            $userId = auth('web')->id();

            // update or create recent view
            RecentView::updateOrCreate(
                ['user_id' => $userId, 'product_id' => $product->id],
                ['updated_at' => now()]
            );

            // check if user has more than 12 views
            $viewCount = RecentView::where('user_id', $userId)->count();

            if ($viewCount > 12) {
                // delete oldest views
                $oldestViews = RecentView::where('user_id', $userId)
                    ->orderBy('updated_at', 'asc')
                    ->limit($viewCount - 12)
                    ->pluck('id');

                RecentView::destroy($oldestViews);
            }
        }
        // ================= END RECENTLY VIEWED LOGIC =================

        // ================= REVIEW ELIGIBILITY LOGIC =================
        $canReview = false;

        if (auth('web')->check()) {
            $userId = auth('web')->id();

            // Check if user has purchased the product
            $hasPurchased = Order::where('user_id', $userId)
                ->whereIn('order_status', [
                    OrderStatusEnums::DELIVERED->value,
                    OrderStatusEnums::RETURN_REQUESTED->value,
                    OrderStatusEnums::RETURNED->value
                ])
                ->whereHas('items', function ($query) use ($product) {
                    $query->where('product_id', $product->id);
                })->exists();

            // Check if user has already reviewed the product
            $alreadyReviewed = ProductReview::where('user_id', $userId)
                ->where('product_id', $product->id)
                ->exists();

            $canReview = $hasPurchased && !$alreadyReviewed;
        }
        // ================= END REVIEW ELIGIBILITY LOGIC =================


        // Default variant
        $defaultVariant = $product->variants
            ->firstWhere(fn($v) => is_null($v->color_id) && is_null($v->size_id))
            ?? $product->variants->first();

        // Frontend variants data
        $variantsData = $product->variants->map(function ($v) {
            return [
                'id'          => $v->id,
                'color_id'    => $v->color_id,
                'size_id'     => $v->size_id,
                'sku'         => $v->sku_code,
                'price'       => $v->selling_price,
                'discount'    => $v->discount_price ? $v->discount_price : null,
                'stock'       => $v->current_stock,
                'in_stock'    => $v->current_stock > 0,
            ];
        });

        return view('frontend.shop.show', compact(
            'product',
            'defaultVariant',
            'variantsData',
            'canReview'
        ));
    }

    public function ajaxSearch(Request $request)
    {
        // If search input is empty, return empty html
        if (!$request->search) {
            return response()->json(['html' => '']);
        }

        // Search for products with name like '%search%' and return first 5 results
        $products = Product::where('is_active', 1)
            ->where('name', 'like', '%' . $request->search . '%')
            ->take(5)
            ->get();

        // Return HTML of search dropdown
        $html = view('frontend.layouts.partials.search_dropdown', compact('products'))->render();

        return response()->json(['html' => $html]);
    }
}

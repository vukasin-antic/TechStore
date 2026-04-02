<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\SpecificationType;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $selectedCategory = $request->category
            ? Category::with('children')->find($request->category)
            : null;

        $childIds = $this->getCategoryIds($selectedCategory);

        $products = Product::with('category', 'brand', 'primaryImage');

        if ($request->search) {
            $products->where('name', 'like', '%' . $request->search . '%');
        }

        if ($childIds) {
            $products->whereIn('category_id', $childIds);
        }

        if ($request->brand) {
            $products->whereIn('brand_id', (array) $request->brand);
        }

        if ($request->spec) {
            foreach ($request->spec as $typeId => $values) {
                $products->whereHas('specifications', fn($q) =>
                $q->where('specification_type_id', $typeId)
                    ->whereIn('value', (array) $values)
                );
            }
        }

        $sortOptions = [
            'newest'     => ['id', 'desc'],
            'price_asc'  => ['price', 'asc'],
            'price_desc' => ['price', 'desc'],
        ];

        [$column, $direction] = $sortOptions[$request->sort] ?? ['id', 'asc'];
        $products->orderBy($column, $direction);

        $this->data['products']   = $products->paginate(9);
        $this->data['categories'] = $this->getCategories($request);
        $this->data['brands']     = $this->getBrands($request, $selectedCategory);
        $this->data['specTypes']  = $this->getSpecTypes($request, $selectedCategory);

        return view('pages.shop', $this->data);
    }

// Vraća sve category ID-eve (parent + children) ili null
    private function getCategoryIds(?Category $category): ?array
    {
        if (!$category) return null;

        $ids = [$category->id];

        if ($category->children->count() > 0) {
            $ids = array_merge($ids, $category->children->pluck('id')->toArray());
        }

        return $ids;
    }

    private function getCategories(Request $request): \Illuminate\Database\Eloquent\Collection
    {
        return Category::whereNull('parent_id')
            ->with(['children' => fn($q) => $q->withCount(['products' => fn($q) =>
            $request->brand ? $q->whereIn('brand_id', (array) $request->brand) : $q
            ])])
            ->withCount(['products' => fn($q) =>
            $request->brand ? $q->whereIn('brand_id', (array) $request->brand) : $q
            ])
            ->get();
    }

    private function getBrands(Request $request, ?Category $category): \Illuminate\Database\Eloquent\Collection
    {
        $childIds = $this->getCategoryIds($category);

        return Brand::withCount(['products' => function($q) use ($request, $childIds) {
            if ($childIds) {
                $q->whereIn('category_id', $childIds);
            }
            if ($request->spec) {
                foreach ($request->spec as $typeId => $values) {
                    $q->whereHas('specifications', fn($s) =>
                    $s->where('specification_type_id', $typeId)
                        ->whereIn('value', (array) $values)
                    );
                }
            }
        }])->get();
    }

    private function getSpecTypes(Request $request, ?Category $category): \Illuminate\Support\Collection
    {
        if (!$category || $category->children->count() > 0) {
            return collect();
        }

        return SpecificationType::whereHas('specifications', fn($q) =>
        $q->whereHas('product', fn($p) => $p->where('category_id', $category->id))
        )
            ->with(['specifications' => fn($q) =>
            $q->select('specification_type_id', 'value')
                ->whereHas('product', fn($p) => $p->where('category_id', $category->id))
                ->groupBy('specification_type_id', 'value')
            ])
            ->get();
    }
}

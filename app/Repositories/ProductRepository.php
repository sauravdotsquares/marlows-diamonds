<?php

namespace App\Repositories;

use App\Models\Products;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class ProductRepository
{
    /**
     * Get product listing with filters, pagination, and sorting.
     */
    public function getProductListing($queryString = null, $requestData = [])
    {
        $is404 = false;
        $categoryData = null;
        $getAjaxResponses = true;
        $page = 30;
        $category_custom_query = "";

        /** Helper: build category condition */
        $buildCategoryQuery = function ($categories, $operator = "OR") {
            $queryParts = [];
            foreach ($categories as $slug) {
                $category = Category::where('slug', $slug)->first();
                if ($category) {
                    $queryParts[] = "FIND_IN_SET('{$category->id}', categories)";
                }
            }
            return $queryParts ? "( " . implode(" {$operator} ", $queryParts) . " )" : "";
        };

        /** Diamonds rings special case */
        if (isset($requestData['category']) && count($requestData['category']) == 1 && in_array('diamonds-rings', $requestData['category'])) {
            $requestData['category'] = ['engagement-rings', 'eternity-rings', 'wedding-rings'];
        }

        /** Category filter */
        if (!empty($requestData['category'])) {
            $category_custom_query = $buildCategoryQuery($requestData['category'], "OR");
            $getAjaxResponses = false;
            $page = '';
        } elseif (!empty($queryString)) {
            $conditions = "AND";

            if (isset($queryString[1])) {
                if (isset($queryString[2]) && $queryString[1] == 'womens') {
                    $queryString[2] = $queryString[2] . '-womens';
                }
                $originalCount = count($queryString);
                $queryString = Category::whereIn('slug', $queryString)->orderBy('id')->pluck('slug')->toArray();
                if ($originalCount != count($queryString)) $is404 = true;
            }

            if (($queryString[0] ?? null) == 'diamond-engagement-rings') {
                $queryString = ['diamond-engagement-rings', 'engagement-rings'];
                $conditions = 'OR';
            }
            if (($queryString[0] ?? null) == 'diamonds-rings') {
                $queryString = ['engagement-rings', 'eternity-rings', 'wedding-rings', 'diamonds-rings'];
                $conditions = 'OR';
            }

            $category_custom_query = $buildCategoryQuery($queryString, $conditions);

            // Shape based categories
            $shapeArrayData = ['cushion', 'emerald', 'heart', 'marquise', 'oval', 'pear', 'princess', 'round'];
            if (isset($queryString[1]) && in_array($queryString[1], $shapeArrayData)) {
                $shapeCategories = Category::where('slug', 'like', '%' . $queryString[1] . '%')->pluck('id');
                foreach ($shapeCategories as $id) {
                    $category_custom_query .= " OR FIND_IN_SET($id, categories)";
                }
            }

            $categoryData = Category::where('slug', end($queryString))->first();
        } else {
            // Default categories
            $category_custom_query = "(FIND_IN_SET('8',categories)) OR (FIND_IN_SET('45',categories)) OR (FIND_IN_SET('47',categories))";
        }

        /** Additional category filters */
        foreach (['style-categories', 'ring-categories', 'jewellery-categories'] as $filterType) {
            if (!empty($requestData[$filterType])) {
                $extraQuery = $buildCategoryQuery($requestData[$filterType], "OR");
                if ($extraQuery) {
                    $category_custom_query .= " AND " . $extraQuery;
                }
            }
        }

        if ($is404 || empty($category_custom_query)) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => '/'];
        }

        /** Pagination setup */
        $pageNo = $requestData['page'] ?? 1;
        if (!empty($requestData['per_page_product'])) {
            $page = $requestData['per_page_product'];
        }

        /** Base Query */
        $query = Products::with([
            'getProductVariation:id,product_id,mined_diamond_rrp,mined_diamond,lab_grown_rrp,lab_grown',
            'getProductImages'
        ])
            ->select('id', 'title', 'slug', 'categories')
            ->where('status', 1)
            ->whereRaw(DB::raw($category_custom_query));

        /** Keyword filter */
        if (!empty($requestData['keyword'])) {
            $query->where('title', 'LIKE', "%" . $requestData['keyword'] . "%");
        }

        /** Metal type filter */
        if (!empty($requestData['metal_type']) && $requestData['metal_type'] != 'undefined') {
            $query->whereHas('getProductVariation.variDetails', function ($q) use ($requestData) {
                $q->whereIn('value', $requestData['metal_type']);
            });
        }

        /** Price filter */
        if (!empty($requestData['price-min']) && !empty($requestData['price-max'])) {
            $query->whereHas('getProductVariation', function ($q) use ($requestData) {
                $q->whereBetween('regular_price', [$requestData['price-min'][0], $requestData['price-max'][0]]);
            });
        }

        /** Shape filter */
        if (!empty($requestData['filter-by-shape'])) {
            $query->whereIn('diamond_shape', $requestData['filter-by-shape']);
        }

        /** Sorting */
        if (isset($requestData['sorting']) && in_array($requestData['sorting'], ['asc', 'desc'])) {
            $query->orderBy('title', $requestData['sorting']);
        } else {
            $query->orderBy('title', 'asc');
        }

        /** Paginate */
        $dynamicPath = request()->query('path');
        $getProductListFinal = $query->paginate($page, ['*'], 'page', $pageNo)->withPath($dynamicPath);

        if ($getProductListFinal->currentPage() > $getProductListFinal->lastPage()) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => $getProductListFinal->path()];
        }

        if (!$getProductListFinal->count()) {
            return ['status' => 404, 'page_status' => 1, 'redirect_url' => $getProductListFinal->path()];
        }


        /** Transform product data */
        $productSingleArray = [];
        foreach ($getProductListFinal as $key => $product) {
            $variations = collect($product->getProductVariation)->sortBy('lab_grown_rrp')->toArray();
            $record = reset($variations);

            $categories = explode(',', $product->categories);
            $diamondType = (array_intersect([50, 53, 54], $categories)) ? 'mined_diamond' : 'lab_grown';

            $productSingleArray[$key] = [
                'id' => $product->id,
                'title' => $product->title,
                'slug' => $product->slug,
                'categories' => $product->categories,
                'parent_cat' => $product->product_parent_category,
                'getProductImages' => $product->getProductImages,
                'diamond_type' => $diamondType,
                'get_product_variation' => $record,
            ];
        }

        /** Collection mapping */
        $modifiedCollection = collect($productSingleArray)->map(function ($item) {
            $explodeCategory = explode(',', $item['categories']);
            $variation = $item['get_product_variation'];
            $extraPrice = in_array('8', $explodeCategory) && !in_array('18', $explodeCategory) ? getLabPriceDefaultVariations() : 0;

            return [
                'id' => $item['id'],
                'title' => $item['title'],
                'slug' => $item['slug'],
                'categories' => $item['categories'],
                'parent_cat' => $item['parent_cat'],
                'getProductImages' => $item['getProductImages'],
                'mined_diamond_rrp' => $variation['mined_diamond_rrp'],
                'mined_diamond' => $variation['mined_diamond'],
                'lab_grown_rrp' => $variation['lab_grown_rrp'] + $extraPrice,
                'lab_grown' => $variation['lab_grown'] + $extraPrice,
                'discounted_lab_grown' => getFlatDiscountRanges(
                    ['shop_price' => $variation['lab_grown'] + $extraPrice],
                    $item['categories'],
                    'lab_grown'
                )['discounted_price'],
            ];
        });

        /** Price sorting */
        $sortProducts = function ($collection, $order = 'asc') {
            return $collection->sort(function ($a, $b) use ($order) {
                $catA = explode(',', $a['categories']);
                $catB = explode(',', $b['categories']);

                $fieldA = (array_intersect([50, 53, 54], $catA)) ? $a['mined_diamond'] : $a['lab_grown'];
                $fieldB = (array_intersect([50, 53, 54], $catB)) ? $b['mined_diamond'] : $b['lab_grown'];

                return $order === 'asc' ? $fieldA <=> $fieldB : $fieldB <=> $fieldA;
            })->values();
        };

        if (($requestData['sorting'] ?? null) == 'price-min') {
            $sortedCollection = $sortProducts($modifiedCollection, 'asc');
        } elseif (($requestData['sorting'] ?? null) == 'price-max') {
            $sortedCollection = $sortProducts($modifiedCollection, 'desc');
        } else {
            $sortedCollection = $modifiedCollection;
        }

        $sortedArray = $sortedCollection->map(fn($item) => (object) $item);

        $productItems = $getAjaxResponses ? null : view('front.ajax.productlistajax', compact('getProductListFinal', 'getAjaxResponses', 'sortedArray'))->render();

        return [
            'status' => 200,
            'productItems' => $productItems,
            'getProductListFinal' => $getProductListFinal,
            'sortedArray' => $sortedArray,
            'isNextPage' => $getProductListFinal->hasMorePages(),
            'nextPage' => $getProductListFinal->currentPage() + 1,
            'product_count' => $getProductListFinal->count(),
            'previous_url' => $getProductListFinal->previousPageUrl(),
            'next_url' => $getProductListFinal->nextPageUrl(),
            'categoryData' => $categoryData,
            'totalProductCount' => $getProductListFinal->total(),
        ];
    }
}

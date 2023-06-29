<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Products;
use Illuminate\Support\Arr;


class ProductController
{

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function filters(Request $request)
	{
		$category_one = $request->cat1;
		$category_two = $request->cat2;
		$category_three = $request->cat3;
		$subCategories = array();
		$subSubCategories = array();
		if ($category_three != '') {
			$checkSubSub = Category::where('slug', $category_three)->where('enable_filter', 1)->where('status', 1)->value('parent_id');

			if ($checkSubSub != '') {
				$subCatid = Category::where('slug', $category_two)->where('status', 1)->value('parent_id');
				$subCats = Category::where('parent_id', $subCatid)->where('status', 1)->orderBy('sort_order', 'ASC')->get();

				foreach ($subCats as $key => $subCat) {
					$subCategories[$key]['name'] = $subCat->name;
					$subCategories[$key]['url'] = '/product-category/' . $category_one . '/' . $subCat->slug;
					$subCategories[$key]['active_icon'] = $subCat->active_icon;
					$subCategories[$key]['hover_icon'] = $subCat->hover_icon;
					if ($category_two == $subCat->slug) {
						$subCategories[$key]['active_status'] = 'is-active';
					} else {
						$subCategories[$key]['active_status'] = '';
					}
				}
				$subSubCats = Category::where('parent_id', $checkSubSub)->where('status', 1)->orderBy('sort_order', 'ASC')->get();

				foreach ($subSubCats as $key => $subSubCat) {
					$subSubCategories[$key]['name'] = $subSubCat->name;
					$subSubCategories[$key]['url'] = '/product-category/' . $category_one . '/' . $category_two . '/' . $subSubCat->slug;
					$subSubCategories[$key]['active_icon'] = $subSubCat->active_icon;
					$subSubCategories[$key]['hover_icon'] = $subSubCat->hover_icon;
					if ($category_three == $subSubCat->slug) {
						$subSubCategories[$key]['active_status'] = 'is-active';
					} else {
						$subSubCategories[$key]['active_status'] = '';
					}
				}
			}
			return json_encode(array('parent_cat' => $category_one, 'subCats' => $subCategories, 'subSubCats' => $subSubCategories));
		}
		if ($category_two != '') {
			$checkSub = Category::where('slug', $category_two)->where('enable_filter', 1)->where('status', 1)->first();
			if ($checkSub) {
				$subCats = Category::where('parent_id', $checkSub['parent_id'])->where('status', 1)->orderBy('sort_order', 'ASC')->get();

				foreach ($subCats as $key => $subCat) {
					$subCategories[$key]['name'] = $subCat->name;
					$subCategories[$key]['url'] = '/product-category/' . $category_one . '/' . $subCat->slug;
					$subCategories[$key]['active_icon'] = $subCat->active_icon;
					$subCategories[$key]['hover_icon'] = $subCat->hover_icon;
					if ($checkSub['id'] == $subCat->id) {
						$subCategories[$key]['active_status'] = 'is-active';
					} else {
						$subCategories[$key]['active_status'] = '';
					}
				}
				$subSubCats = Category::where('parent_id', $checkSub['id'])->where('status', 1)->orderBy('sort_order', 'ASC')->get();

				foreach ($subSubCats as $key => $subSubCat) {
					$subSubCategories[$key]['name'] = $subSubCat->name;
					$subSubCategories[$key]['url'] = '/product-category/' . $category_one . '/' . $category_two . '/' . $subSubCat->slug;
					$subSubCategories[$key]['active_icon'] = $subSubCat->active_icon;
					$subSubCategories[$key]['hover_icon'] = $subSubCat->hover_icon;
					$subSubCategories[$key]['active_status'] = '';
				}
			}
			return json_encode(array('parent_cat' => $category_one, 'subCats' => $subCategories, 'subSubCats' => $subSubCategories));
		}
		if ($category_one != '') {
			$checkMain = Category::where('slug', $category_one)->where('parent_id', 0)->where('enable_filter', 1)->where('status', 1)->first();
			if ($checkMain) {
				$subCats = Category::where('parent_id', $checkMain['id'])->where('status', 1)->orderBy('sort_order', 'ASC')->get();

				foreach ($subCats as $key => $subCat) {
					$subCategories[$key]['name'] = $subCat->name;
					$subCategories[$key]['url'] = '/product-category/' . $category_one . '/' . $subCat->slug;
					$subCategories[$key]['active_icon'] = $subCat->active_icon;
					$subCategories[$key]['hover_icon'] = $subCat->hover_icon;
					$subCategories[$key]['active_status'] = '';
				}
			}
			return json_encode(array('parent_cat' => $category_one, 'subCats' => $subCategories, 'subSubCats' => ''));
		}
	}

	/**
	 * Search Products functionality
	 *
	 * @param Request $request
	 * @return void
	 */
	public function searchProducts(Request $request)
	{
		$getSearchedData = Products::with('getProductImages')->select("title", 'id', 'slug')
			->where("title", "LIKE", "%$request->name%")
			->get();
		return json_encode($getSearchedData);
	}
}

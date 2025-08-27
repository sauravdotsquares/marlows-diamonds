<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;
use App\Models\Menus;
use App\Models\Settings;
use Illuminate\Support\Facades\Cache;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();

        // View::composer('*', function($view)
        // {
        //     $navbars = $this->getNavMenu();
        //     //echo '<pre>'; print_r($navbars); die;
        //     $view->with('navbars', $navbars);

        // });

        // Deepak Sharma 25-08-2025
        View::composer('*', function ($view) {
            // Cache the navigation for 1 hour to avoid repeated database queries
            $navbars = Cache::remember('navigation_menus_EN', 3600, function () {
                return $this->getNavMenuOptimized();
            });

            $header_settings = Cache::remember('header_settings', 3600, function () {
                return Settings::pluck('option_value', 'option_name')->toArray();
            });
            // $view->with('navbars', $navbars);
            $view->with([
                'navbars' => $navbars,
                'header_settings' => $header_settings,
            ]);
        });
    }

    public function getNavMenu()
    {
        $getData =  Menus::where('parent', 0)->orderBy('id')->get();
        $getData = chnageMenuLanguage($getData, 'langMenu', ['title'], "EN");

        $menusArray = array();
        if (count($getData) > 0) {
            foreach ($getData as $key => $value) {


                $menusArray[$key]['text'] = $value['title'];
                $menusArray[$key]['href'] = $value['slug'];
                $menusArray[$key]['icon'] = $value['icon'];
                $menusArray[$key]['target'] = $value['target'];
                $menusArray[$key]['title'] = $value['tooltip'];
                $menusArray[$key]['class_level'] = 'level-0';

                $child = $this->getChildData($value['id'], 0);
                if (count($child) > 0) {
                    $menusArray[$key]['children'] = $child;
                }
            }
        }
        return $menusArray;
    }

    public function getChildData($parent_id, $level)
    {

        $getData =  Menus::where('parent', $parent_id)->orderBy('id')->get();
        $getData = chnageMenuLanguage($getData, 'langMenu', ['title'], "EN");
        $menusArray = array();
        $level++;
        foreach ($getData as $key => $value) {
            $menusArray[$key]['text'] = $value['title'];
            $menusArray[$key]['href'] = $value['slug'];
            $menusArray[$key]['icon'] = $value['icon'];
            $menusArray[$key]['target'] = $value['target'];
            $menusArray[$key]['title'] = $value['tooltip'];
            $menusArray[$key]['image_link'] = $value['image_link'];
            $menusArray[$key]['class_level'] = 'level-' . $level;
            $child = $this->getChildData($value['id'], $level);
            if (count($child) > 0) {
                $menusArray[$key]['children'] = $child;
            }
        }
        return $menusArray;
    }




    // Deepak Sharma 25-08-2025
    /**
     * OPTIMIZED VERSION - Eliminates all N+1 queries
     * Loads all menus in just 2 database queries instead of 1000+
     */
    public function getNavMenuOptimized()
    {
        // Load ALL menus with their language data in just 2 queries
        $allMenus = Menus::with(['langMenu' => function ($query) {
            $query->where('lang', 'EN');
        }])
            ->orderBy('parent')
            ->orderBy('id')
            ->get();

        // Apply language changes to all menus at once
        $allMenus = chnageMenuLanguage($allMenus, 'langMenu', ['title'], "EN");

        // Group menus by parent for efficient processing
        $menusByParent = $allMenus->groupBy('parent');

        // Get parent menus (parent = 0)
        $parentMenus = $menusByParent->get(0, collect());

        $menusArray = [];

        foreach ($parentMenus as $key => $menu) {
            $menusArray[$key] = [
                'text' => $menu->title,
                'href' => $menu->slug,
                'icon' => $menu->icon,
                'target' => $menu->target,
                'title' => $menu->tooltip,
                'class_level' => 'level-0'
            ];

            // Get children from already loaded data - no additional queries
            $children = $this->getChildDataOptimized($menu->id, $menusByParent, 0);
            if (!empty($children)) {
                $menusArray[$key]['children'] = $children;
            }
        }

        return $menusArray;
    }

    /**
     * OPTIMIZED getChildData - works with pre-loaded data
     * No database queries - processes from memory
     */
    private function getChildDataOptimized($parentId, $menusByParent, $level)
    {
        $menusArray = [];
        $level++;

        // Get children from already loaded and grouped data
        $childMenus = $menusByParent->get($parentId, collect());

        foreach ($childMenus as $key => $menu) {
            $menusArray[$key] = [
                'text' => $menu->title,
                'href' => $menu->slug,
                'icon' => $menu->icon,
                'target' => $menu->target,
                'title' => $menu->tooltip,
                'image_link' => $menu->image_link,
                'class_level' => 'level-' . $level
            ];

            // Recursively get nested children - still no database queries
            $children = $this->getChildDataOptimized($menu->id, $menusByParent, $level);
            if (!empty($children)) {
                $menusArray[$key]['children'] = $children;
            }
        }

        return $menusArray;
    }

    /**
     * Call this method when you add/edit/delete menus to clear the cache
     */
    public function clearMenuCache()
    {
        Cache::forget('navigation_menus_EN');
    }

    /**
     * Call this method when you add/edit/delete settings to clear the cache
     */
    public function clearSettingsCache()
    {
        Cache::forget('header_settings');
    }
}
 
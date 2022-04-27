<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use View;
use App\Models\Menus;

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
 
        View::composer('*', function($view)
        {
            $navbars = $this->getNavMenu();
            //echo '<pre>'; print_r($navbars); die;
            $view->with('navbars', $navbars);

        });
    }

    public function getNavMenu(){
        $getData =  Menus::where('parent',0)->orderBy('id')->get()->toArray();
        
        $menusArray = array();
        if(count($getData)>0){
            foreach ($getData as $key => $value) {

                
                $menusArray[$key]['text'] = $value['title']; 
                $menusArray[$key]['href'] = $value['slug'];
                $menusArray[$key]['icon'] = $value['icon'];
                $menusArray[$key]['target'] = $value['target'];
                $menusArray[$key]['title'] = $value['tooltip'];
                $menusArray[$key]['class_level'] = 'level-0';
                
                $child = $this->getChildData($value['id'], 0);
                if(count($child)>0){
                    $menusArray[$key]['children'] = $child;
                }
                
            }
        }
        return $menusArray;
    }

    public function getChildData($parent_id, $level){

        $getData =  Menus::where('parent',$parent_id)->orderBy('id')->get()->toArray();
        $menusArray = array();
        $level++;
        foreach ($getData as $key => $value) {
            $menusArray[$key]['text'] = $value['title']; 
            $menusArray[$key]['href'] = $value['slug'];
            $menusArray[$key]['icon'] = $value['icon'];
            $menusArray[$key]['target'] = $value['target'];
            $menusArray[$key]['title'] = $value['tooltip'];
            $menusArray[$key]['class_level'] = 'level-'.$level;
            $child = $this->getChildData($value['id'], $level);
            if(count($child)>0){
                $menusArray[$key]['children'] = $child;
            }
        }
        return $menusArray;
    }

    
}

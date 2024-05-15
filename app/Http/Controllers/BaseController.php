<?php

namespace App\Http\Controllers;

use App\Services\MenuService;

class BaseController extends Controller {

    protected $module;
    protected $pageTitle;
    protected $pageSubTitle;

    protected function getModuleName()
    {
        return $this->module;
    }
    
    protected function getRouteGroup()
    {
        return request()->getHost() == config('domain.admin') ? 'admin.' : 'app.';
    }

    protected function getBreadcrumb(){
        $currentUrl = ['home'];
        if($this->getModuleName())
            $currentUrl = [$this->getModuleName().'.index',$this->getRouteName()];
        
        $menu = MenuService::getMenuByUrl($currentUrl);
        if($menu){
            return ['breadcrumb' => [$menu->parent_name, $menu->name], 'title' => $menu->name,'currenturl' => $currentUrl];
        }else{
            return ['breadcrumb' => [__('Beranda')], 'title' => __('Beranda'),'currenturl' => $currentUrl];
        }
    }

    protected function serveView($data = [], $viewBlade = 'index', $return = false, $slice = true) {
        
        $breadcrumb = $this->getBreadcrumb();

        view()->share([
            'route_group' => $this->getRouteGroup(),
            'module' => $this->getModuleName(),
            'breadcrumb' => $breadcrumb['breadcrumb'],
            'pageTitle' => $breadcrumb['title'],
            'currentUrl' => $breadcrumb['currenturl'],
            'menus' => MenuService::generateMenu()
        ]);

        $view = view(implode('.', array_filter(['pages', $this->module, $viewBlade])), $data);

        return $view;
    }

}
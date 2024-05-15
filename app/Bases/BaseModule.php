<?php

namespace App\Bases;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

use App\Services\MenuService;

class BaseModule extends Controller
{
    public $module;
    public $pageTitle;
    public $pageSubTitle;

    protected function serveValidations($validations)
    {
        return response()->json([
            'code' => 422,
            'status' => 'fail',
            'message' => __('errors.422'),
            'data' => $validations
        ], 422);
    }

    protected function serveJSON($data, $code = 200, $status = 'success', $message = 'OK')
    {
        $output = $data;

        if (is_array($data)) {
            $code = isset($data['code']) ? $data['code'] : $code;

            $output = [
                'code'    => $code,
                'status'  => isset($data['status']) ? $data['status'] : $status,
                'message' => isset($data['message']) ? $data['message'] : $message,
                'data' => isset($data['data']) ? $data['data'] : NULL,
            ];

            // extend data table responses
            if (isset($data['draw'])) {
                $output['draw'] = $data['draw'];
            }
            if (isset($data['recordsTotal'])) {
                $output['recordsTotal'] = $data['recordsTotal'];
            }
            if (isset($data['recordsFiltered'])) {
                $output['recordsFiltered'] = $data['recordsFiltered'];
            }
        }

        return response()->json($output, $code);
    }

    protected function getMethodName()
    {
        return request()->route()->getActionMethod();
    }

    protected function getRouteName()
    {
        return request()->route()->getName();
    }

    protected function getModuleName()
    {
        return $this->module;
    }

    protected function getViewPath()
    {
        return $this->setPath(str_replace('.', DIRECTORY_SEPARATOR, $this->getModuleName()) . '::' . $this->getMethodName());
    }

    protected function getRouteGroup()
    {
        return request()->getHost() == config('domain.admin') ? 'admin.' : 'app.';
    }

    protected function getUserType()
    {
        return request()->getHost() == config('domain.admin') ? 1 : 2;
    }

    protected function serveView($data = [], $viewBlade = 'index', $currentUrl = null, $pageTitle = null)
    {
        $breadcrumb = $this->getBreadcrumb($currentUrl);

        view()->share([
            'route_group' => $this->getRouteGroup(),
            'module' => $this->getModuleName(),
            'breadcrumb' => !empty($breadcrumb['breadcrumb']) ? $breadcrumb['breadcrumb'] : '-',
            'pageTitle' => (empty($this->pageTitle)) ? (!empty($breadcrumb['title']) ? $breadcrumb['title'] : '-') : $this->pageTitle,
            'currentUrl' => !empty($breadcrumb['currenturl']) ? $breadcrumb['currenturl'] : [],
            'menus' => MenuService::generateMenu()
        ]);

        $view = view(implode('.', array_filter(['pages', $this->module, $viewBlade])), $data);

        return $view;
    }

    protected function setPath($path)
    {
        $re = '/
                  (?<=[a-z])
                  (?=[A-Z])
                | (?<=[A-Z])
                  (?=[A-Z][a-z])
                /x';
        $alias = preg_split($re, $path);
        return strtolower(implode('-', $alias));
    }

    protected function getBreadcrumb($currentUrl = null)
    {
        if ($currentUrl == null) {
            $currentUrl = ['home'];
            if ($this->getModuleName())
                $currentUrl = [$this->getModuleName() . '.index', $this->getRouteName()];
        }

        $menu = MenuService::getMenuByUrl($currentUrl);
        if ($menu) {
            return ['breadcrumb' => [$menu->parent_name, $menu->name], 'title' => $menu->name, 'currenturl' => $currentUrl];
        } else {
            return ['breadcrumb' => [__('Beranda')], 'title' => __('Beranda'), 'currenturl' => $currentUrl];
        }
    }
}

<?php

namespace Zoe\Http;
use Illuminate\Support\Facades\View;
class ControllerFront extends Controller
{
    public $_language = "";
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $language = config('zoe.language');
        $this->_language = isset($language[$this->app->site_language])?$language[$this->app->site_language]:['router'=>'','lang'=>config('zoe.default_lang')];
        $this->_language['code'] = $this->app->site_language;
    }

    public function render($view, $data = [], $layout = 'home', $key = "theme")
    {
        $request = request();

        $theme = config_get('theme', "active");

        $keyNameLayout = app()->getKey("_layout");

        $layout = isset($request->route()->defaults[$keyNameLayout]) ? $request->route()->defaults[$keyNameLayout] : $layout;

        $this->layout = "$theme::layouts.theme." . $theme . '.layout-' . $layout;

        $alias = app()->getConfig()['views']['alias'];
        $data = array_merge($this->data, $data);

        $keyName = app()->getKey("_view_alias");
        $_view_alias = isset($request->route()->defaults[$keyName]) ? $request->route()->defaults[$keyName] : "";

        if (isset($alias['frontend'][$_view_alias . ":" . $view])) {
            $keyView = $alias['frontend'][$_view_alias . ":" . $view];
        } else if (isset($_view_alias)) {
            $keyView = $_view_alias . '::controller.' . $view;
        } else {
            $keyView = $view;
        }
        View::share('_language', $this->_language['router']);
        return $this->_render($keyView, $data, $key);
    }
}

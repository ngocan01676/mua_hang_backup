<?php

namespace Admin\Http\Controllers;

use Admin\Http\Models\PageModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ConfigurationController extends \Zoe\Http\ControllerBackend
{
    public function getCrumb()
    {
        $this->breadcrumb(z_language("Configuration"), ('backend:configuration:list'));
        return $this;
    }

    public function action(Request $request)
    {
        $data = $request->all();
        if (isset($data['act'])) {
            if ($data['act'] == "save") {
                config_set($data['type'], $data['name'], ['data' => isset($data['data']) ? $data['data'] : []]);
                return response()->json($data);
            } else if ($data['act'] == "get") {
                return response()->json(config_get($data['type'], $data['name']));
            }
        }
    }

    public function ajax(Request $request)
    {
        $datas = $request->all();
        config_set("config", $datas['key'], ['data' => $datas['data']]);
    }

    public function list(Request $request, $type = null)
    {
        $configs = app()->getConfig()->configs;
        $this->data['lists'] = $configs['lists'];

        foreach ($this->data['lists'] as $key => $list) {
            if (isset($list['view'])) {
                if (is_array($list['view'])) {
                    foreach ($list['view'] as $k => $v) {
                        if (!isset($v['view'])) {
                            if (!isset($v['template']) || !isset($configs['templates'][$v['template']])) {
                                unset($this->data['lists'][$key]['view'][$k]);
                            } else {
                                $this->data['lists'][$key]['view'][$k] = array_merge($configs['templates'][$v['template']], $this->data['lists'][$key]['view'][$k]);
                            }
                        }
                    }
                }
            } else {
                if (!isset($list['template']) || !isset($configs['templates'][$list['template']])) {
                    unset($this->data['lists'][$key]);
                } else {
                    $this->data['lists'][$key] = array_merge($configs['templates'][$list['template']], $this->data['lists'][$key]);
                }
            }
        }
        if (isset($this->data['lists'][$type])) {
            $this->data['active'] = $type;
        } else {
            $this->data['active'] = 'system';
        }

        return $this->render('configuration.list');
    }

    public function register()
    {
        $configs = $this->app->getConfig()->registers;

        return $this->render('configuration.register', [
            'lists' => $configs,
        ]);
    }
}
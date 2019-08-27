<?php

namespace Admin\Http\Controllers;

use Admin\Http\Models\PageModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PluginController extends \Zoe\Http\ControllerBackend
{
    function getDirContents($dir, $filter = '', &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $key => $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                if (empty($filter) || preg_match($filter, $path)) $results[] = $path;
            } elseif ($value != "." && $value != "..") {
                $this->getDirContents($path, $filter, $results);
            }
        }
        return $results;
    }
    public function getCrumb()
    {
        $this->breadcrumb(z_language("Plugin"), route('backend:plugin:list'));
        return $this;
    }
    private function CreatePluginObject($plugin){
        $config_zoe = config('zoe');
        $relativePath = base_path($config_zoe['structure']['plugin']).DIRECTORY_SEPARATOR.$plugin;
        require_once $relativePath . '/Plugin.php';
        $class = '\\' . $plugin . '\\Plugin';
        return  new $class();
    }
    public function ajax(Request $request)
    {
        $data  = $request->all();
        $response = ["status"=>false];
        if(isset($data["act"])){
            switch ($data["act"]){
                case "install":
                    $plugin = $data['plugin'];
                    $object = $this->CreatePluginObject($data['plugin']);
                    $response['status'] = $object->install(function () use ($plugin){
                        $plugins = config_get('plugin',"lists");
                        $plugins[$plugin] = time();
                        config_set('plugin',"lists",['data'=>$plugins]);
                    });
                    break;
                case "uninstall":
                    $plugin = $data['plugin'];
                    $object = $this->CreatePluginObject($data['plugin']);
                    $response['status'] = $object->uninstall(function () use ($plugin){
                        $plugins = config_get('plugin',"lists");
                        unset( $plugins[$plugin] );
                        config_set('plugin',"lists",['data'=>$plugins]);
                    });
                    break;
                case "remove":

                    break;
            }
        }
        return response()->json($response);
    }
    public function list()
    {

        $config_zoe = config('zoe');
        $relativePath = base_path($config_zoe['structure']['plugin']);
        $lists_folder = scandir($relativePath);
        $array = [];

        foreach ($lists_folder as $plugin){
            if($plugin=="." || $plugin==".."){
                continue;
            }
            if(file_exists($relativePath.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR."Plugin.php")){
                $class = '\\' . $plugin . '\\Plugin';
                if(!class_exists($class)){
                    require_once $relativePath.DIRECTORY_SEPARATOR.$plugin.DIRECTORY_SEPARATOR."Plugin.php";
                }
                $array[$plugin] =[
                    "name"=>$class::$name?$class::$name:$plugin,
                    "description"=>$class::$description?$class::$description:$plugin,
                    "version"=>$class::$version,
                    "author"=>$class::$author,
                ];
            }
        }
        $this->data['lists'] = $array;
        $this->data['lists_install'] =  config_get('plugin',"lists");;
        return $this->render('plugin.list');
    }
}
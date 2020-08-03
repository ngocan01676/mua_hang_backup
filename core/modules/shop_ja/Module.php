<?php
namespace ModuleShopJa;
use Admin\Lib\Database;
use Zoe\Module as ZModule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use \Illuminate\Database\Query\Builder;
class Module extends ZModule
{
    public static $name = "Shop Ja";
    public static $description = "Shop Ja";
    public static $require = [];
    public static $dev = true;
    public function nestable($nestable, $parent_id = 0, $root = false)
    {
        $html = '<ol class="dd-list">';
        foreach ($nestable as $key => $item) {
            if (isset($this->data['category'][$item['id']])) {
                $html .= '<li class="dd-item dd3-item" data-id="' . $item['id'] . '" data-name="' . $this->data['category'][$item['id']]->name . '" parent_id="' . $parent_id . '">';
                $html .= '<div class="dd-handle dd3-handle"></div>
		        <div class="dd3-content">' . $this->data['category'][$item['id']]->name . '</div>';
                $html .= "<div class='dd3-tool'><button class='btn btn-primary btn-xs edit'>" . "<i class='fa fa-edit'></i>" . "</button><button class='btn  btn-default btn-xs delete'>" . "<i class='fa fa-remove'></i>" . "</button></div>";
                unset($this->data['category'][$item['id']]);
                if (isset($item["children"])) {
                    $html .= $this->nestable($item["children"], $item['id']);
                }
                $html .= '</li>';
            }
        }
        if ($root) {
            foreach ($this->data['category'] as $k => $item) {
                $html .= '<li class="dd-item dd3-item" data-id="' . $item->id . '" data-name="' . $item->name . '" parent_id="0">';
                $html .= '<div class="dd-handle dd3-handle"></div>
		        <div class="dd3-content">' . $item->name . '</div>';
                $html .= "<div class='dd3-tool'><button class='btn btn-primary btn-xs edit'>" . "<i class='fa fa-edit'></i>" . "</button><button class='btn  btn-default btn-xs delete'>" . "<i class='fa fa-remove'></i>" . "</button></div>";
                $html .= '</li>';
            }
        }
        $html .= '</ol>';
        return $html;
    }
    public function Init()
    {
        $this->path = __DIR__;
        \Actions::add_action("shop-ja:city:category:nestable", function ($nestable, $parent_id = 0, $root = false){
            return $this->nestable($nestable,$parent_id,$root);
        });
    }

    public function import($step = true, $settings = [], $datas = [])
    {

    }


    public function uninstall($func = null, $posts = [])
    {

    }

    public function export($step = true, $settings = [], $datas = [])
    {

    }
}
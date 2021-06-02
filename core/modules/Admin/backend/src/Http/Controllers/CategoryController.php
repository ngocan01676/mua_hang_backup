<?php

namespace Admin\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Admin\Http\Models\Categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
class CategoryController extends \Zoe\Http\ControllerBackend
{
    public function getCrumb()
    {
        $this->breadcrumb("Category List", ('backend:category:list'));
        return $this;
    }
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->data['language'] = config('zoe.language');
        $this->data['configs'] = config_get("config", "system");
        $this->data['current_language'] =
            isset($this->data['configs']['core']['site_language']) ?
                $this->data['configs']['core']['site_language'] :
                config('zoe.default_lang');
    }

    public function ajax(Request $request)
    {
        $post = $request->all();

        if (isset($post['act'])) {
            if ($post['act'] == "info") {
                $data = $post['data'];

                $prefix_lang = isset($data['_lang'])?$data['_lang']:"";

                $filter = [

                ];
                $langs_key = isset($data['_keys'])?json_decode(base64_decode($data['_keys']),true):["name","description"];
                foreach ($langs_key as $key=>$_filter){
                    if(is_numeric($key)){
                        $filter[$_filter] = "required";
                    }else{
                        $filter[$key] ="required";
                    }
                }
                if(
                    isset($this->data['configs']['core']['language']['multiple']) &&
                    !empty($prefix_lang)
                ){
                    $newFilter = [];
                    foreach ($this->data['language'] as $lang => $_language) {
                        if(
                            isset($this->data['configs']['core']['language']['lists']) &&
                            (is_string($this->data['configs']['core']['language']['lists']) &&
                                $this->data['configs']['core']['language']['lists'] == $_language['lang']||
                                is_array($this->data['configs']['core']['language']['lists']) &&  in_array($_language['lang'],$this->data['configs']['core']['language']['lists'])) ){
                            foreach ($filter as $col=>$value){


                                if(isset($langs_key[$col]['default'])){
                                    if($lang == $langs_key[$col]['default']){
                                        $newFilter[$col.'_'.$lang] = $value;
                                    }
                                }else{
                                    $newFilter[$col.'_'.$lang] = $value;
                                }
                            }
                        }

                    }
                    $filter = $newFilter;
                }

                if(!in_array("name",$langs_key)){
                    $filter["name"] = "required";
                }
                if(!in_array("description",$langs_key)){
                    $filter["description"] = "required";
                }

                $validator = Validator::make($data, $filter);
                $rules = [];
                if ($validator->passes()) {
                    $oke = true;
                    if (isset($data["data"])) {
                        $type = $data['type'];
                        if (isset(app()->getConfig()['modules']['admin.category'][$type]['rules'])) {
                            $rules = (app()->getConfig()['modules']['admin.category'][$type]['rules']);
                            $validator = Validator::make($data['data'], $rules);
                            $oke = $validator->passes();
                        }
                    }
                    if ($oke) {
                        $create = false;
                        if (isset($data) && isset($data['id']) && $data['id'] != 0) {
                            $category = Categories::find($data['id']);
                        } else {
                            $category = new Categories();
                            $create = true;
                        }

                        $category->name = isset($data['name'])?$data['name']:"";

                        $slug = empty($category->name)?"": Str::slug($category->name, '-');
                        $category->slug = $slug;

                        $category->lang_prefix = $prefix_lang;

                        $category->parent_id = 0;
                        $category->router_enabled = isset($data['router_enabled'])?$data['router_enabled']:2;
                        $category->router_name = isset($data['router_name'])?$data['router_name']:"";

                        $category->description = isset($data['description'])?$data['description']:"";
                        $category->status = $data['status'];
                        $category->type = isset($data['type'])?$data['type']:0;
                        $category->image = isset($data['image'])?$data['image']:"";
                        $category->icon = "";
                        $category->featured = $data['featured'];
                        $category->order = 0;
                        $category->is_default = 0;
                        $category->data = isset($data["data"]) && is_array($data["data"]) ? serialize($data["data"]) : serialize([]);

                        DB::beginTransaction();
                        try {
                            $category->save();
                            if(!empty($prefix_lang)){
                                foreach ($this->data['language'] as $lang => $_language) {
                                    $data_save = [];
                                    foreach ($langs_key as $k=>$val){
                                        $conf = [];
                                        if(is_numeric($k)){
                                            $col = $val;
                                            $data_save[$col] = isset($data[$col.'_' . $lang])?$data[$col.'_' . $lang]:"";
                                        }else{
                                            $col = $k;
                                            if(isset($val['slug'])){
                                                $data_save[$col] = isset($data[$val['slug'].'_' . $lang])?Str::slug($data[$val['slug'].'_' . $lang], '-','ja'):"";
                                            }else{
                                                $data_save[$col] = isset($data[$col.'_' . $lang])?$data[$col.'_' . $lang]:"";
                                            }
                                            $conf = $val;
                                        }
                                        if(empty($data_save[$col]) && isset($conf['default'])){
                                            $data_save[$col] = isset($data[$col.'_' . $conf['default']])?$data[$col.'_' . $conf['default']]:"";
                                        }
                                    }
                                    $category->table_translation_model($prefix_lang)->updateOrInsert(
                                        [
                                            '_id' => $category->id,
                                            'lang_code' => $lang
                                        ],
                                        $data_save
                                    );

                                }
                            }
                            $request->session()->flash('success', $create == "create"?z_language('Faq is added successfully'):z_language('Faq is updated successfully'));
                            DB::commit();
                            return response()->json(['success' => $data,'status'=>true]);
                        } catch (\Exception $ex) {
                            $validator->getMessageBag()->add('id', $ex->getMessage()." ".$ex->getLine());
                            DB::rollBack();
                        }
                        return response()->json(['error' => $validator->errors(), 'data_rules' => $rules]);
                    } else {
                        return response()->json(['error' => $validator->errors(), 'data_rules' => $rules]);
                    }
                } else {
                    return response()->json(['error' => $validator->errors(), 'data_rules' => $rules]);
                }
            } else if ($post['act'] == "position") {

                $data = $post['data'];
                DB::beginTransaction();
                try {
                    if (isset($data['id']) && $data['id'] != 0) {
                        $category = Categories::find($data['id']);
                        $category->delete();
                    }
                    config_set("category", $data['type'], ['data' => $data['pos']]);
                    DB::commit();
                    return response()->json(['error' => 0, 'data' => $data]);
                } catch (\Exception $ex) {
                    DB::rollBack();
                    return response()->json(['error' => 1]);
                }

            } else if ($post['act'] == "edit") {
                $data = $post['data'];
                $category = Categories::find($data['id']);

                if (isset($this->data['configs']['core']['language']['multiple']) && !empty($category->lang_prefix)) {
                    $trans = $category->table_translation_model($category->lang_prefix)->where(['_id' => $data['id']])->get();
                    $table = $category->table_translation_columns($category->lang_prefix);

                    foreach ($trans as $tran) {
                        foreach ($table as $val){
                            $category->offsetSet($val."_" . $tran->lang_code, $tran->{$val});
                        }
                      //  $category->offsetSet("name_" . $tran->lang_code, $tran->name);
                       // $category->offsetSet("slug_" . $tran->lang_code, $tran->slug);
                      //  $category->offsetSet("description_" . $tran->lang_code, $tran->description);
                    }
                }

                if(!empty($category['data']) && ($category['data'] == 'b:0;' || @unserialize($category['data']) !== false)){
                    $category['data'] = unserialize($category['data']);
                }else{
                    $category['data'] = [];
                }

                return response()->json(['data' => $category]);
            } else if ($post['act'] == "nestable") {
                $data = $post['data'];
                $type = $data['type'];
                $this->data['category'] = get_category_type($type);
                $class_nestable = base64_decode($data['nestable']);
                if(!empty($class_nestable) && class_exists($class_nestable)){
                    $obj_nestable = new $class_nestable($this->data['category']);
                    echo $obj_nestable->nestable(config_get("category", $type), 0, true,$data['id']);
                }else{
                    echo $this->nestable(config_get("category", $type), 0, true,$data['id']);
                }
            }
        }
    }
    private $html = "";
    private function nestable($nestable, $parent_id = 0, $root = false)
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
                $oke = true;
                foreach ($nestable as $key=>$value){
                    if($item->id == $value['id']){
                        $oke = false;break;
                    }
                }
                if($oke){
                    $html .= '<li class="dd-item dd3-item" data-id="' . $item->id . '" data-name="' . $item->name . '" parent_id="0">';
                    $html .= '<div class="dd-handle dd3-handle"></div>
                    <div class="dd3-content">' . $item->name . '</div>';
                    $html .= "<div class='dd3-tool'><button class='btn btn-primary btn-xs edit'>" . "<i class='fa fa-edit'></i>" . "</button><button class='btn  btn-default btn-xs delete'>" . "<i class='fa fa-remove'></i>" . "</button></div>";
                    $html .= '</li>';
                }
            }
        }
        $html .= '</ol>';
        return $html;
    }
    public function show(Request $request)
    {
        $type = isset($request->route()->defaults['type']) ? $request->route()->defaults['type'] : 'category';
        $view_render = isset($request->route()->defaults['view_render']) ? $request->route()->defaults['view_render'] : 'category.show';
        $is_slug = isset($request->route()->defaults['slug']) ? $request->route()->defaults['slug'] : true;
        $class_nestable = isset($request->route()->defaults['nestable'])? ($request->route()->defaults['nestable']) : "Admin\Lib\CategoryNestable";


        $views = "";
        if (isset(app()->getConfig()['modules']['admin.category'][$type]['views'])) {
            if (isset(app()->getConfig()['modules']['admin.category'][$type]['views'])) {
                $views = (app()->getConfig()['modules']['admin.category'][$type]['views']);
            }
            if (isset(app()->getConfig()['modules']['admin.category'][$type]['breadcrumb'])) {
                $breadcrumb = (app()->getConfig()['modules']['admin.category'][$type]['breadcrumb']);
                $this->breadcrumb($breadcrumb['name'], ($breadcrumb['route']));
            }
        } else {
            $this->getCrumb();
        }
        $this->breadcrumb("Category", ('backend:category:list'));
        $this->data['category'] = get_category_type($type);
        $obj_nestable = null;
        if(!empty($class_nestable) && class_exists($class_nestable)){
            $obj_nestable = new $class_nestable($this->data['category']);
        }

        $this->data['nestable'] = $obj_nestable->nestable(config_get("category", $type), 0, true);




        $this->data['type'] = $type;
        $this->data['is_slug'] = $is_slug;
        $this->data['views'] = $views;
        $this->data['class_nestable'] = base64_encode($class_nestable);
        return $this->render($view_render,[],'backend');
    }

    public function list()
    {
        return $this->render('category.list');
    }
}

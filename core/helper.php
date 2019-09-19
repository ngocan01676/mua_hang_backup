<?php

use Illuminate\Support\Facades\Cache;


use Illuminate\Support\Facades\DB;


function ZoeExtension($file)
{
    $tmp = explode('.', $file);
    $file_extension = end($tmp);
    return $file_extension;
}

function ZoeImageResize($url, $resize_config = [])
{
    try {
        if (isset($resize_config['resize'])) {
            $filename = basename(public_path($url));
            $arr_img = [];
            $imgs = [

            ];
            if (isset($resize_config['platforms'])) {
                $platforms = is_array($resize_config['platforms']) ? $resize_config['platforms'] : [$resize_config['platforms']];
                foreach ($platforms as $platform) {
                    if (isset($resize_config[$platform])) {
                        $size = (int)$resize_config[$platform];
                        if ($size > 0) {
                            $imgs[$platform] = $size;
                        }
                    }
                }
            }

            list($width_old, $height_old) = getimagesize(public_path($url));
            $arrImg = [];
            if (isset($resize_config['action'])) {
                if ($resize_config['action'] == 'lazy') {
                    if (isset($resize_config['pc']) && (int)$resize_config['pc'] < 100) {
                        $imgs['pc'] = $resize_config['pc'];
                    } else {
                        $arr_img['data-src'] = $url;
                    }
                    $arr_img['lazy-load'] = 'true';
                    $arr_img['width'] = $width_old . 'px';
                    $arr_img['height'] = $height_old . 'px';
                } else if ($resize_config['action'] == 'php') {
                    $arrImg['src'] = $url;
                } else {
                    $arr_img['src'] = $url;
                }
            } else {
                $arr_img['src'] = $url;
            }

            foreach ($imgs as $name => $v) {
                $_v = ($v / 100);
                $w = $width_old * $_v;
                $theme = config_get('theme', "active");
                $path = storage_path('app/public' . '/assets/' . $theme);
                if (!File::exists($path)) {
                    File::makeDirectory($path);
                }
                $path =  $path .'/'. $name;
                if (!File::exists($path)) {
                    File::makeDirectory($path);
                }
                $pathFull = $path . '/' . $filename;

                if (!file_exists($pathFull)) {
                    $img = Image::make(public_path($url))->resize($w, null, function ($constraint) {
                        $constraint->aspectRatio();
                    });
                    $img->save($pathFull);
                }
                if (isset($resize_config['action'])) {
                    if ($resize_config['action'] == 'lazy') {
                        $arr_img[$name == 'pc' ? 'data-src' : 'data-w' . $name] = '/storage/assets/'. $theme.'/'. $name . '/' . $filename;
                    } else {
                        $arrImg[$name == 'pc' ? 'data-src' : 'data-w' . $name] = '/storage/assets/'. $theme.'/'. $name . '/' . $filename;
                    }
                }
            }
            if (count($arrImg) > 1) {
                if (defined('build')) {
                    $arr_img['blade'] = '@src_img_platform(' . json_encode($arrImg) . ')';
                } else {
                    $arr_img['src'] = ZoeSrcImgMobile($arrImg, false);
                }
            } else {
                $arr_img['src'] = $url;
            }
            //$arr_img['log'] = json_encode($arr_img);
          //  $arr_img['arrImg'] = json_encode($arrImg);
            return $arr_img;
        }
        return ["src" => $url];
    } catch (\Exception $ex) {
        return ["src" => $url, 'error' => $ex->getMessage()];
    }
}

function ConvertBase64($url)
{
    if (!empty($url)) {
        if (substr($url, 0, 9) == '/storage/') {
            $path = storage_path('/app/public/' . substr($url, 9));
        } else {
            $path = public_path($url);
        }
        $imageData = base64_encode(file_get_contents($path));
        return 'data: ' . mime_content_type($path) . ';base64,' . $imageData;
    }
    return '';
}

function ZoeImageConvertBase64($expr)
{
    $url = "";
    if (is_array($expr) && isset($expr['data-src'])) {
        $url = $expr['data-src'];
    } else if (substr($expr, 0, 1) == '{') {
        $expr = json_decode($expr, true);
        if (isset($expr['data-src'])) {
            $url = $expr['data-src'];
        }
    } else {
        $url = $expr;
    }
    if (!empty($url)) {
        $src = ' data-src="' . $url . '" src="' . ConvertBase64($url) . '" ';
        return $src;
    }
    return '';
}

function ZoeSrcImgMobile($arr, $isSrc = true)
{
    $_platform = 'pc';
    $src = "";
    $detect = app()->getAgent();
    if ($detect->isTablet()) {
        $_platform = 'tablet';
    } else if ($detect->isMobile()) {
        $_platform = 'mobile';
    }
    if ($_platform === 'mobile') {
        if (isset($arr['data-wmobile'])) {
            $src = $arr['data-wmobile'];
        } else {
            $_platform = 'tablet';
        }
    }
    if ($_platform === 'tablet') {
        if (isset($arr['data-wtablet'])) {
            $src = $arr['data-wtablet'];
        } else {
            $_platform = 'pc';
        }
    }
    if ($_platform === 'pc') {
        if (isset($arr['data-src'])) {
            $src = $arr['data-src'];
        } else {
            $src = $arr['src'];
        }
    }
    return $isSrc ? ' src=' . $src . ' php=true ' : $src;
}

function ZoeSrcImg($src, $attr = [])
{
    if (is_array($src)) {
        $html = '';
        if (!isset($src['src']) && !isset($src['blade'])) {
            $src['src'] = asset('assets/image-blank.png');
        }
        foreach ($src as $k => $_src) {
            if ($k == 'blade') {
                $html .= ' ' . $_src . ' ';
            } else {
                $html .= ' ' . $k . ' =' . $_src . ' ';
            }
        }
        return $html;
    }
    return 'src=' . $src;
}

function ZoeAssetImg($url, $option = [])
{
    return defined('build') ?
        isset($option['image']['base64']) && $option['image']['base64'] == 1 ? '@Zoe_ImageBase64(' . $url . ')' :
            is_array($url) ? ZoeSrcImg($url) : ZoeSrcImg(asset($url)) : (is_array($url) ? ZoeSrcImg($url) : ZoeSrcImg(asset($url)));
}

function ZoeImage($url, $option = [], $attr = [])
{
    global $is_base64;

    $resize_config = isset($option['image']) ? $option['image'] : [];
    if ($is_base64 == 3) {
        return defined('build') ? '@Zoe_ImageBase64(' . json_encode(ZoeImageResize($url, $resize_config)) . ')' : ZoeImageConvertBase64(ZoeImageResize($url, $resize_config));
    } else if ($is_base64 == 1 || isset($resize_config['base64'])) {
        return defined('build') ? '@Zoe_ImageBase64(' . $url . ')' : ZoeImageConvertBase64($url);
    } else if (isset($option['image']['resize']) && $option['image']['resize'] == 1) {
        return ZoeAssetImg(ZoeImageResize($url, $resize_config), $option, $attr);
    } else {
        return ZoeAssetImg($url, $option, $attr);
    }
}


function ZoeLang($text)
{
    global $zlang;
    $text = e(preg_replace('/\s+/', ' ', str_replace("\r\n", "", $text)));
    return defined('build') ? '@zlang("' . $text . '")' : $zlang($text);
}

function layout_data($id)
{
    $rs = DB::table('layout')->where('id', $id)->first();
    if ($rs) {
        return unserialize(base64_decode($rs->data));
    }
    return [];
}

function layout_get($id)
{
    $rs = DB::table('layout')->where('id', $id)->first();
    if ($rs) {
        $rs->data = unserialize(base64_decode($rs->data));
    }
    return $rs;
}

function sort_type($sort, $col = "", $parameter = [])
{

    if (isset($parameter['order_by']['col'])) {
        if ($parameter['order_by']['col'] != $col) {
            return '<i data-col="' . $col . '" class="fa fa-sort"></i>';
        }
        if (isset($parameter['order_by']['type'])) {
            // fa-sort
            if ($sort == "alpha") {
                // fa-sort-alpha-desc  fa-sort-alpha-asc
                return '<i data-col="' . $col . '" class="fa ' . ($parameter['order_by']['type'] == "asc" ? "fa-sort-alpha-asc\" data-type=\"asc\"" : "fa-sort-alpha-desc\" data-type='desc'") . '></i>';
            } else if ($sort == "amount") {
                //fa-sort-amount-desc fa-sort-amount-asc
                return '<i  data-col="' . $col . '" class="fa ' . ($parameter['order_by']['type'] == "asc" ? "fa-sort-amount-asc\" data-type='asc'" : "fa-sort-amount-desc\" data-type='desc'") . '></i>';
            } else if ($sort == "numeric") {
                // fa-sort-numeric-desc  fa-sort-numeric-asc
                return '<i data-col="' . $col . '" class="fa ' . ($parameter['order_by']['type'] == "asc" ? "fa-sort-numeric-asc\" data-type='asc'" : "fa-sort-numeric-desc\" data-type='desc'") . '></i>';
            } else {
                //fa-sort-desc  fa-sort-asc
                return '<i data-col="' . $col . '" class="fa ' . ($parameter['order_by']['type'] == "asc" ? "fa-sort-asc\" data-type='asc'" : "fa-sort-desc\" data-type='desc'") . '></i>';

            }
        }
        return '<i class="fa fa-sort"></i>';
    }
    return '';
}

function list_label($val, $columns, $option, $model = null)
{
    $label = $val;
    if (isset($columns['type'])) {
        if ($columns['type'] == "image") {
            $attrs = "";
            if (isset($option['config']['config']['type']['image'])) {
                foreach ($option['config']['config']['type']['image'] as $name_attr => $value_attr) {
                    $attrs .= " " . $name_attr . " ='" . $value_attr . "'";
                }
            }
            return '<img src="' . asset($label) . '" ' . $attrs . '>';
        } else if ($columns['type'] == "status") {
            if (isset($option['config']['config']['type'][$columns['type']])) {
                $data = $option['config']['config']['type'][$columns['type']];

                if (isset($data['label'][$label])) {
                    $label = z_language($data['label'][$label]);
                }
//                dump($data);
                if (isset($data['type']['name'])) {
                    if ($data['type']['name'] == 'label') {
                        if (isset($data['type']['color'][$val])) {
                            $label = '<span class="label label-' . $data['type']['color'][$val] . '">' . $label . '</span>';
                        } else {
                            $label = '<span class="label label-default">' . $label . '</span>';
                        }
                    }
                }
                $label = '<div class="text-center">' . $label . '</div>';
            }
        }
        if (isset($columns['align'])) {
            $label = '<div class="text-' . $columns['align'] . '">' . $label . '</div>';
        }
    }
    return '<div class="label-text">' . $label . '</div>';
}

function list_text_aligin($columns)
{
    if (!isset($columns['text-aligin'])) {
        return "";
    }
    if ($columns['text-aligin'] == "center") {
        return "text-center";
    } else if ($columns['text-aligin'] == "right") {
        return "text-right";
    }
    return "";
}

function config_get($type, $name, $default = [])
{
    $rs = DB::table('config')->where(['type' => $type, 'name' => $name])->first();
    if (!$rs) return $default;
    $rs = unserialize($rs->data);
    return isset($rs['data']) ? $rs['data'] : $default;
}

function config_set($type, $name, $data)
{
    return DB::table('config')->updateOrInsert(
        [
            'name' => $name,
            'type' => $type
        ],
        ['data' => serialize($data)]);
}

function config_delete($type, $name)
{
    return DB::table('config')->where(
        ['name' => $name, 'type' => $type]
    )->delete();
}

function get_category_type($type)
{
    $rs = DB::table('categories')->where(['type' => $type])->get();
    $arr = [];
    foreach ($rs as $k => $v) {
        $arr[$v->id] = $v;
    }
    return $arr;
}

function get_menu_type($type)
{
    $rs = DB::table('menu')->where(['type' => $type])->get();
    $arr = [];
    foreach ($rs as $k => $v) {
        $arr[$v->id] = $v;
    }
    return $arr;
}

function show_categories_nestable($nestable, $category, $parent_id = 0, $char = '')
{
    $html = "";
    foreach ($nestable as $key => $item) {
        $html .= '<option ' . (isset($category[$item["id"]]) ? "selected " : "") . 'value="' . $item["id"] . '">';
        $html .= $char . $item['name'];
        $html .= '</option>';
        if (isset($item["children"])) {
            $html .= show_categories_nestable($item["children"], $category, $item['id'], $char . '|---');
        }
    }
    return $html;
}

function show_categories_ul_li($categories, $parent_id = 0, $char = '')
{
    // BƯỚC 2.1: LẤY DANH SÁCH CATE CON
    $cate_child = array();
    foreach ($categories as $key => $item) {
        // Nếu là chuyên mục con thì hiển thị
        if ($item->parent_id == $parent_id) {
            $cate_child[] = $item;
//            unset($categories[$key]);
        }
    }

    // BƯỚC 2.2: HIỂN THỊ DANH SÁCH CHUYÊN MỤC CON NẾU CÓ
    if ($cate_child) {
        if ($parent_id == 0)
            echo '<ol class="dd-list">';
        else
            echo '<ol class="dd-list">';
        foreach ($cate_child as $key => $item) {
            // Hiển thị tiêu đề chuyên mục
            echo '<li class="dd-item dd3-item" data-id="' . $item->id . '">';
            echo '<div class="dd-handle dd3-handle"></div>
		        <div class="dd3-content">' . $item->name . '</div>';
            echo "<div class='dd3-tool'><button class='btn btn-primary btn-xs edit'>" . "<i class='fa fa-edit'></i>" . "</button><button class='btn  btn-default btn-xs delete'>" . "<i class='fa fa-remove'></i>" . "</button></div>";
            show_categories_ul_li($categories, $item->id, $char . '|---');
            echo '</li>';
        }
        echo '</ol>';
    }
}

function views_alise($view, $key = "backend")
{
    $alias = app()->getConfig()['views']['alias'];
    if (isset($alias[$key][$view])) {
        return $alias[$key][$view];
    } else {
        return $view;
    }
}

function gen_uuid()
{
    return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
        // 32 bits for "time_low"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff),

        // 16 bits for "time_mid"
        mt_rand(0, 0xffff),

        // 16 bits for "time_hi_and_version",
        // four most significant bits holds version number 4
        mt_rand(0, 0x0fff) | 0x4000,

        // 16 bits, 8 bits for "clk_seq_hi_res",
        // 8 bits for "clk_seq_low",
        // two most significant bits holds zero and one for variant DCE1.1
        mt_rand(0, 0x3fff) | 0x8000,

        // 48 bits for "node"
        mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
    );
}

function z_language($key, $par = [], $__env = null)
{
    if (is_array($par)) {
        $_lang_name_ = app()->getLocale();
        $_langs_ = app()->getLanguage();

        $html = isset($_langs_[$_lang_name_][$key]) && !empty($_langs_[$_lang_name_][$key]) ? $_langs_[$_lang_name_][$key] : $key;
        if (is_array($par)) {
            foreach ($par as $k => $v) {
                $html = str_replace(":" . $k, $v, $html);
            }
        }

        return $html;
    }
    return $key;
}

function get_config_component($id, $config = [])
{
    return [];
}

function run_component($function, $config = [])
{
    return call_user_func($function, [$config]);
}

function create_router_group()
{
    return [];
}

function create_router_item()
{
    return [];
}

function component_create($module, $main = [], $cfg = [], $opt = [], $type = "component")
{
    $stg = array(
        'system' => "",
        'module' => $module,
        'type' => $type,
    );
    if (!isset($cfg['public'])) {
        $cfg['public'] = "0";
    }
    if (!isset($cfg['dynamic'])) {
        $cfg['dynamic'] = "0";
    }

    if (!isset($cfg['render'])) {
        $cfg['render'] = "blade";
    }

    if (!isset($cfg['status'])) {
        $cfg['status'] = "1";
    }
    if (!isset($cfg['view'])) {
        $cfg['view'] = "";
    }
    if (is_null($module)) {
        unset($stg["module"]);
    }
    return [
        "main" => $main,
        "option" => array(
            'cfg' => $cfg,
            'stg' => array(
                'system' => "",
                'module' => $module,
                'type' => $type,
            ),
            'opt' => $opt
        )
    ];
}

function component_config($_opt_, $data, $config, $views, $cfg = [], $compiler = [])
{
    return [
        "data" => $data,
        "configs" => $config,
        "views" => $views,
        "cfg" => $cfg,
        "compiler" => $compiler
    ];
}

function component_config_data($data)
{
    return $data;
}

function component_config_configs($data)
{

    if (!isset($data['temp'])) {
        $data['temp'] = ["template" => "template", "data" => ["count" => 3]];
    }
    return $data;
}

function component_config_views($data)
{
    return $data;
}

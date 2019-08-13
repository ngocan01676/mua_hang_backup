<?php

namespace Admin\Lib;
class LayoutBlade
{
    public static $datas;
    public static $widget = [];
    public static $html = "";
    public static $langs = [];

    private static function attrClass(& $attrs, $class)
    {
        $attrs['class'] = empty($attrs['class'])
            ? $class
            : "{$attrs['class']} $class";
    }

    private static function attrId(& $attrs, $id)
    {
        $attrs['id'] = empty($attrs['id'])
            ? $id
            : "{$attrs['id']} $id";
    }

    private static function attrStyle(&$attrs, $style)
    {
        $attrs['style'] = empty($attrs['style'])
            ? $style
            : "{$attrs['style']} $style";
    }

    private static function rendAttr($atts)
    {
        $html = '';
        foreach ($atts as $att => $rows) {
            $html .= ' ' . $att . '="' . $rows . '"';
        }
        return $html;
    }

    private static function girds($content, $option)
    {
        if (isset($option['cfg']['compiler']['grid'])) {
            $grid = [];
            if (is_string($option['cfg']['compiler']['grid'])) {
                $grid[] = $option['cfg']['compiler']['grid'];
            } else if (is_array($option['cfg']['compiler']['grid'])) {
                $grid = $option['cfg']['compiler']['grid'];
            }
            foreach ($grid as $val) {
                if (method_exists(static::$GridHelper, "layout_" . $val)) {
                    $content = call_user_func_array(array(static::$GridHelper, "layout_" . $val), array($content, $option));
                }
            }
        }
        return $content;
    }

    public static $ViewHelper = null;
    public static $GridHelper = null;
    public static $TagHelper = null;

    public static function plugin($option, $index = '')
    {
        if (isset($option['lang'])) {
            foreach ($option['lang'] as $langname => $langs) {
                foreach ($langs as $lang) {
                    if (!empty($lang['val'])) {
                        static::$langs[$langname][$lang['key']] = $lang['val'];
                    }
                }
            }
        }

        $content = "";
        if (isset($option["stg"]['blade'])) {
            if (method_exists(static::$ViewHelper, $option["stg"]['blade'])) {
                $content = call_user_func_array(array(static::$ViewHelper, $option["stg"]['blade']), array($option));
            }
        } else if (isset($option['cfg']['view'])) {
            if ($option['cfg']['view'] == "dynamic") {
                if (method_exists(static::$ViewHelper, "commposer")) {
                    $content = call_user_func_array(array(static::$ViewHelper, "commposer"), array($option));
                }
            } else if ($option['cfg']['view']) {
                $content = "@includeIf('" . $option['cfg']['view'] . "', " . (var_export(isset($option['opt']) ? ["data" => $option['opt']] : ["data" => []], true)) . ")";
            } else {
                $content = "<div>@ZoeWidget(" . (var_export($option, true)) . ")</div>\n";
            }
//            if (isset($option['stg']['blade']) && method_exists(static::$ViewHelper, $option['stg']['blade'])) {
//                $content = call_user_func_array(array(static::$ViewHelper, $option['stg']['blade']), array($option));
//            } else {
//                if (isset($option['cfg']['view'])) {
//                    $content = "@includeIf('" . $option['cfg']['view'] . "', " . (var_export(isset($option['opt']) ? $option['opt'] : [], true)) . ")";
//                } else {
//                    $content = "<div>@ZoeWidget(" . (var_export($option, true)) . ")</div>\n";
//                }
//            }
        } else {
            $content = "<div>@ZoeWidget(" . (var_export($option, true)) . ")</div>\n";
        }
        return static::girds($content, $option);
    }

    public static function partial($option, $index = '')
    {
        $content = "@includeIf('zoe::" . static::FilenamePartial($option['stg']['id']) . "', [])";
        return static::girds($content, $option);
    }

    public static function rows($row, $layout = true, $lever = 0)
    {
        $html = "";

        if ($row['option']) {
            $option = $row['option'];
            if (isset($option['stg']['col'])) {
                foreach ($option['stg']['col'] as $key => $gird) {
                    $block = false;
                    if (isset($option['cfg']['tag'])) {
                        if (isset(static::$TagHelper[$option['cfg']['tag']])) {
                            $html .= call_user_func_array(static::$TagHelper[$option['cfg']['tag']], array("start", $option));
                        } else if ($option['cfg']['tag'] == "block") {
                            $block = true;
                            $class = "";
                            $id = "";
                            if (isset($option['opt']['attr']['class']) && !empty($option['opt']['attr']['class'])) {
                                $class = " class='" . $option['opt']['attr']['class'] . "'";
                            }
                            if (isset($option['opt']['attr']['id']) && !empty($option['opt']['attr']['id'])) {
                                $id = " id='" . $option['opt']['attr']['id'] . "'";
                            }
                            $html .= "<div" . $class . $id . ">";
                        }
                    }
                    if (isset($row['view'][$key]) && is_array($row['view'][$key])) {
                        foreach ($row['view'][$key] as $_k => $_row) {
                            if (isset($_row[0]['row'])) {
                                $html .= static::rows($_row[0]['row'], $layout, $lever++);
                            } else if (isset(static::$widget[$_row])) {
                                if (static::$widget[$_row]['stg']['type'] == "component") {
                                    $html .= static::plugin(static::$widget[$_row], $lever . '-' . $key . '-' . $_k);
                                } else if (static::$widget[$_row]['stg']['type'] == "partial") {
                                    $html .= static::partial(static::$widget[$_row], $lever . '-' . $key . '-' . $_k);
                                }
                            }
                        }
                    }
                    if (isset($option['cfg']['tag']) && isset(static::$TagHelper[$option['cfg']['tag']])) {
                        $html .= call_user_func_array(static::$TagHelper[$option['cfg']['tag']], array("end", $option));
                    } else if ($block) {
                        $html .= "</div>\n";
                    }
                }
            }
        }
        return static::girds($html, $option);
    }

    static function InitBuild()
    {
        return '
            @function(zoe_lang($par))
                @php 
                    $key =  $par[0];
                    $_lang_name_ = app()->getLocale();
                    $_langs_ = ' . (var_export(static::$langs, true)) . '; 
                    $html = isset($_langs_[$_lang_name_][$key])?$_langs_[$_lang_name_][$key]:$key;
                    if(isset($par[1])){
                        foreach($par[1] as $k=>$v){
                            $html  = str_replace(":".$k,$v,$html);
                        } 
                    }
                    return $html;
                @endphp
            @endfunction';
    }

    static function FilenamePartial($id)
    {
        return 'layout-partial-' . $id . '-' . md5($id);
    }

    static function FilenameLayout($id)
    {
        return 'layout-' . ($id);
    }

    static function InitFuc()
    {
        return static::$ViewHelper->GetFunc() . static::$GridHelper->GetFunc();
    }

    static function render($data, $id, $type = "layout")
    {
        static::$datas = isset($data['data']) ? $data['data'] : [];
        static::$widget = isset($data['widget']) ? $data['widget'] : [];
        $lever = 0;
        if (isset(static::$datas[0])) {
            foreach (static::$datas as $rows) {
                if (isset($rows['row'])) {
                    static::$html .= static::rows($rows['row'], true, $lever);
                }
            }
        }
        $file = new \Illuminate\Filesystem\Filesystem();
        static::$html = static::InitFuc() . static::$html;
        if ($type == "layout") {

            $template = $file->get(base_path('core/modules/admin/backend/resource/stubs/layout.stubs'));
            $file->put(base_path('bootstrap/zoe/views/' . static::FilenameLayout($id) . ".blade.php"), str_replace_first("{{CONTENT}}", static::InitBuild() . static::$html, $template));
        } else {
            $file->put(base_path('bootstrap/zoe/views/' . static::FilenamePartial($id) . ".blade.php"), static::$html);
        }
    }

}
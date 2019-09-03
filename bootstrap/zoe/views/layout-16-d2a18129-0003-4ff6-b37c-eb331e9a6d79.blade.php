<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  
            @function(zoe_lang($par))
                @php 
                    $key =  $par[0];
                    $_lang_name_ = app()->getLocale();
                    $_langs_ = array (
); 
                    $html = isset($_langs_[$_lang_name_][$key])?$_langs_[$_lang_name_][$key]:$key;
                    if(isset($par[1])){
                        foreach($par[1] as $k=>$v){
                            $html  = str_replace(":".$k,$v,$html);
                        } 
                    }
                    return $html;
                @endphp
            @endfunction

@z_include(core/plugins/Comment/resource/views/component/comment/main.php)


        @function(func_1567502505_2110_2738 ($option))
            @php $data = $option; @endphp
@includeIf('theme::component.thumbnail-image.views.list', ['data'=>$data])
        @endfunction

        @function(func_1567502505_9791_3036 ($option))
            @php $data = run_component('Comments\main',$option) @endphp
@includeIf('pluginComment::component.comment.views.list-new', ['data'=>$data])
        @endfunction
<div class="container"><div class="row justify-content-center"><div class="col-md-8"><div class='py-4'>
@func_1567502505_2110_2738(array (
  'data' => 
  array (
    'lists' => 
    array (
      0 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      1 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      2 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      3 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
    ),
  ),
))

</div></div></div></div>
@func_1567502505_9791_3036(array (
  'data' => 
  array (
    'lists' => 
    array (
      0 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      1 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      2 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
      3 => 
      array (
        'name' => '',
        'image' => '',
        'link' => '',
      ),
    ),
  ),
))


</body>
</html>

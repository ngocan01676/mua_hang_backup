@if(isset($item))
    {!! Form::model($item, ['method' => 'POST','route' => ['backend:miss_terry:room:store'],'id'=>'form_store']) !!}
    {!! Form::hidden('id') !!}
@else
    {!! Form::open(['method' => 'POST','route' => ['backend:miss_terry:room:store'],'id'=>'form_store']) !!}
@endif
<style>
    .mce-notification-inner{
        display: none !important;
    }
</style>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<div class="col-md-9">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div><br/>
    @endif
    <div class="nav-tabs-custom">
        @if(isset($configs['post']['language']['multiple']))
            <ul class="nav nav-tabs" {{$current_language}}>
                <li class="active"><a href="#tab_info" data-toggle="tab">{!! z_language("Thông tin chung") !!}</a></li>
                <li><a href="#tab_media" data-toggle="tab">{!! z_language("Thư viện ảnh") !!}</a></li>
                @foreach($language as $lang=>$_language)
                    @if(isset($configs['post']['language']['lists']) &&(is_string($configs['post']['language']['lists']) && $configs['post']['language']['lists'] == $_language['lang']|| is_array($configs['post']['language']['lists']) && in_array($_language['lang'],$configs['post']['language']['lists'])))
                        <li {{$lang}}><a href="#tab_{{$lang}}"
                                         data-toggle="tab"><span
                                        class="flag-icon flag-icon-{{$_language['flag']}}"></span></a></li>
                    @endif
                @endforeach
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_info">
                    <div style="display: none">
                        <textarea id="Data" class="form-control" placeholder="Cấu hình" cols="5" rows="5" name="config">{!! $item?$item->config:'{}' !!}</textarea>
                    </div>
                    <table class="table table-borderless">
                        <tbody>
                        <tr>
                            <td>
                                {!! Form::label('time', z_language("Thời gian"), ['class' => 'time']) !!}
                                @if($current_language == $lang)
                                    {!! Form::number('time',null, ['class' => 'form-control','placeholder'=>z_language("Thời gian")]) !!}
                                @else
                                    {!! Form::number('time',null, ['class' => 'form-control','placeholder'=>z_language("Thời gian")]) !!}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {!! Form::label('difficult', z_language("Độ khó"), ['class' => 'time']) !!}

                                {!! Form::radio('difficult', '5' , true) !!} 5
                                {!! Form::radio('difficult', '4',false) !!} 4
                                {!! Form::radio('difficult', '3',false) !!} 3
                                {!! Form::radio('difficult', '2',false) !!} 2
                                {!! Form::radio('difficult', '1',false) !!} 1
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class="table table-bordered wrap_rows" id="wrap">
                                    <thead>
                                       <tr>
                                           <th class="text-center">{!! z_language("STT") !!}</th>
                                           <th class="text-center">{!! z_language("Số người") !!}</th>
                                           <th class="text-center">{!! z_language("T2-T6 trước 17:00") !!}</th>
                                           <th class="text-center">{!! z_language("T6-CN sau 17:00") !!}</th>
                                           <th class="text-center">{!! z_language("Giá ngày lễ") !!}</th>
                                       </tr>

                                       <tr class="template" data-index="@INDEX@">
                                           <td class="text-center">0</td>
                                           <td><input data-key="user" data-name="data[@INDEX@].user" class="data form-control text" placeholder="{!! z_language('Số người') !!}" type="text"></td>
                                           <td><input data-key="price1" data-name="data[@INDEX@].price1" class="data form-control value" placeholder="{!! z_language("T2-T6 trước 17:00") !!}" type="text"></td>
                                           <td><input data-key="price2" data-name="data[@INDEX@].price2" class="data form-control value" placeholder="{!! z_language("T6-CN sau 17:00") !!}" type="text"></td>
                                           <td><input data-key="price3" data-name="data[@INDEX@].price3" class="data form-control value" placeholder="{!! z_language("Giá ngày lễ") !!}" type="text"></td>
                                           <td class="text-center">
                                               <button type="button" data-id="#wrap" class="add btn btn-success btn-xs" onclick="add(this)">Thêm</button>
                                               <button style="display: none" type="button" data-id="#wrap" class="remove btn btn-danger btn-xs" onclick="remove(this)">Xóa</button>
                                           </td>
                                       </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="tab-pane clearfix" id="tab_media">
                    <span><button type="button" class="btn btn-sm pull-right" onclick="openElfinderMedia(this)">Add</button> </span>
                </div>
                @foreach($language as $lang=>$_language)
                    @if(isset($configs['post']['language']['lists']) && (is_string($configs['post']['language']['lists']) && $configs['post']['language']['lists'] == $_language['lang']|| is_array($configs['post']['language']['lists']) &&  in_array($_language['lang'],$configs['post']['language']['lists'])) )
                        <div class="tab-pane" id="tab_{{$lang}}">

                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        {!! Form::label('id_title', z_language('Tiêu đề'), ['class' => 'title']) !!}
                                        @if($current_language == $lang)
                                            {!! Form::text('title',null, ['class' => 'form-control','placeholder'=>'Title']) !!}
                                        @else
                                            {!! Form::text('title_'.$lang.'',null, ['class' => 'form-control','placeholder'=>'Title']) !!}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('id_description', z_language('Mô tả'), ['class' => 'description']) !!}
                                        @if($current_language == $lang)
                                            {!! Form::textarea('description',null, ['class' => 'form-control','placeholder'=>'Description','cols'=>5,'rows'=>5]) !!}
                                        @else
                                            {!! Form::textarea('description_'.$lang.'',null, ['class' => 'form-control','placeholder'=>'Description','cols'=>5,'rows'=>5]) !!}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label($lang.'_id_description', z_language('Quy định của phòng chơi'), ['class' => 'description']) !!}
                                        @if($current_language == $lang)
                                            {!! Form::textarea('content', null, ['class' => 'form-control my-editor']) !!}
                                        @else
                                            {!! Form::textarea('content_'.$lang.'', null, ['class' => 'form-control my-editor']) !!}
                                        @endif
                                        <script>
                                            var editor_config = {

                                                    path_absolute: "/",
                                                    height: "500",
                                                    width: "calc(100% - 2px)",
                                                    selector: "textarea.my-editor",
                                                    plugins: [
                                                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                                                        "insertdatetime media nonbreaking save table contextmenu directionality",
                                                        "emoticons template paste textcolor colorpicker textpattern"
                                                    ],
                                                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                                                    relative_urls: false,
                                                    file_browser_callback: function (field_name, url, type, win) {

                                                        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                                        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                                                        var cmsURL = '{{route('backend:elfinder:tinymce4')}}' + '?target=' + 'l1_' + btoa('room/content').replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '.').replace(/\.+$/, '');
                                                        console.log(cmsURL);
                                                        if (type === 'image') {
                                                            cmsURL = cmsURL + "&type=Images";
                                                        } else {
                                                            cmsURL = cmsURL + "&type=Files";
                                                        }
                                                        tinyMCE.activeEditor.windowManager.open({
                                                            file: cmsURL,
                                                            title: 'Filemanager',
                                                            width: x * 0.8,
                                                            height: y * 0.8,
                                                            resizable: "yes",
                                                            close_previous: "no",
                                                        }, {
                                                            oninsert: function (file, fm) {
                                                                var url, reg, info;
                                                                console.log(file);
                                                                win.document.getElementById(field_name).value = file.url;
                                                                // URL normalization
                                                                url = fm.convAbsUrl(file.url);
                                                                console.log(url);
                                                            }
                                                        });

                                                    }
                                                }
                                            ;

                                            tinymce.init(editor_config);
                                        </script>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
            <table class="table table-borderless">
                <tbody>
                <tr>
                    <td>
                        {!! Form::label('id_title', 'Name', ['class' => 'title']) !!}
                        {!! Form::text('title',null, ['class' => 'form-control','placeholder'=>'Tiêu đề']) !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('id_description', 'Description', ['class' => 'description']) !!}
                        {!! Form::textarea('description',null, ['class' => 'form-control','placeholder'=>'Mô tả','cols'=>5,'rows'=>5]) !!}
                    </td>
                </tr>
                <tr>
                    <td>
                        {!! Form::label('id_description', 'Description', ['class' => 'description']) !!}
                        {!! Form::textarea('content', null, ['class' => 'form-control my-editor']) !!}
                        <script>
                            var editor_config = {
                                height: "100%",
                                width: "calc(100% - 2px)",
                                    path_absolute: "/",
                                    selector: "textarea.my-editor",
                                    plugins: [
                                        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                                        "searchreplace wordcount visualblocks visualchars code fullscreen",
                                        "insertdatetime media nonbreaking save table contextmenu directionality",
                                        "emoticons template paste textcolor colorpicker textpattern"
                                    ],
                                    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
                                    relative_urls: false,
                                    file_browser_callback: function (field_name, url, type, win) {

                                        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
                                        var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;

                                        var cmsURL = '{{route('backend:elfinder:tinymce4')}}' + '?field_name=' + field_name;
                                        console.log(cmsURL);
                                        if (type === 'image') {
                                            cmsURL = cmsURL + "&type=Images";
                                        } else {
                                            cmsURL = cmsURL + "&type=Files";
                                        }
                                        tinyMCE.activeEditor.windowManager.open({
                                            file: cmsURL,
                                            title: 'Filemanager',
                                            width: x * 0.8,
                                            height: y * 0.8,
                                            resizable: "yes",
                                            close_previous: "no",
                                        }, {
                                            oninsert: function (file, fm) {
                                                var url, reg, info;
                                                console.log(file);
                                                win.document.getElementById(field_name).value = file.url;
                                                // URL normalization
                                                url = fm.convAbsUrl(file.url);
                                                console.log(url);
                                            }
                                        });

                                    }
                                }
                            ;

                            tinymce.init(editor_config);
                        </script>
                    </td>
                </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
<div class="col-md-3">

    <div class="box box box-zoe">
        <div class="box-body">
            {!! Form::label('id_status', 'Status', ['class' => 'status']) !!}
            {!! Form::radio('status', '1' , true) !!} Yes
            {!! Form::radio('status', '0',false) !!} No
        </div>
    </div>

    <div class="box box box-zoe">
        <div class="box-body">
            {!! Form::label('id_status', 'Image', ['class' => 'status']) !!}
            <div class="image-wrapper">
                <div class="preview-image-wrapper">
                    <img src="{{$item?$item->image:'http://placehold.jp/150x150.png'}}" alt="" height="150px">
                    <a onclick="btn_remove_image(this)" class="btn_remove_image" title="Remove image">
                        <i class="fa fa-times"></i>
                    </a>
                    {!! Form::hidden('image',null, []) !!}
                </div>
                <a href="javascript:void(0)" onclick="openElfinder(this);" class="btn_gallery">
                    Choose image
                </a>

            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
<div class="modal fade" id="elfinderShow">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body">
                <div id="elfinder"></div>
            </div>
        </div>
    </div>
</div>
@section('extra-script')
    <script type="text/javascript">

    </script>
@endsection
@push('links')
    <link rel="stylesheet" href="{{asset("module/admin/assets/flag/css/flag-icon.min.css")}}">
@endpush
@push('scripts')
    <style>
        .preview-image-wrapper {
            position: relative;
        }

        .btn_remove_image {
            position: absolute;
            top: 10px;
            width: 50px;
            font-size: 15px;
        }
        .SelectEdit{
            background: green;
        }
        .Error .form-control{
            border: 1px solid red;
        }
        .template .remove{
            display: none  !important;
        }
        .Element .remove{
            display: block  !important;
        }
        .template .add{
            display: block  !important;
        }
        .Element .add{
            display: none !important;
        }
    </style>

    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/elfinder/css/theme.css') }}">
    <script src="{{ asset('module/admin/assets/elfinder/js/elfinder.min.js') }}"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/boostrap-multi-select/css/bootstrap-multiselect.css') }}">
    <script src="{{ asset('module/admin/assets/boostrap-multi-select/js/bootstrap-multiselect.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/tagging/css/amsify.suggestags.css') }}">
    <script src="{{ asset('module/admin/assets/tagging/js/jquery.amsify.suggestags.js') }}"></script>
    <script type="text/javascript">

        String.prototype.trimRight = function(charlist) {
            if (charlist === undefined)
                charlist = "\s";
            return this.replace(new RegExp("[" + charlist + "]+$"), "");
        };
        function renderData(data) {
            if(data.length > 0){
                let _data = JSON.parse(data);
                $(".wrap_rows").find('tbody').empty();
                let index = 0;
                $("#wrap").mask("{!! z_language('Waiting...') !!}");
                    for(let k in _data){
                        template($("#wrap"),_data[k],index++);
                    }
                $("#wrap").unmask();
            }
        }
        (function () {
            renderData($("#Data").val() );
        })();
        function beforeSave(parent) {
            let trs = parent.find('tr.Element');
            let count = 1;
            trs.each(function () {
                if(!$(this).hasClass('template')){
                    let elements = $(this).find('.data');
                    let _index = "";
                    elements.each(function (index) {
                        if(this.hasAttribute('data-index')){
                            _index+= $(this).val().trim()+"_";
                        }
                    });
                    if(_index.length === 0)
                        _index = count++;
                    else
                        _index = _index.trimRight("_");
                    $(this).attr('data-index',_index);
                    $(this).find("td").first().empty().html(_index);
                    elements.each(function () {
                        $(this).attr('name',$(this).attr('data-name').replace("@INDEX@",_index))
                    });
                }
            });
        }
        function template(tbody,vals,index) {
            let template = tbody.find('.template').clone();
            template.removeClass('template');
            template.find("td").first().empty().html(index+1);
            template.addClass('Element');

            template.find('.data').each(function () {
                $(this).removeAttr('name');
                let key = $(this).attr('data-key');
                let tagName = ($(this).prop("tagName").toLowerCase());
                if(tagName === 'select'){
                    if(vals.hasOwnProperty(key)){
                        $(this).find('option').each(function () {
                            if($(this).attr('value') === vals[key])
                                $(this).attr('selected','selected');
                        });
                    }

                }else if(tagName === 'input'){
                    if(vals.hasOwnProperty(key)){
                        $(this).val(vals[key]);
                    }
                }
            });

            tbody.append(template);

            beforeSave(tbody);

            tbody.find('.template').find('.data').each(function () {
                $(this).removeAttr('name');

                if($(this).hasClass('uint')){
                    // $(this).find('option').first().attr('selected',true);
                }else{
                    $(this).val('');
                }
            });
        }
        function remove(self) {
            let _this = $(self);
            let parent = _this.parent().parent();
            let wrap = parent.closest(".wrap_rows").find('tbody');
            parent.remove();
            beforeSave(wrap);
        }
        function add(self){
            let _this = $(self);
            let parent = _this.closest(_this.attr('data-id'));
            let tbody = parent.find('tbody');
            let trs = tbody.find("tr");
            console.log(parent);
            trs.each(function () {
                $(this).removeClass('Error');
            });
            let tr = parent.find('.template');
            let vals = {

            };
            tr.removeClass('Error');
            tr.find('input').each(function () {
                vals[$(this).attr('data-key')] = $(this).val();
            });
            let oke = true;
            for(let i in vals){
                if(vals[i].toString().length === 0){
                    oke = false;
                    break;
                }
            }
            if(oke){
                template(parent,vals,trs.length);
            }else{
                tr.addClass('Error');
            }
        }

        function Save(){
            $(".wrap_rows tbody").each(function () {
                beforeSave($(this));
            });
            let form_store = $("#form_store");

            let data = form_store.zoe_inputs('get');

            if(!data.hasOwnProperty('data') || data.data.length === 0){
                $("#Data").html('[]');
            }else{
                $("#Data").html(JSON.stringify(data.data));
            }
           document.getElementById('form_store').submit();
        }
        $(document).ready(function () {

            // $('#category-select').multiselect();
            var tags = [];
            $('input[name="tag"]').amsifySuggestags({
                type: 'bootstrap',
                suggestions: ['Black', 'White', 'Red', 'Blue', 'Green', 'Orange'],
                afterAdd: function (value) {
                    console.log()
                },
                afterRemove: function (value) {
                    // after remove
                },

            });

        });

        function btn_remove_image(self) {
            console.log($(self).closest('.preview-image-wrapper').find('img').attr('src', 'http://placehold.jp/150x150.png'));
        }

        function openElfinderMedia(self) {
            $('#elfinderShow').modal();
            var path = 'media';
            var volumeId = 'l1_';
           

            $('#elfinder').elfinder({
                debug: false,
                width: '100%',
                height: '80%',
                cssAutoLoad: false,
                startPathHash : 'l1_' + btoa('room/media').replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '.').replace(/\.+$/, ''),
                customData: {
                    _token: '{{ csrf_token() }}',
                   
                },
                useBrowserHistory : false,
                commandsOptions: {
                    getfile: {
                        onlyPath: true,
                        folders: false,
                        multiple: false,
                        oncomplete: 'destroy'
                    },
                    ui: 'uploadbutton'
                },
                mimeDetect: 'internal',
                onlyMimes: [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif'
                ],
                ui: ['toolbar', 'path', 'stat'],
                rememberLastDir: false,
                url: '{{ route("backend:elfinder:showConnector") }}',
                soundPath: '{{ asset('module/admin/assets/elfinder/sounds') }}',
                getFileCallback: function (file) {
                    console.log(file);
                    $('#elfinderShow').modal('hide');
                },
                resizable: false,
                uiOptions: {
                    toolbar: [
                        ['home', 'up'],
                        ['upload'],
                        ['quicklook'],
                    ],
                    tree: {
                        openRootOnLoad: true,
                        syncTree: true
                    },
                    navbar: {
                        minWidth: 150,
                        maxWidth: 500
                    },
                    cwd: {
                        oldSchool: false
                    }
                }
            }).elfinder('instance');
        }
        function openElfinder(self) {
            $('#elfinderShow').modal();
       
            $('#elfinder').elfinder({
                debug: false,
                width: '100%',
                height: '80%',
                cssAutoLoad: false,
                useBrowserHistory : false,
                startPathHash : 'l1_' + btoa('room/icon').replace(/\+/g, '-').replace(/\//g, '_').replace(/=/g, '.').replace(/\.+$/, ''),
                
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                commandsOptions: {
                    getfile: {
                        onlyPath: true,
                        folders: false,
                        multiple: false,
                        oncomplete: 'destroy'
                    },
                    ui: 'uploadbutton'
                },
                mimeDetect: 'internal',
                onlyMimes: [
                    'image/jpeg',
                    'image/jpg',
                    'image/png',
                    'image/gif'
                ],
                ui: ['toolbar', 'path', 'stat'],
                rememberLastDir: false,
                url: '{{ route("backend:elfinder:showConnector") }}?target=l1_cm9vbS9pY29u&cmd=open',
                soundPath: '{{ asset('module/admin/assets/elfinder/sounds') }}',
                getFileCallback: function (file) {
                    console.log(file);
                    var preview_image_wrapper = $(".preview-image-wrapper");
                    preview_image_wrapper.show();
                    console.log(file.path);
                    preview_image_wrapper.find("img").attr('src', "/"+file.path);
                    preview_image_wrapper.find("[name='image']").val(file.path);
                    $('#elfinderShow').modal('hide');
                },
                resizable: false,
                uiOptions: {
                    toolbar: [
                        ['home', 'up'],
                        ['upload'],
                        ['quicklook'],
                    ],
                    tree: {
                        openRootOnLoad: true,
                        syncTree: true
                    },
                    navbar: {
                        minWidth: 150,
                        maxWidth: 500
                    },
                    cwd: {
                        oldSchool: false
                    }
                }
            }).elfinder('instance');
        }
    </script>
@endpush
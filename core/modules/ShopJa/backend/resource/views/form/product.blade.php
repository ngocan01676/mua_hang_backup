@if(isset($model))
    {!! Form::model($model, ['method' => 'POST','route' => ['backend:shop_ja:product:store'],'id'=>'form_store','class'=>'submit','enctype'=>"multipart/form-data"]) !!}
    {!! Form::hidden('id') !!}
@else
    {!! Form::open(['method' => 'POST','route' => ['backend:shop_ja:product:store'],'id'=>'form_store','class'=>'submit','enctype'=>"multipart/form-data"]) !!}
@endif
<script src="{!! config('zoe.tiny') !!}"></script>
<div class="col-md-12">
    <div class="box box box-zoe">
        <div class="box-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div><br/>
            @endif
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div><br/>
                @endif
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"> {!! @z_language(["Thông tin sản phẩm"]) !!} </a></li>

                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        {!! Form::label('code', z_language('Mã sản phẩm'), ['class' => 'v']) !!}
                                        {!! Form::text('code',null, ['class' => 'form-control','placeholder'=>z_language('Mã sản phẩm')]) !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        {!! Form::label('id_title', z_language('Tên sản phẩm'), ['class' => 'title']) !!}
                                        {!! Form::text('title',null, ['class' => 'form-control','placeholder'=>z_language('Tên sản phẩm')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('Image', z_language('Ảnh sản phẩm'), ['class' => 'image']) !!}
                                        <input type="file" name="image_up" accept="image/*" onchange="loadFile(event)">
                                        <div class="image-wrapper">
                                            <div class="preview-image-wrapper">
                                                <img id="preview-image-2" class="preview-image" style="width: 100px;height: 150px" src="{!! isset($model)?$model->image:"http://placehold.jp/100x150.png" !!}" alt="">
                                            </div>
                                            <br>
                                        {{--<input data-preview="#preview-image" data-input="#file_input" onfocus="openElfinder(this)" name="image" type="text" id="file_input" class="form-control itemVal" value="{!! isset($model)?$model->image:"" !!}"><br>--}}
                                        </div>
                                        {!! Form::hidden('image') !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @if(!empty($GalleryComposer))
                                            <div class="tab-pane clearfix" id="tab_media">
                                                {!! $GalleryComposer !!}
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('category_id',z_language('Công ty'), ['class' => 'Category']) !!} *
                                        {!! Form::CategoriesNestableOne($nestables,[Form::value('category_id')=>""],"category_id") !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('id_description', z_language('Mô tả'), ['class' => 'description']) !!}
                                        {!! Form::textarea('description',null, ['class' => 'form-control','placeholder'=>z_language('Mô tả'),'cols'=>5,'rows'=>5]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('id_body', z_language('Nội dung'), ['class' => 'body']) !!}
                                        {!! Form::textarea('body',null, ['class' => 'form-control my-editor','placeholder'=>z_language('Nội dung'),'cols'=>5,'rows'=>5]) !!}
                                        <script>
                                            var editor_config = {
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
                                                    height:"500",
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
                                <tr>
                                    <td>
                                        {!! Form::label('price', z_language('Giá nhập'), ['class' => 'price']) !!}
                                        {!! Form::text('price',null, ['class' => 'form-control','placeholder'=>z_language('Giá nhập')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('price_buy', z_language('Giá bán'), ['class' => 'price_buy']) !!}
                                        {!! Form::text('price_buy',null, ['class' => 'form-control','placeholder'=>z_language('Giá bán')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('order_index', z_language('Vị trí'), ['class' => 'order_index']) !!}
                                        {!! Form::text('order_index',null, ['class' => 'form-control','placeholder'=>z_language('Vị trí')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('value', z_language('Cân nặng'), ['class' => 'value']) !!}
                                        {!! Form::text('value',null, ['class' => 'form-control','placeholder'=>z_language('Cân nặng')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('count', z_language('Số lượng'), ['class' => 'count']) !!}
                                        {!! Form::text('count',null, ['class' => 'form-control','placeholder'=>z_language('Số lượng')]) !!}
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('unit', z_language('Đơn vị'), ['class' => 'unit']) !!} &nbsp;
                                        @php
                                            $lists_uint = config('shop_ja.configs.lists_uint');
                                        @endphp
                                        @foreach( $lists_uint as $key=>$value)
                                            {!! Form::radio('unit', $key , true) !!} {!! $value !!}
                                        @endforeach

                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('id_type_excel', 'Kiểu xuất Excel', ['class' => 'type_excel']) !!} &nbsp;
                                        {!! Form::radio('type_excel', '1' , true) !!} 1 Dòng
                                        {!! Form::radio('type_excel', '0',false) !!}  N Dòng
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        {!! Form::label('id_status', 'Status', ['class' => 'status']) !!} &nbsp;
                                        {!! Form::radio('status', '1' , true) !!} Yes
                                        {!! Form::radio('status', '0',false) !!} No
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>

                    </div>
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
    <link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/themes/smoothness/jquery-ui.css"/>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/elfinder/css/elfinder.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('module/admin/assets/elfinder/css/theme.css') }}">
    <script src="{{ asset('module/admin/assets/elfinder/js/elfinder.min.js') }}"></script>
    <script !src="">
        var loadFile = function(event) {
            var output = document.getElementById('preview-image-2');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
        function openElfinder(self) {
            $('#elfinderShow').modal();
            $('#elfinder').elfinder({
                debug: false,
                width: '100%',
                height: '80%',
                cssAutoLoad: false,
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
                url: '{{ route("backend:elfinder:showConnector") }}?image=1',
                soundPath: '{{ asset('module/admin/assets/elfinder/sounds') }}',
                getFileCallback: function (file) {
                    console.log(file);
                    console.log($($(self).data().input).val(file.url));
                    //$($(self).data().input).val(file.url);

                    var preview_image_wrapper = $(".preview-image-wrapper");
                    preview_image_wrapper.show();

                    preview_image_wrapper.find("img").attr('src', file.url);
                    preview_image_wrapper.find("[name='image']").val(file.url);

                    //
                    // var preview_image_wrapper = $( $(self).data().preview);
                    // preview_image_wrapper.attr('src', file.url);
                    // $('#elfinderShow').modal('hide');



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
        function Save(){
            let form_store = $("#form_store");

            clicks.fire(form_store,function (t) {
                let data = form_store.zoe_inputs('get');
                console.log(data);
                if(form_store.hasClass('submit')){
                    $("#form_store").submit();
                }
            });
        }
    </script>
@endsection

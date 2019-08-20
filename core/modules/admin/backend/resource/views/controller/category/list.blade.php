@extends('backend::layout.layout')
@section('content-header')
    <h1>
        &starf; {!! @z_language(["Manager Blog Category"]) !!}
        <small>it all starts here</small>
    </h1>
@endsection
@section('content')
    @breadcrumb()@endbreadcrumb
    <!-- Default box -->
    <div class="col-md-6">
        <div class="box box-zoe">
            <div class="box-header with-border">
                <h3 class="box-title">{!! @z_language(["Category"]) !!}</h3>
            </div>
            <div class="box-body">
                    <menu id="nestable-menu">
                        <button class="btn btn-default" type="button" data-action="expand-all">Expand All</button> &nbsp;
                        <button class="btn btn-default" type="button" data-action="collapse-all">Collapse All</button>
                    </menu>
                    <div class="cf nestable-lists">
                        <div class="dd" id="nestable">
                            {!! show_categories_ul_li($category)  !!}
                            {{--<ol class="dd-list">--}}
                                {{--@foreach($category as $_category)--}}
                                {{--<li class="dd-item dd3-item" data-id="{{$_category->id}}">--}}
                                    {{--<div class="dd-handle dd3-handle"></div>--}}
                                    {{--<div class="dd3-content">{{$_category->name}}</div>--}}
                                {{--</li>--}}
                                {{--@endforeach--}}
                                {{--<li class="dd-item dd3-item" data-id="14">--}}
                                    {{--<div class="dd-handle dd3-handle"></div><div class="dd3-content">Item 14</div>--}}
                                {{--</li>--}}
                                {{--<li class="dd-item dd3-item" data-id="15">--}}
                                    {{--<div class="dd-handle dd3-handle"></div><div class="dd3-content">Item 15</div>--}}
                                    {{--<ol class="dd-list">--}}
                                        {{--<li class="dd-item dd3-item" data-id="16">--}}
                                            {{--<div class="dd-handle dd3-handle"></div><div class="dd3-content">Item 16</div>--}}
                                        {{--</li>--}}
                                        {{--<li class="dd-item dd3-item" data-id="17">--}}
                                            {{--<div class="dd-handle dd3-handle"></div><div class="dd3-content">Item 17</div>--}}
                                        {{--</li>--}}
                                        {{--<li class="dd-item dd3-item" data-id="18">--}}
                                            {{--<div class="dd-handle dd3-handle"></div><div class="dd3-content">Item 18</div>--}}
                                        {{--</li>--}}
                                    {{--</ol>--}}
                                {{--</li>--}}
                            {{--</ol>--}}
                        </div>

                    </div>

            </div>
            <div class="box-footer">
                <button class="btn btn-default" onclick="SavePosition(this)"><i class="fa fa-plus"></i> Save</button>
            </div>
        </div>
    </div>



    <div class="col-md-6">

        <div class="box box-zoe">
            <div class="box-header with-border">
                <h3 class="box-title">{!! @z_language(["Category"]) !!}</h3>
            </div>
            <div class="box-body">
                {!! Form::open(['method' => 'POST','id'=>'form_store']) !!}
                {!! Form::hidden('type',$type) !!}
        <table class="table table-borderless">
            <tbody>
            <tr>
                <td>
                    {!! Form::label('name', 'Tiêu đề', ['class' => 'name']) !!}
                    {!! Form::text('name',null, ['class' => 'form-control','placeholder'=>'Tiêu đề']) !!}
                    <span class="error help-block"></span>
                </td>
            </tr>
            <tr>
                <td>

                    {!! Form::label('name', 'Tiêu đề', ['class' => 'name']) !!}
                    <select name="parent_id" class="form-control">
                        {!! show_categories($category) !!}
                    </select>
                </td>
            </tr>

            <tr>
                <td>
                    {!! Form::label('description', 'Mô tả', ['class' => 'description']) !!}
                    {!! Form::textarea('description',null, ['class' => 'form-control','placeholder'=>'Mô tả','cols'=>5,'rows'=>5]) !!}
                    <span class="error help-block"></span>
                </td>
            </tr>

            <tr>
                <td>
                    {!! Form::label('id_status', 'Status', ['class' => 'description']) !!}
                    {!! Form::radio('status', '1' , true) !!} Yes
                    {!! Form::radio('status', '0',false) !!} No

                </td>
            </tr>
            <tr>
                <td>
                    {!! Form::label('featured', 'Featured', ['class' => 'featured']) !!}
                    {!! Form::radio('featured', '1' , false) !!} Yes
                    {!! Form::radio('featured', '0',true) !!} No

                </td>
            </tr>
            </tbody>
        </table>
        {!! Form::close() !!}
            </div>
            <div class="box-footer">
                <button type="button" onclick="SaveInfo();" class="btn btn-default">Save</button>
            </div>
        </div>
    </div>
@endsection
@push("links")
    <style>
        .error{
            display: none;
        }
        .has-error .error{
            display:inline-block;
        }
        .cf:after { visibility: hidden; display: block; font-size: 0; content: " "; clear: both; height: 0; }
        * html .cf { zoom: 1; }
        *:first-child+html .cf { zoom: 1; }

        /*html { margin: 0; padding: 0; }*/
        /*body { font-size: 100%; margin: 0; padding: 1.75em; font-family: 'Helvetica Neue', Arial, sans-serif; }*/

        /*h1 { font-size: 1.75em; margin: 0 0 0.6em 0; }*/

        /*a { color: #2996cc; }*/
        /*a:hover { text-decoration: none; }*/

        p { line-height: 1.5em; }
        .small { color: #666; font-size: 0.875em; }
        .large { font-size: 1.25em; }

        /**
         * Nestable
         */

        .dd { position: relative; display: block; margin: 0; padding: 0;  list-style: none; font-size: 13px; line-height: 20px; }

        .dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
        .dd-list .dd-list { padding-left: 30px; }
        .dd-collapsed .dd-list { display: none; }
        .dd-item,
        .dd-empty,
        .dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
        .dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:         linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd-handle:hover { color: #2ea8e5; background: #fff; }
        .dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
        .dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0;     top: 20%;}
        .dd-item > button[data-action="collapse"]:before { content: '-'; }
        .dd-placeholder,
        .dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
        .dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
            background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
            linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
            background-size: 60px 60px;
            background-position: 0 0, 30px 30px;
        }
        .dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
        .dd-dragel > .dd-item .dd-handle { margin-top: 0; }
        .dd-dragel .dd-handle {
            -webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
            box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
        }
        .nestable-lists { display: block; clear: both; padding: 15px 0; width: 100%; border: 0; }
        #nestable-menu { padding: 0; margin: 20px 0; }
        .dd-hover > .dd-handle { background: #2ea8e5 !important; }
        .dd3-content { display: block; height: 30px; margin: 5px 0; padding: 5px 10px 5px 40px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
            background: #fafafa;
            background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
            background:         linear-gradient(top, #fafafa 0%, #eee 100%);
            -webkit-border-radius: 3px;
            border-radius: 3px;
            box-sizing: border-box; -moz-box-sizing: border-box;
        }
        .dd3-content:hover { color: #2ea8e5; background: #fff; }
        .dd-dragel > .dd3-item > .dd3-content { margin: 0; }
        .dd3-item > button { margin-left: 30px; }
        .dd3-handle { position: absolute; margin: 0; left: 0; top: 0; cursor: pointer; width: 30px; text-indent: 100%; white-space: nowrap; overflow: hidden;
            border: 1px solid #aaa;
            background: #ddd;
            background: -webkit-linear-gradient(top, #ddd 0%, #bbb 100%);
            background:    -moz-linear-gradient(top, #ddd 0%, #bbb 100%);
            background:         linear-gradient(top, #ddd 0%, #bbb 100%);
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }
        .dd3-handle:before { content: '≡'; display: block; position: absolute; left: 0; top: 3px; width: 100%; text-align: center; text-indent: 0; color: #fff; font-size: 20px; font-weight: normal; }
        .dd3-handle:hover { background: #ddd; }
        .dd3-handle {

            position: absolute;
            margin: 0;
            left: 0;
            top: 0;
            cursor: move;
            width: 2em;
            height: 100%;
            white-space: nowrap;
            overflow: hidden;

            line-height: 1;
        }
        .dd3-tool{
            position: absolute;
            right: 4px;
            width: 5em;
            top: 4px;
        }
        .dd3-tool .btn{
            margin-left: 5px;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{asset("http://wojoscripts.com/cmspro/assets/nestable.js")}}"></script>
    <script>
        function SaveInfo(){
            console.log('save');
            $.ajax({
                url: '{{@route('backend:category:ajax')}}',
                type: "POST",
                data: {"act":"info",data:$("#form_store").zoe_inputs('get')},
                success: function (data) {
                    $("#form_store").find('.has-error').removeClass('has-error').find('.help-block').hide();
                    if(data.hasOwnProperty('error')){
                        for(error in data.error){
                            console.log(error);
                           var parent = $("#"+error).parent();
                           parent.addClass('has-error');
                           parent.find('.error').html(data.error[error].join("\n"));

                        }
                    }else{

                    }
                }
            });
        }
        function SavePosition(){
            var e = $('#nestable').data('output', $('#nestable-output'));
            var list = e.length ? e : $(e.target), output = list.data('output');

            $.ajax({
                url: '{{@route('backend:category:ajax')}}',
                type: "POST",
                data:{act:"position",data: {pos:list.nestable('serialize'),type:'{!! $type !!}'}},
                success: function (data) {
                    $("#form_store").find('.has-error').removeClass('has-error').find('.help-block').hide();
                    if(data.hasOwnProperty('error')){
                        for(error in data.error){
                            console.log(error);
                            var parent = $("#"+error).parent();
                            parent.addClass('has-error');
                            parent.find('.error').html(data.error[error].join("\n"));

                        }
                    }else{

                    }
                }
            });
        }
        $(document).ready(function()
        {
            $("#nestable .edit").click(function () {
                $.ajax({
                    url: '{{@route('backend:category:ajax')}}',
                    type: "POST",
                    data:{act:"edit",data: {id:1,type:'{!! $type !!}'}},
                    success: function (data) {
                        console.log(data);
                    }
                });
            });
            $("#nestable .delete").click(function () {
                console.log(2);
            });
            var updateOutput = function(e)
            {
                var list   = e.length ? e : $(e.target),
                    output = list.data('output');
                console.log(window.JSON.stringify(list.nestable('serialize')));
            };
            $('#nestable').nestable({
                group: 1
            }).on('change', updateOutput);
            //$('.dd').nestable('collapseAll');
          //  updateOutput($('#nestable').data('output', $('#nestable-output')));
            $('#nestable-menu').on('click', function(e)
            {
                var target = $(e.target),
                    action = target.data('action');
                if (action === 'expand-all') {
                    $('.dd').nestable('expandAll');
                }
                if (action === 'collapse-all') {
                    $('.dd').nestable('collapseAll');
                }
            });
        });
    </script>
@endpush
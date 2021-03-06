@section('content1')
        <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title>Zoe Content Editor</title>
    <link rel="stylesheet" type="text/css"
          href="{!! asset('/plugins/layout/plugins/bootstrap-3.4.1/css/bootstrap.min.css') !!}"
          data-type="keditor-style"/>
    <link rel="stylesheet" type="text/css"
          href="{!! asset('/plugins/layout/plugins/font-awesome-4.7.0/css/font-awesome.min.css') !!}"
          data-type="keditor-style"/>
    <!-- Start of KEditor styles -->
    <link rel="stylesheet" type="text/css" href="{!! asset('/plugins/layout/dist/css/keditor.css') !!}"
          data-type="keditor-style"/>
    <link rel="stylesheet" type="text/css" href="{!! asset('/plugins/layout/dist/css/keditor-components.css') !!}"
          data-type="keditor-style"/>
    <!-- End of KEditor styles -->
    <link rel="stylesheet" type="text/css"
          href="{!! asset('/plugins/layout/plugins/code-prettify/src/prettify.css') !!}"/>
    <link rel="stylesheet" type="text/css" href="{!! asset('/plugins/layout/css/examples.css') !!}"/>
</head>

<body>
<div data-keditor="html">
    <div id="content-area">
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6" data-type="container-content">
                        <section data-type="component-text">
                            <div class="page-header">
                                <h1><b class="text-uppercase">Welcome to KEditor</b>
                                </h1>

                                <p class="lead">
                                    <em>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non
                                        mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id
                                        elit.</em>
                                </p>
                            </div>
                        </section>
                        <section data-type="component-form">
                            <div class="form-data" style="display: none !important;">[{"type":"text","label":"Your
                                email","placeholder":"Please enter your email
                                address","className":"form-control","name":"text-1561978528572","subtype":"text"},{"type":"button","label":"Subscribe","subtype":"button","className":"btn
                                btn-primary","name":"button-1561978530984","style":"primary"}]
                            </div>
                            <form class="form-content form-horizontal" data-grid="3-9">
                                <div class="fb-text form-group field-text-1561978528572"><label for="text-1561978528572"
                                                                                                class="fb-text-label control-label col-sm-3">Your
                                        email</label>
                                    <div class="col-sm-9"><input type="text"
                                                                 placeholder="Please enter your email address"
                                                                 class="form-control" name="text-1561978528572"
                                                                 id="text-1561978528572"></div>
                                </div>
                                <div class="fb-button form-group field-button-1561978530984">
                                    <div class="col-sm-9 col-sm-offset-3">
                                        <button type="button" class="btn btn-primary" name="button-1561978530984"
                                                style="primary" id="button-1561978530984">Subscribe
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>
                    <div class="col-sm-6" data-type="container-content">
                        <section data-type="component-photo">
                            <div class="photo-panel">
                                <img src="snippets/img/somewhere_bangladesh.jpg" style="display: inline-block;"
                                     height="" width="100%">
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/jquery-1.11.3/jquery-1.11.3.min.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/bootstrap-3.4.1/js/bootstrap.min.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/jquery-ui-1.12.1.custom/jquery-ui.min.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/plugins/layout/plugins/ckeditor-4.11.4/ckeditor.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/formBuilder-2.5.3/form-builder.min.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/formBuilder-2.5.3/form-render.min.js') !!}"></script>
<!-- Start of KEditor scripts -->
<script type="text/javascript" src="{!! asset('/plugins/layout/dist/js/keditor.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/plugins/layout/dist/js/keditor-components.js') !!}"></script>
<!-- End of KEditor scripts -->
<script type="text/javascript" src="{!! asset('/plugins/layout/plugins/code-prettify/src/prettify.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/js-beautify-1.7.5/js/lib/beautify.js') !!}"></script>
<script type="text/javascript"
        src="{!! asset('/plugins/layout/plugins/js-beautify-1.7.5/js/lib/beautify-html.js') !!}"></script>
<script type="text/javascript" src="{!! asset('/plugins/layout/js/examples.js') !!}"></script>
<script type="text/javascript" data-keditor="script">
    $(function () {
        $('#content-area').keditor();
    });
</script>
</body>
</html>
@endsection

@section('content')
    <!DOCTYPE html>
    <html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Zoe Layout</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <style media="screen">
            html,
            body {
                height: 100%;
            }

            body.opened-modal {
                overflow: hidden;
            }

            .keditor-ui {
                margin: 0;
                padding: 0;
                border: 0;
                outline: none;
            }

            .keditor-ui,
            .keditor-ui:before,
            .keditor-ui:after {
                box-sizing: border-box;
            }

            .keditor-wrapper {
                height: 100%;
                padding-top: 50px;
                background: #F6F6F6 url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAMAAABHPGVmAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RDc0RDRBMjA4RDhFMTFFOUExMDBGMzg5QkFCNzlCMTYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RDc0RDRBMjE4RDhFMTFFOUExMDBGMzg5QkFCNzlCMTYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpENzRENEExRThEOEUxMUU5QTEwMEYzODlCQUI3OUIxNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpENzRENEExRjhEOEUxMUU5QTEwMEYzODlCQUI3OUIxNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PkwGdVcAAAAGUExUReDh4////2LjhOYAAAACdFJOU/8A5bcwSgAAAEpJREFUeNrs0MEJADAMAzF7/6X76QoNJegWEFzapo/LHuRm119IIRAIBAKBQCAQCAQCgUAgEAgEAoFAIBAIBAKBQCAQCGQCOQIMAPTHJwTdmuFCAAAAAElFTkSuQmCC') repeat;
                position: relative;
                overflow: hidden;
                box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
            }

            .keditor-wrapper.small {
                background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEYAAABGCAMAAABG8BK2AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6MDdCNUFGQ0M4RDhGMTFFOUI5OEU4NzVCODUzRTM3RjYiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6MDdCNUFGQ0Q4RDhGMTFFOUI5OEU4NzVCODUzRTM3RjYiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDowN0I1QUZDQThEOEYxMUU5Qjk4RTg3NUI4NTNFMzdGNiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDowN0I1QUZDQjhEOEYxMUU5Qjk4RTg3NUI4NTNFMzdGNiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PmkfBJAAAAAGUExUReDh4////2LjhOYAAAACdFJOU/8A5bcwSgAAADtJREFUeNrsz7ENADAMwzD7/6e79INmKALqAAJK2/S5/MXcdk3NMcVgMBgMBoPBYDAYDAaDwcwzR4ABAPlJExg4Hh9rAAAAAElFTkSuQmCC');
            }

            .keditor-topbar {
                font: 14px/1.42857143 "Helvetica Neue", Helvetica, Arial, sans-serif;
                position: relative;
                top: 0;
                left: 0;
                width: 100%;
                background: #1b1d27;
            }

            .keditor-topbar:before,
            .keditor-topbar:after {
                display: table;
                content: " ";
            }

            .keditor-topbar:after {
                clear: both;
            }

            .keditor-topbar-title {
                color: #fff;
                line-height: 50px;
                overflow: hidden;
                text-overflow: ellipsis;
                padding-left: 15px;
            }

            .keditor-topbar-left,
            .keditor-topbar-center,
            .keditor-topbar-right {
                float: left;
                height: 50px;
                word-spacing: -1em;
            }

            .keditor-topbar-left > *,
            .keditor-topbar-center > *,
            .keditor-topbar-right > * {
                word-spacing: normal;
                display: inline-block;
            }

            .keditor-topbar-left,
            .keditor-topbar-right {
                width: calc(50% - 100px);
            }

            .keditor-topbar-right {
                text-align: right;
            }

            .keditor-topbar-center {
                width: 200px;
                text-align: center;
            }

            .keditor-topbar-btn {
                height: 50px;
                line-height: 50px;
                color: #c8c9cf !important;
                text-decoration: none;
                width: 50px;
                text-align: center;
            }

            .keditor-topbar-btn:hover,
            .keditor-topbar-btn.active {
                background: #303443;
            }

            .keditor-topbar-btn i {
                font-size: 20px;
            }

            .keditor-sidebar {
                position: absolute;
                top: 50px;
                bottom: 0;
                right: -300px;
                width: 300px;
                background: #f0f0f0;
                border-left: 1px solid #ddd;
                box-shadow: -1px 0 5px rgba(0, 0, 0, 0.15);
                transition: all 0.3s;
                opacity: 0;
            }

            .keditor-sidebar.opened {
                right: 0;
                opacity: 1;
            }

            .keditor-iframe-wrapper .keditor-sidebar {
                position: absolute;
            }

            .keditor-sidebar-header {
                border-bottom: 1px solid #ddd;
                padding: 10px 30px 10px 15px;
                position: relative;
            }

            .keditor-sidebar-closer {
                text-decoration: none !important;
                color: #ccc;
                text-align: center;
                position: absolute;
                top: 8px;
                right: 5px;
                width: 24px;
                height: 24px;
                line-height: 23px;
                font-size: 19px;
                font-weight: bold;
            }

            .keditor-sidebar-closer:hover {
                color: #aaa;
            }

            .keditor-sidebar-title {
                font-weight: bold;
                white-space: nowrap;
                text-overflow: ellipsis;
                overflow: hidden;
                display: block;
            }

            .keditor-sidebar-body {
                height: calc(100% - 41px);
                overflow: hidden;
                position: relative;
            }

            .keditor-sidebar-body .keditor-setting-form {
                overflow-x: hidden;
                overflow-y: auto;
                padding: 10px 15px;
                position: absolute;
                height: 100%;
                width: 100%;
                top: 0;
                right: -100%;
                opacity: 0;
                transition: all 0.3s;
            }

            .keditor-sidebar-body .keditor-setting-form::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            .keditor-sidebar-body .keditor-setting-form::-webkit-scrollbar-track {
                background: #eee;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.1);
            }

            .keditor-sidebar-body .keditor-setting-form::-webkit-scrollbar-thumb {
                background: #ddd;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
            }

            .keditor-sidebar-body .keditor-setting-form::-webkit-scrollbar-thumb:hover {
                background: #cdcdcd;
            }

            .keditor-sidebar-body .keditor-setting-form::-webkit-scrollbar-thumb:active {
                background: #cdcdcd;
            }

            .keditor-sidebar-body .keditor-setting-form:before,
            .keditor-sidebar-body .keditor-setting-form:after {
                display: table;
                content: " ";
            }

            .keditor-sidebar-body .keditor-setting-form:after {
                clear: both;
            }

            .keditor-sidebar-body .keditor-setting-form.active {
                right: 0;
                opacity: 1;
            }

            .keditor-preview-area {
                display: none;
            }

            .previewing .keditor-preview-area {
                display: block;
            }

            .btn-paste-content {
                display: none !important;
            }

            .copying .btn-paste-content {
                display: inline-block !important;
            }

            .copying-component .keditor-toolbar-bottom-container:not(.keditor-toolbar-bottom-sub-container) .btn-paste-content,
            .copying-component .keditor-toolbar-content-area .btn-paste-content {
                display: none !important;
            }

            .copying-container .keditor-toolbar-bottom-component .btn-paste-content,
            .copying-container .keditor-toolbar-bottom-sub-container .btn-paste-content,
            .copying-container .keditor-toolbar-container-content .btn-paste-content {
                display: none !important;
            }

            .copying-sub-container .keditor-toolbar-sub-container-content .btn-paste-content,
            .copying-sub-container .keditor-toolbar-bottom-container:not(.keditor-toolbar-bottom-sub-container) .btn-paste-content,
            .copying-sub-container .keditor-toolbar-content-area .btn-paste-content {
                display: none !important;
            }

            .previewing .keditor-content-areas-wrapper {
                display: none;
            }

            .keditor-content-area {
                min-height: 100px;
                width: auto;
                margin: 0;
                padding: 30px;
                position: relative;
            }

            .keditor-modal {
                display: none;
                position: fixed;
                z-index: 99999;
                top: -100%;
                left: 0;
                width: 100%;
                height: 100%;
                background: #fff;
                transition: all 0.3s;
                opacity: 0;
                font: 14px/1.42857143 "Helvetica Neue", Helvetica, Arial, sans-serif;
            }

            .keditor-modal.showed {
                top: 0;
                opacity: 1;
            }

            .keditor-modal .keditor-snippet {
                display: none;
            }

            .keditor-modal.keditor-modal-component .keditor-snippet-component {
                display: block;
            }

            .keditor-modal.keditor-modal-component .keditor-snippets-filter-component {
                display: block;
            }

            .keditor-modal.keditor-modal-container .keditor-snippet-container {
                display: block;
            }

            .keditor-modal.keditor-modal-container .keditor-snippets-filter-container {
                display: block;
            }

            .keditor-modal.keditor-modal-component.keditor-modal-container .keditor-snippets-filter-container.duplicated {
                display: none;
            }

            .keditor-modal-header {
                background: #fff;
                border-bottom: 1px solid #ddd;
                padding: 0 15px;
                z-index: 2;
                display: flex;
                justify-content: center;
                flex-direction: row-reverse;
                height: 56px;
                align-items: center;
            }

            .keditor-modal-header:before,
            .keditor-modal-header:after {
                display: table;
                content: " ";
            }

            .keditor-modal-header:after {
                clear: both;
            }

            .keditor-modal-header .keditor-modal-title {
                font-size: 18px;
                line-height: 1.4;
                margin: 0;
                color: #333;
                font-weight: 500;
                flex: 1;
            }

            .keditor-modal-header .keditor-modal-close {
                border: 0;
                background: 0;
                font-size: 20px;
                color: #ccc;
                cursor: pointer;
                width: 32px;
                height: 32px;
                line-height: 32px;
                padding: 0;
                font-weight: bold;
            }

            .keditor-modal-header .keditor-modal-close:hover {
                color: #aaa;
            }

            .keditor-modal-header .keditor-snippets-filter-wrapper {
                flex: 1;
                display: flex;
            }

            .keditor-modal-header .keditor-snippets-filter-component,
            .keditor-modal-header .keditor-snippets-filter-container {
                display: none;
            }

            .keditor-modal-header .keditor-snippets-filter-label,
            .keditor-modal-header .keditor-snippets-filter,
            .keditor-modal-header .keditor-snippets-search {
                font: 14px/1.42857143 "Helvetica Neue", Helvetica, Arial, sans-serif;
                height: 25px;
                background: none;
                margin-right: 15px;
                font-weight: normal;
                line-height: 25px;
                border: 0;
            }

            .keditor-modal-header .keditor-snippets-filter,
            .keditor-modal-header .keditor-snippets-search {
                background: #eee;
                padding: 0 5px;
            }

            .keditor-modal-header .keditor-snippets-search {
                width: 40%;
            }

            .keditor-modal-body {
                height: calc(100% - 56px);
                position: relative;
                z-index: 1;
            }

            .has-footer .keditor-modal-body {
                height: calc(100% - 56px - 54px);
            }

            .keditor-modal-footer {
                background: #fff;
                border-top: 1px solid #ddd;
                text-align: center;
                padding: 0 15px;
                height: 54px;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .keditor-modal-footer .keditor-btn {
                margin: 0 5px;
            }

            .keditor-snippets-wrapper {
                height: 100%;
            }

            .keditor-snippets-wrapper .keditor-snippets {
                height: 100%;
                overflow-y: scroll;
                padding: 15px 7.5px 0;
                display: flex;
                justify-content: space-evenly;
                align-content: flex-start;
                flex-flow: wrap;
            }

            .keditor-snippets-wrapper .keditor-snippets::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            .keditor-snippets-wrapper .keditor-snippets::-webkit-scrollbar-track {
                background: #eee;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.1);
            }

            .keditor-snippets-wrapper .keditor-snippets::-webkit-scrollbar-thumb {
                background: #ddd;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
            }

            .keditor-snippets-wrapper .keditor-snippets::-webkit-scrollbar-thumb:hover {
                background: #cdcdcd;
            }

            .keditor-snippets-wrapper .keditor-snippets::-webkit-scrollbar-thumb:active {
                background: #cdcdcd;
            }

            .keditor-snippet {
                border: 1px solid #eee;
                cursor: pointer;
                transition: all 0.3s;
                display: block;
                background: #ffffff;
                user-select: none;
                width: 200px;
                margin: 0 7.5px 15px;
                flex: none;
            }

            .keditor-snippet .keditor-snippet-inner {
                display: block;
                padding-bottom: 100%;
                position: relative;
            }

            .keditor-snippet .keditor-snippet-preview {
                position: absolute;
                top: 15px;
                left: 15px;
                bottom: 30px;
                right: 15px;
                background: no-repeat 50% 50% / contain;
            }

            .keditor-snippet .keditor-snippet-title {
                position: absolute;
                left: 0;
                bottom: 0;
                right: 0;
                font-size: 12px;
                height: 30px;
                line-height: 30px;
                overflow: hidden;
                text-overflow: ellipsis;
                text-align: center;
                padding: 0 10px;
                white-space: nowrap;
            }

            .keditor-snippet.not-matched {
                display: none !important;
            }

            .keditor-snippet.selected {
                border-color: #2eb2e4;
                box-shadow: 0 0 0 2px #2eb2e4;
            }

            @media (max-width: 420px) {
                .keditor-snippet {
                    width: calc(100% - 30px);
                }
            }

            .keditor-btn-group {
                letter-spacing: -1em;
            }

            .keditor-btn-group .keditor-btn {
                letter-spacing: normal;
                border-top-left-radius: 0;
                border-bottom-left-radius: 0;
            }

            .keditor-btn-group .keditor-btn:first-child {
                border-top-right-radius: 0;
                border-bottom-right-radius: 0;
            }

            .keditor-btn {
                border: 0;
                background: none;
                height: 23px;
                line-height: 22px;
                font-size: 12px;
                padding: 0 10px;
                border-radius: 5px;
                box-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
                display: inline-block;
                text-decoration: none !important;
            }

            .keditor-btn i {
                line-height: 22px;
            }

            .keditor-btn.keditor-btn-default {
                border: 1px solid #ddd;
                background: #fff;
                color: #333;
            }

            .keditor-btn.keditor-btn-default:hover {
                background: #f2f2f2;
            }

            .keditor-btn.keditor-btn-default:focus,
            .keditor-btn.keditor-btn-default:active {
                border-color: #c9c9c9;
                background: #ebebeb;
            }

            .keditor-btn.keditor-btn-primary {
                border: 1px solid #333;
                background: #333;
                color: #fff;
            }

            .keditor-btn.keditor-btn-primary:hover {
                background: #262626;
            }

            .keditor-btn.keditor-btn-primary:focus,
            .keditor-btn.keditor-btn-primary:active {
                border-color: #1f1f1f;
                background: #1f1f1f;
            }

            .keditor-toolbar {
                position: absolute;
                display: none;
                z-index: 5;
                font: 14px/1.42857143 "Helvetica Neue", Helvetica, Arial, sans-serif;
                overflow: hidden;
            }

            .keditor-toolbar > a {
                font-size: 12px;
                width: 21px;
                height: 21px;
                display: block;
                text-align: center;
                line-height: 21px;
                transition: all 0.3s;
            }

            .keditor-toolbar > a .fa {
                line-height: inherit;
            }

            .keditor-toolbar .btn-container-move {
                cursor: n-resize;
            }

            .keditor-toolbar .btn-component-move {
                cursor: move;
            }

            .keditor-toolbar.keditor-toolbar-bottom {
                top: auto !important;
                left: 50% !important;
                transform: translateX(-50%);
                background-color: rgba(0, 0, 0, 0.5);
                border-radius: 5px 5px 0 0 !important;
            }

            .keditor-toolbar.keditor-toolbar-bottom > a {
                line-height: 22px;
            }

            .keditor-toolbar-content-area,
            .keditor-toolbar-container-content {
                text-align: center;
                padding: 15px 0;
                position: relative;
                z-index: 1;
                display: block;
            }

            .keditor-container {
                position: relative;
            }

            .keditor-container > .keditor-container-inner {
                position: relative;
            }

            .keditor-container > .keditor-container-inner:before {
                position: absolute;
                top: -2px;
                right: -2px;
                left: -2px;
                bottom: -2px;
                border: 2px dashed transparent;
                content: " ";
                display: block;
                z-index: -1;
            }

            .keditor-container > .keditor-toolbar {
                top: -2px;
                left: -21px;
                border-radius: 5px 0 0 5px;
            }

            .keditor-container > .keditor-toolbar > a {
                background: #1b1d27;
                color: #fff;
            }

            .keditor-container > .keditor-toolbar > a:hover {
                background: #2eb2e4;
            }

            .keditor-container > .keditor-toolbar-bottom-container {
                bottom: -2px;
            }

            .keditor-container > .keditor-toolbar-bottom-container > a {
                float: left;
            }

            .keditor-container:hover > .keditor-container-inner:before {
                border-color: #adb2c7;
            }

            .keditor-container.showed-keditor-toolbar {
                z-index: 2;
            }

            .keditor-container.showed-keditor-toolbar > .keditor-container-inner:before {
                border-color: #1b1d27;
            }

            .keditor-container:hover > .keditor-toolbar,
            .keditor-container.showed-keditor-toolbar > .keditor-toolbar {
                display: block;
            }

            .keditor-container:last-child > .keditor-toolbar-bottom-container,
            .keditor-container:only-child > .keditor-toolbar-bottom-container {
                display: none;
            }

            .keditor-container-content {
                position: relative;
            }

            .keditor-container-content:before {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                content: " ";
                display: block;
                border: 1px dashed #e0e0e0;
            }

            .keditor-container-content-inner {
                min-height: 70px !important;
            }

            .keditor-component {
                position: relative;
                z-index: 1;
                transition: padding-bottom 0.3s;
            }

            .keditor-component:before {
                position: absolute;
                top: -1px;
                right: -1px;
                left: -1px;
                bottom: -1px;
                content: " ";
                border: 1px solid transparent;
                z-index: -1;
            }

            .keditor-component .keditor-toolbar {
                top: 0;
                left: 0;
                background-color: rgba(0, 0, 0, 0.5);
                border-bottom-right-radius: 5px;
            }

            .keditor-component .keditor-toolbar > a {
                color: #fff;
                float: left;
            }

            .keditor-component .keditor-toolbar > a:hover {
                background-color: rgba(0, 0, 0, 0.8);
            }

            .keditor-component .keditor-toolbar-bottom-component {
                bottom: -1px;
            }

            .keditor-component .keditor-component-content {
                position: relative;
                z-index: 2;
                min-height: 30px !important;
            }

            .keditor-component .keditor-component-content:before,
            .keditor-component .keditor-component-content:after {
                display: table;
                content: " ";
            }

            .keditor-component .keditor-component-content:after {
                clear: both;
            }

            .keditor-component:hover:before {
                border-color: rgba(0, 0, 0, 0.5);
            }

            .keditor-component.showed-keditor-toolbar:before {
                border-color: rgba(0, 0, 0, 0.8);
            }

            .keditor-component:hover,
            .keditor-component.showed-keditor-toolbar {
                z-index: 2;
            }

            .keditor-component:hover:before,
            .keditor-component.showed-keditor-toolbar:before {
                display: block;
            }

            .keditor-component:hover .keditor-toolbar,
            .keditor-component.showed-keditor-toolbar .keditor-toolbar {
                display: block;
            }

            .keditor-component.showed-keditor-toolbar .keditor-component-content {
                outline: none !important;
            }

            .keditor-component:last-child > .keditor-toolbar-bottom-component,
            .keditor-component:only-child > .keditor-toolbar-bottom-component {
                display: none;
            }

            .keditor-iframe-wrapper {
                overflow: auto;
                height: 100%;
            }

            .keditor-iframe-width-switcher {
                position: relative;
                height: 100%;
                margin: 0 auto;
                box-shadow: 0 0 35px rgba(0, 0, 0, 0.07);
            }

            .keditor-iframe {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                border: 0;
            }

            .keditor-iframe-body::-webkit-scrollbar {
                width: 10px;
                height: 10px;
            }

            .keditor-iframe-body::-webkit-scrollbar-track {
                background: #eee;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.1);
            }

            .keditor-iframe-body::-webkit-scrollbar-thumb {
                background: #ddd;
                -webkit-box-shadow: inset 0 0 3px rgba(0, 0, 0, 0.2);
            }

            .keditor-iframe-body::-webkit-scrollbar-thumb:hover {
                background: #cdcdcd;
            }

            .keditor-iframe-body::-webkit-scrollbar-thumb:active {
                background: #cdcdcd;
            }

            .keditor-iframe-cover-wrapper {
                position: relative;
            }

            .keditor-iframe-cover-wrapper iframe,
            .keditor-iframe-cover-wrapper .keditor-iframe-cover {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
            }

            .keditor-iframe-cover-wrapper iframe {
                z-index: 1;
            }

            .keditor-iframe-cover-wrapper .keditor-iframe-cover {
                z-index: 3;
                background: rgba(0, 0, 0, 0.15);
            }

            .keditor-iframe-cover-wrapper .keditor-iframe-cover:before {
                display: block;
                content: "Double-click to reveal content";
                color: #fff;
                font-size: 24px;
                position: absolute;
                width: 100%;
                text-align: center;
                padding: 5px;
                left: 0;
                top: 50%;
                transform: translate(0, -50%);
                text-shadow: 0 0 3px #000;
            }

            .keditor-iframe-cover-wrapper.hidden-cover iframe {
                z-index: 2;
            }

            .keditor-iframe-cover-wrapper.hidden-cover .keditor-iframe-cover {
                display: none;
            }

            .ui-sortable-placeholder.keditor-snippet,
            .ui-sortable-placeholder.keditor-container,
            .ui-sortable-placeholder.keditor-component {
                background: #b5e4f6 !important;
                visibility: visible !important;
                height: 20px !important;
                margin: 5px 0 !important;
                float: none !important;
                outline: none !important;
                padding: 0 !important;
                opacity: 1 !important;
                border: 2px solid #2eb2e4;
            }

            .ui-sortable-placeholder.keditor-snippet:before,
            .ui-sortable-placeholder.keditor-container:before,
            .ui-sortable-placeholder.keditor-component:before,
            .ui-sortable-placeholder.keditor-snippet:after,
            .ui-sortable-placeholder.keditor-container:after,
            .ui-sortable-placeholder.keditor-component:after {
                display: none !important;
            }

            .ui-sortable-helper.keditor-section {
                background: #ffffff !important;
            }

            .ui-sortable-helper.keditor-container .keditor-toolbar.keditor-toolbar-container {
                display: block !important;
            }

            .ui-sortable-helper.keditor-container .keditor-toolbar.keditor-toolbar-container > a {
                display: none;
            }

            .ui-sortable-helper.keditor-container .keditor-toolbar.keditor-toolbar-container > a.btn-container-move {
                display: block;
            }

            .ui-sortable-helper.keditor-container .keditor-toolbar-bottom {
                display: none !important;
            }

            .ui-sortable-helper.keditor-component .keditor-toolbar {
                display: block !important;
            }

            .ui-sortable-helper.keditor-component .keditor-toolbar > a {
                display: none;
            }

            .ui-sortable-helper.keditor-component .keditor-toolbar > a.btn-component-move {
                display: block;
            }

            .ui-sortable-helper.keditor-component .keditor-toolbar-bottom {
                display: none !important;
            }

            .ui-resizable-resizer {
                position: absolute;
                width: 6px;
                top: 0;
                bottom: 0;
                right: -3px;
                background: #ddd;
                cursor: col-resize;
                display: none !important;
            }

            .ui-resizable-resizer:before {
                display: block;
                content: '';
                height: 30px;
                width: 2px;
                background: #aaa;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }

            .ui-resizable-resizing .ui-resizable-resizer,
            .ui-resizable-resizer:hover {
                background: #ccc;
            }

            .ui-resizable-resizing .ui-resizable-resizer:before,
            .ui-resizable-resizer:hover:before {
                background: #333;
            }

            .ui-resizable-resizing .ui-resizable-resizer,
            .ui-resizable:focus .ui-resizable-resizer,
            .ui-resizable:hover .ui-resizable-resizer {
                display: block !important;
            }

            .keditor-ui-hidden {
                display: none !important;
            }

            .keditor-ui-cutting .keditor-component-content,
            .keditor-ui-cutting .keditor-container-inner {
                opacity: 0.5 !important;
            }

            .keditor-ui-dragging {
                display: block !important;
                opacity: 0.2 !important;
            }

            .keditor-ui-dragging .keditor-toolbar {
                display: none !important;
            }


        </style>
    </head>
    <body>
    <div class="keditor-ui keditor-topbar" id="keditor-ui-15689129083501545951962">
        <div class="keditor-ui keditor-topbar-left">
            <a href="#" class="keditor-ui keditor-topbar-title"><i class="fa fa-home"></i></a>
            <div class="keditor-ui keditor-topbar-title" title="Editing with KEditor">Zoe Editor</div>
        </div>
        <div class="keditor-ui keditor-topbar-center">
            <a href="javascript:void(0);" title="View on mobile" class="keditor-ui keditor-topbar-btn active"
               data-width="420px"><i class="fa fa-fw fa-mobile"></i></a>
            <a href="javascript:void(0);" title="View on tablet" class="keditor-ui keditor-topbar-btn"
               data-width="820px"><i class="fa fa-fw fa-tablet"></i></a>
            <a href="javascript:void(0);" title="View on laptop" class="keditor-ui keditor-topbar-btn"
               data-width="1050px"><i class="fa fa-fw fa-laptop"></i></a>
            <a href="javascript:void(0);" title="View on desktop" class="keditor-ui keditor-topbar-btn"
               data-width="100%"><i class="fa fa-fw fa-desktop"></i></a>
        </div>
        <div class="keditor-ui keditor-topbar-right">
            <a href="javascript:void(0);" title="Preview OFF" class="keditor-ui keditor-topbar-btn"><i
                        class="fa fa-fw fa-eye-slash"></i></a><a href="javascript:void(0);" title="Fullscreen Off"
                                                                 class="keditor-ui keditor-topbar-btn"><i
                        class="fa fa-fw fa-expand"></i></a><a href="javascript:void(0);" title="Save"
                                                              class="keditor-ui keditor-topbar-btn"><i
                        class="fa fa-fw fa-save"></i></a></div>
    </div>
    <div class="keditor-ui keditor-iframe-wrapper">
        <!-- width: 420px; width: 820px;  width: 1050px;  min-width: 1250px;-->
        <div class="keditor-ui keditor-iframe-width-switcher" style="width: 420px;">
            <iframe src="/" class="keditor-ui keditor-iframe"></iframe>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" charset="utf-8"></script>
    <script type="text/javascript">
        $('.keditor-topbar-btn').click(function () {
            $('.keditor-topbar .keditor-topbar-center .active').removeClass('active');
            $(this).addClass('active');
            $('.keditor-iframe-width-switcher').css({'width': $(this).attr('data-width')});
        });
    </script>
    </body>
    </html>
@endsection

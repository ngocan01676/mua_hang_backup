@section('content-header')

    <h1>
        &starf; {!! @z_language(["Manager Blog Post"]) !!}
        <small>it all starts here</small>
        <a href="{{route('backend:blog:post:create')}}"
           class="btn btn-default btn-md"><i class="fa fa-fw fa-plus"></i> {!! @z_language(["Add New"]) !!} </a>
        <x-btnOption :config="['name'=>'core:blog:post']">
            <x-slot name="label">
                {{@z_language(["Option"])}}
            </x-slot>
            <x-slot name="header">
                {{@z_language(["Option"])}}
            </x-slot>
        </x-btnOption>

    </h1>
@endsection
@section('content')
    <x-breadcrumb/>
    @component('backend::layout.component.list',['name'=>'core:blog:post','models'=>$models,'route'=>$route,'parameter'=>$parameter,'callback'=>$callback])
        @slot("tool")
            <div class="box-body">
                <div class="col-md-12" style="padding:0">
                    <div class="row">
                        <div class="col-sm-4" style="padding:0">
                            <div class="col-sm-4" style="padding:0;text-align: center;line-height: 2;">
                                <label>Id</label>
                            </div>
                            <div class="col-sm-8" style="padding:0;text-align: center;">
                                <input type="text" name="filter.id" class="form-control" id="user_id"
                                       placeholder="Id">
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding:0">
                            <div class="col-sm-4" style="padding:0;text-align: center;line-height: 2;">
                                <label>Name</label>
                            </div>
                            <div class="col-sm-8" style="padding:0;text-align: center;">
                                <input type="text" name="filter.name" class="form-control" id="username"
                                       placeholder="Name">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <button type="button" class="btnFilter btn btn-sm btn-primary pull-right">
                           {!! z_language('D??? li???u') !!}
                        </button>
                    </div>
                </div>
            </div>
        @endslot
    @endcomponent
@endsection
@push('links')
    <link rel="stylesheet" href="{{asset('module/admin/plugins/iCheck/all.css')}}">
@endpush
@push('scripts')
    <script src="{{asset('module/admin/plugins/iCheck/icheck.min.js')}}"></script>
    <script>
        $('input[type="checkbox"].minimal').iCheck({
            checkboxClass: 'icheckbox_minimal-blue',
            radioClass: 'iradio_minimal-blue'
        })
    </script>
@endpush
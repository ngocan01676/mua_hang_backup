@section('content-header')
    <h1>
        &starf; {!! @z_language(["Manager Layout"]) !!}
        <small>it all starts here</small>
        <a href="{{route('backend:layout:create')}}"
           class="btn btn-default btn-md"><i class="fa fa-fw fa-plus"></i> {!! @z_language(["Add New"]) !!} </a>
        @btn_option(["config"=>['name'=>'core:layout']])
        @slot('label')
            {{@z_language(["Option"])}}
        @endslot
        @slot('header')
            {{@z_language(["Layout Option"])}}
        @endslot
        @endbtn_option
    </h1>
@endsection
@section('content')
    @breadcrumb()@endbreadcrumb
    @component('backend::layout.component.list',['name'=>'core:layout','models'=>$models,'route'=>$route])
        @slot("tool")
            <div class="box-body">
                <div class="col-md-12" style="padding:0">
                    <div class="row">
                        <div class="col-sm-4" style="padding:0">
                            <div class="col-sm-4" style="padding:0;text-align: center;line-height: 2;">
                                <label>Name</label>
                            </div>
                            <div class="col-sm-8" style="padding:0;text-align: center;">
                                <input type="text" name="filter.name" class="form-control" id="username"
                                       placeholder="Name">
                            </div>
                        </div>
                        <div class="col-sm-4" style="padding:0">
                            <div class="col-sm-4" style="padding:0;text-align: center;line-height: 2;">
                                <label>Id</label>
                            </div>
                            <div class="col-sm-8" style="padding:0;text-align: center;">
                                <input type="text" name="filter.id" class="form-control" id="user_id"
                                       placeholder="Id">
                            </div>
                        </div>

                        @if(!isset($route["type"]))
                            <div class="col-sm-4" style="padding:0">
                                <div class="col-sm-4" style="padding:0;text-align: center;line-height: 2;">
                                    <label>Type</label>
                                </div>
                                <div class="col-sm-8" style="padding:0;text-align: center;">
                                    <select name="filter.type" class="form-control">
                                        <option value="">All</option>
                                        @foreach($listsType as $type=>$label)
                                            <option value="{!! $type !!}">{{$label}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <BR>
                        <button type="button" class="btnFilter btn btn-sm btn-primary pull-right">
                            Dữ liệu
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
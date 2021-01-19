@section('content-header')
    <h1>
        &starf; {!! @z_language(["QL thông báo"]) !!}
        <small>it all starts here</small>
        <a href="{{route('backend:announce:create')}}"
           class="btn btn-default btn-md"><i class="fa fa-fw fa-plus"></i> {!! @z_language(["Tạo mới"]) !!} </a>
        <x-btnOption :config="['name'=>'core:announce']">
            <x-slot name="label">
                {{@z_language(["Config"])}}
            </x-slot>
            <x-slot name="header">
                {{@z_language(["Config"])}}
            </x-slot>
        </x-btnOption>
    </h1>
@endsection
@section('content')
    <x-breadcrumb/>

    @component('backend::layout.component.list',['name'=>'core:announce','models'=>$models,'callback'=>$callback])

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
            radioClass   : 'iradio_minimal-blue'
        })
    </script>
@endpush
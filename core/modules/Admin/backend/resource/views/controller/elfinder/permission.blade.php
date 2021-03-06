@section('content')
    <div class="row" id="elf_premission">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">{!! @z_language(["Premission Folder"]) !!}</h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip"
                                title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <form action="" id="formData">
                        <div class="col-md-2">
                            <table class="table-bordered table">
                                <tr>
                                    <th colspan="3" class="text-center">{!! z_language("Folders") !!}</th>
                                </tr>
                                <tr>
                                    <td colspan="3">
                                        <div id="main">
                                            <?php
                                            function showDirectories($list, $parent = array())
                                            {
                                                echo "<ul>";
                                                foreach ($list as $directory){
                                                    $parent_name = count($parent) ? $parent['name'] : 'no';
                                                    $prefix = str_repeat('-', $directory['level']);
                                                    echo "<li a parent='".$parent_name."'>".$directory['name'];
                                                    if(count($directory['children'])){
                                                        // list the children directories
                                                        showDirectories($directory['children'], $directory);
                                                    }
                                                    echo '</li>';
                                                }
                                                echo "</ul>";
                                            }
                                            showDirectories($directories);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-5 permission">
                            <table class="table-bordered table">
                                <thead>
                                    <tr>
                                        <th colspan="5" class="text-center">{!! z_language("Role") !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center" style="width: 40%">{!! z_language('Name') !!}</th>
                                        <th class="text-center">{!! z_language('Read') !!} <input type="checkbox" value="1" onchange="change(this)"></th>
                                        <th class="text-center">{!! z_language('Write') !!} <input type="checkbox" value="2" onchange="change(this)"></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="main">
                                                <table class="table-bordered table role" data-content="#">
                                                    <tbody>
                                                    @foreach($roles as $role)
                                                        <tr>
                                                            <td class="text-center" style="width: 40%">{!! $role->name !!}</td>
                                                            <td class="text-center"><input type="checkbox" value="1" name="role.read[{!! $role->name !!}]"></td>
                                                            <td class="text-center"><input type="checkbox" value="2" name="role.write[{!! $role->name !!}]"></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                 </tbody>
                            </table>

                        </div>
                        <div class="col-md-5 permission">
                            <table class="table-bordered table">
                                <thead>
                                    <tr>
                                        <th class="text-center" colspan="5">{!! z_language("User") !!}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center" style="width: 40%">{!! z_language('Name') !!}</th>
                                        <th class="text-center">{!! z_language('Read') !!} <input type="checkbox"  value="1" onchange="change(this)"></th>
                                        <th class="text-center">{!! z_language('Write') !!} <input type="checkbox"  value="2" onchange="change(this)"></th>
                                    </tr>
                                    <tr>
                                        <td colspan="3">
                                            <div class="main">
                                                <table class="table-bordered table">
                                                    <tbody>
                                                    @foreach($admins as $admin)
                                                        <tr>
                                                            <td class="text-center" style="width: 40%">{!! $admin->username !!}</td>
                                                            <td class="text-center"><input type="checkbox" value="1" name="admin.read[{!! $admin->username !!}]"></td>
                                                            <td class="text-center"><input type="checkbox" value="2" name="admin.write[{!! $admin->username !!}]"></td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    <button class="btn btn-sm btn-primary pull-right" onclick="SaveAction()"> <i class="fa fa-save"></i> {!! z_language("Save") !!}</button>
                </div>
                <!-- /.box-footer-->
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <style>
        .permission tbody{
            opacity: 0.7;
        }
        .permission.selected tbody{
            opacity: 1;
        }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/themes/default/style.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jstree/3.2.1/jstree.min.js"></script>
    <script>
        let selected = null;

        function change(self){
            let status = $(self).is(":checked");
            let val = $(self).val();

            $(self).closest('.permission').find('.main tbody tr input[value="'+val+'"]').each(function () {
                $(this).prop('checked',status);
            });
            console.log();
            console.log(val);
            console.log(status);
            if(status){

            }
        }
        $(function () {
            $('#main').on('changed.jstree', function (e, data) {
                var i, j, r = [];
                for(i = 0, j = data.selected.length; i < j; i++) {
                    r.push(data.instance.get_node(data.selected[i]).text);
                }
                if(r.length > 0){
                    $(".permission").addClass('selected');
                    $("#elf_premission .selected .main").mask("{!! z_language('Waiting...') !!}");
                    selected = r[0];
                    console.log('selected:'+selected);
                    $('#formData input:checkbox').each(function () {
                        $(this).prop('checked',false);
                    });

                    $.ajax({
                        type: "POST",
                        data: {"act": "get", selected:selected},
                        success: function (data) {
                            $("#formData").zoe_inputs('set',data);

                            $("#elf_premission .selected .main").unmask();
                        }
                    });
                }
            }).jstree();
        });
        function SaveAction() {
            console.log(selected);
            let dataForm = $("#formData").zoe_inputs('get');
            $("#elf_premission .selected .main").mask("{!! z_language('Waiting...') !!}");
            $.ajax({
                type: "POST",
                data: {"act": "save", data: dataForm,selected:selected},
                success: function (data) {
                    $("#elf_premission .selected .main").unmask();
                }
            });
        }
    </script>
@endpush


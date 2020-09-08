<table class="table">
    <tr>
        <td style="width: 5%"><input type="text" class="form-control" readonly id="col-row-review"></td>
        <td style="width: 95%">
            <input type="text" class="form-control" id="value-review">
            <div id="zoe-dropdown-review" style="display: none"></div>
        </td>
    </tr>
</table>
<div id="spreadsheet"></div>
@if(isset($model))
    {!! Form::model($model, ['method' => 'POST','route' => ['backend:shop_ja:product:store'],'id'=>'form_store']) !!}
    {!! Form::hidden('id') !!}
@else
    {!! Form::open(['method' => 'POST','route' => ['backend:shop_ja:product:store'],'id'=>'form_store']) !!}
@endif
<div>
    <tr>
        <td>
            {!! Form::label('id_status', 'Status', ['class' => 'status']) !!} &nbsp;
            {!! Form::radio('status', '0' , true) !!} Nháp
            {!! Form::radio('status', '1',false) !!} Lập đơn
        </td>
    </tr>
    <button onclick="Save()" type="button"> Lưu </button> &nbsp;
    <button onclick="Export()" type="button"> Export </button>
</div>
{!! Form::close() !!}
@section('extra-script')
    <script src="{{ asset('module/shop-ja/assets/jexcel/dist/jexcel.js') }}"></script>
    <script src="{{ asset('module/shop-ja/assets/jsuites/dist/jsuites.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('module/shop-ja/assets/jsuites/dist/jsuites.css') }}" type="text/css" />
    <link rel="stylesheet" href="{{ asset('module/shop-ja/assets/jexcel/dist/jexcel.css') }}" type="text/css" />
    <style>
        .jexcel tbody tr:nth-child(even) {
            background-color: #EEE9F1 !important;
        }
        .cacheAction {
            background-color: green;
            color: #ffffff;
        }
        #spreadsheet > div:first-child{
            padding: 6px 0px 0px 7px;
            border: 1px solid #ccc;
            margin-bottom: 5px;
        }
        .error{
            color: red;
        }
        .jexcel_content::-webkit-scrollbar{
            width: 15px;
            height: 15px;
        }
        .pay-method-oke{
            color: #03a9f4;
        }
    </style>
    <script>
        function formatDate(date, format, utc) {
            var MMMM = ["\x00", "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
            var MMM = ["\x01", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            var dddd = ["\x02", "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
            var ddd = ["\x03", "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];

            function ii(i, len) {
                var s = i + "";
                len = len || 2;
                while (s.length < len) s = "0" + s;
                return s;
            }

            var y = utc ? date.getUTCFullYear() : date.getFullYear();
            format = format.replace(/(^|[^\\])YYYY+/g, "$1" + y);
            format = format.replace(/(^|[^\\])YY/g, "$1" + y.toString().substr(2, 2));
            format = format.replace(/(^|[^\\])Y/g, "$1" + y);

            var M = (utc ? date.getUTCMonth() : date.getMonth()) + 1;
            format = format.replace(/(^|[^\\])MMMM+/g, "$1" + MMMM[0]);
            format = format.replace(/(^|[^\\])MMM/g, "$1" + MMM[0]);
            format = format.replace(/(^|[^\\])MM/g, "$1" + ii(M));
            format = format.replace(/(^|[^\\])M/g, "$1" + M);

            var d = utc ? date.getUTCDate() : date.getDate();
            format = format.replace(/(^|[^\\])DDDD+/g, "$1" + dddd[0]);
            format = format.replace(/(^|[^\\])DDD/g, "$1" + ddd[0]);
            format = format.replace(/(^|[^\\])DD/g, "$1" + ii(d));
            format = format.replace(/(^|[^\\])D/g, "$1" + d);

            var H = utc ? date.getUTCHours() : date.getHours();
            format = format.replace(/(^|[^\\])HH+/g, "$1" + ii(H));
            format = format.replace(/(^|[^\\])H/g, "$1" + H);

            var h = H > 12 ? H - 12 : H == 0 ? 12 : H;
            format = format.replace(/(^|[^\\])hh+/g, "$1" + ii(h));
            format = format.replace(/(^|[^\\])h/g, "$1" + h);

            var m = utc ? date.getUTCMinutes() : date.getMinutes();
            format = format.replace(/(^|[^\\])mm+/g, "$1" + ii(m));
            format = format.replace(/(^|[^\\])m/g, "$1" + m);

            var s = utc ? date.getUTCSeconds() : date.getSeconds();
            format = format.replace(/(^|[^\\])ss+/g, "$1" + ii(s));
            format = format.replace(/(^|[^\\])s/g, "$1" + s);

            var f = utc ? date.getUTCMilliseconds() : date.getMilliseconds();
            format = format.replace(/(^|[^\\])fff+/g, "$1" + ii(f, 3));
            f = Math.round(f / 10);
            format = format.replace(/(^|[^\\])ff/g, "$1" + ii(f));
            f = Math.round(f / 10);
            format = format.replace(/(^|[^\\])f/g, "$1" + f);

            var T = H < 12 ? "AM" : "PM";
            format = format.replace(/(^|[^\\])TT+/g, "$1" + T);
            format = format.replace(/(^|[^\\])T/g, "$1" + T.charAt(0));

            var t = T.toLowerCase();
            format = format.replace(/(^|[^\\])tt+/g, "$1" + t);
            format = format.replace(/(^|[^\\])t/g, "$1" + t.charAt(0));

            var tz = -date.getTimezoneOffset();
            var K = utc || !tz ? "Z" : tz > 0 ? "+" : "-";
            if (!utc) {
                tz = Math.abs(tz);
                var tzHrs = Math.floor(tz / 60);
                var tzMin = tz % 60;
                K += ii(tzHrs) + ":" + ii(tzMin);
            }
            format = format.replace(/(^|[^\\])K/g, "$1" + K);

            var day = (utc ? date.getUTCDay() : date.getDay()) + 1;
            format = format.replace(new RegExp(dddd[0], "g"), dddd[day]);
            format = format.replace(new RegExp(ddd[0], "g"), ddd[day]);

            format = format.replace(new RegExp(MMMM[0], "g"), MMMM[M]);
            format = format.replace(new RegExp(MMM[0], "g"), MMM[M]);

            format = format.replace(/\\(.)/g, "$1");

            return format;
        };
        let ListPayment =[
            "代金引換",
            "銀行振込",
            "決済不要"
        ];
        function getValuePayMethod(val) {
            if(val === "代金引換") return 1;
            if(val === "銀行振込") return 2;
            if(val === "決済不要") return 3;
            return 0;
        }
        let columnsAll = {};
        let session_id = '{!! \Illuminate\Support\Str::random(20) !!}';

        // let onselection = function(instance, x1, y1, x2, y2, origin,columns) {
        //     var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
        //     $("#value-review").val(instance.jexcel.getValue(cellName1)).focus();
        //
        //     $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
        //     console.log(columns);
        // };

        let config = {
            minDimensions:[27,20],
            tableWidth: '100%',
            tableHeight: '100%',
            defaultColWidth: 100,
            tableOverflow: true,
            getTypeColumns:function(){
                return "none";
            },
            contextMenu: function(obj, x, y, e) {
                var items = [];

                if (y == null) {
                    // Insert a new column
                    if (obj.options.allowInsertColumn === true) {
                        items.push({
                            title:obj.options.text.insertANewColumnBefore,
                            onclick:function() {
                                obj.insertColumn(1, parseInt(x), 1);
                            }
                        });
                    }
                    if (obj.options.allowInsertColumn === true) {
                        items.push({
                            title:obj.options.text.insertANewColumnAfter,
                            onclick:function() {
                                obj.insertColumn(1, parseInt(x), 0);
                            }
                        });
                    }

                    // Delete a column
                    if (obj.options.allowDeleteColumn === true) {
                        items.push({
                            title:obj.options.text.deleteSelectedColumns,
                            onclick:function() {
                                obj.deleteColumn(obj.getSelectedColumns().length ? undefined : parseInt(x));
                            }
                        });
                    }

                    // // Rename column
                    // if (obj.options.allowRenameColumn === true) {
                    //     items.push({
                    //         title:obj.options.text.renameThisColumn,
                    //         onclick:function() {
                    //             obj.setHeader(x);
                    //         }
                    //     });
                    // }

                    // Sorting
                    if (obj.options.columnSorting == true) {

                        items.push({ type:'line' });

                        items.push({
                            title:obj.options.text.orderAscending,
                            onclick:function() {
                                obj.orderBy(x, 0);
                            }
                        });
                        items.push({
                            title:obj.options.text.orderDescending,
                            onclick:function() {
                                obj.orderBy(x, 1);
                            }
                        });
                    }
                } else {
                    // Insert new row
                    if (obj.options.allowInsertRow === true) {
                        items.push({
                            title:obj.options.text.insertANewRowBefore,
                            onclick:function() {
                                obj.insertRow(1, parseInt(y), 1);
                            }
                        });

                        items.push({
                            title:obj.options.text.insertANewRowAfter,
                            onclick:function() {
                                obj.insertRow(1, parseInt(y));
                            }
                        });
                    }

                    if (obj.options.allowDeleteRow === true) {
                        items.push({
                            title:obj.options.text.deleteSelectedRows,
                            onclick:function() {
                                obj.deleteRow(obj.getSelectedRows().length ? undefined : parseInt(y));
                            }
                        });
                    }

                    if (x) {
                        if (obj.options.allowComments === true) {
                            items.push({ type:'line' });

                            var title = obj.records[y][x].getAttribute('title') || '';

                            items.push({
                                title: title ? obj.options.text.editComments : obj.options.text.addComments,
                                onclick:function() {
                                    obj.setComments([ x, y ], prompt(obj.options.text.comments, title));
                                }
                            });

                            if (title) {
                                items.push({
                                    title:obj.options.text.clearComments,
                                    onclick:function() {
                                        obj.setComments([ x, y ], '');
                                    }
                                });
                            }
                        }
                    }
                }
                // // Line
                // items.push({ type:'line' });
                // // Save

                return items;
            },
        };

        let datacache = {!! json_encode($excels_data,JSON_UNESCAPED_UNICODE ) !!}
        let dataproduct = {!! json_encode($products,JSON_UNESCAPED_UNICODE ) !!}
        let datamodel = {!! isset($model)?json_encode($model->detail,JSON_UNESCAPED_UNICODE ):'{}' !!};
        let token = '{!! isset($model)?$model->token:"" !!}';
        function setDefaultValue(i,columns, max) {
            if(columns[i].hasOwnProperty('value') && typeof(columns[i].value) == "object"){
                let self = null;
                if(columns[i].value[0] === "product"){
                    if(columns[i].value[1] === 'this'){
                        self = columns[i];
                    } else if(columns.hasOwnProperty(columns[i].value[1])){
                        self = columns[columns[i].value[1]];
                    }

                    if(self != null){
                        if(self.hasOwnProperty(columns[i].value[2])){
                            let v = self[columns[i].value[2]];
                            if(v){
                                if(columns[i].value.length > 3){
                                    v = v[columns[i].value[3]];
                                }
                                if(v && columns[i].value.length > 4){
                                    v = v[columns[i].value[4]];
                                }
                                if(v && columns[i].value.length > 5){
                                    v = v[columns[i].value[5]];
                                }
                                if(v)
                                    return [true,v];
                            }

                        }
                    }
                }else  if(columns[i].value[0] === "date"){
                    //['date','this','options','format'],

                    self = columns[i];
                    if(self != null){
                        console.log(self);
                        if(self.hasOwnProperty('options') && self.options.hasOwnProperty('format')){
                            console.log(formatDate(new Date(), self.options.format));
                            return [true,formatDate(new Date(), self.options.format)];
                        }
                    }
                }
            }else if(columns[i].hasOwnProperty('value')){
                return [true,columns[i].value];
            }
            return [false,""];
        }
        function InitData(data,config,columns_index) {
            let _data = [];
            let n = data.length;
            for(let i=0; i < config.minDimensions[1] ; i++){
                if(i < n)
                    _data[i] = data[i];
                else{
                    _data[i] = [];
                }
                for(let j=0 ; j < config.minDimensions[0] ; j++){

                    if(columns_index.length < config.minDimensions[0]){
                        if(columns_index[j]){
                            if(columns_index[j].hasOwnProperty('value')){

                                if(typeof(_data[i][j]) === "undefined"){
                                    _data[i][j] = columns_index[j].value;
                                }else{
                                    if(typeof(_data[i][j]) == "string" && _data[i][j].length === 0){
                                        _data[i][j] = columns_index[j].value;
                                    }
                                }
                            }
                        }
                        // if(columns_index[j].hasOwnProperty('value')){
                        //     if(columns_index[j]){
                        //         if(typeof(_data[i][j]) === "undefined"){
                        //             _data[i][j] = columns_index[j].value;
                        //         }else{
                        //             if(typeof(_data[i][j]) == "string" && _data[i][j].length === 0){
                        //                 _data[i][j] = columns_index[j].value;
                        //             }else{
                        //                 _data[i][j] = columns_index[j].value;
                        //             }
                        //         }
                        //     }else{
                        //         if(j > _data[i].length ||  typeof(_data[i][j]) === "undefined"){
                        //             _data[i][j] =  columns_index[j].value;
                        //         }
                        //     }
                        // }
                    }else{
                        // if(columns_index[j].hasOwnProperty('value')){
                        //     _data[i][j] = columns_index[j].value;
                        // }else{
                        //     _data[i][j] = "";
                        // }
                    }
                }
            }
            return _data;
        }
        function FUKUI(config) {
            let  sheetName  =  'FUKUI';

            let data = [];
            if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){
                if(datacache[sheetName].data.token === token){
                    data = datacache[sheetName].data.data;
                }
            }
            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){
                data = datamodel[sheetName];
            }
            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};

            let columns = {
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",

                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY' },
                    width:'100px',
                    value:['date','now']
                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    value:'19:00～21:00',
                    source:['8:00 ~ 12:00','12:00～14:00','14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00','20:00～21:00'],
                    width:'150px',
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',

                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',

                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',

                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',

                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                },
                order_total_price_buy:{
                    title: '代引き請求金額',//P tổng Giá bán
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    width:'100px',
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    value:['product','this','source',0,'id'],
                    width:'100px',
                },
                // price:{
                //     title: '単価',//J Giá nhập
                //     type: 'numeric',
                //     width:'100px',
                //     key:"demo",
                // },
                order_total_price:{
                    title: '仕入金額',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                    value:1
                },
                // order_ship_cou:{
                //     title: '代引き手数料',//P Phí giao hàng
                //     type: 'numeric',
                //     width:'100px',
                //     key:"demo",
                // },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',

                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',

                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };
            columnsAll[sheetName] = columns;

            let index = 0;
            for(let i in columns){
                columns[i].title =i+"[ "+jexcel.getColumnName(index)+index+" ]-"+columns[i].title + "-";
                columns[i].key = i;
                columns[i].index = index++;
                let v = setDefaultValue(i,columns);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }


            }
            function update(instance, cell, c, r, value) {
                let data = {
                    count:value.hasOwnProperty('count')?value.count:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r])),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };
                let valRow = instance.jexcel.getRowData(r);

                if(value.hasOwnProperty('count')){
                    data.count = value.count;
                }else{
                    let val = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r]));
                    if(val.length === 0 ){
                        val = 1;
                    }
                    data.count = val;
                }
                let total_price_buy = 0;
                let total_price = 0;
                if(dropdown.hasOwnProperty(data.id)){
                    let product = dropdown[data.id];

                    total_price_buy =  parseFloat(product.data.price_buy) * data.count;
                    total_price =  parseFloat(product.data.price) * data.count;

                    if(valRow[columns.order_total_price.index].length === 0){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price_buy);

                    }else{
                        total_price_buy =  parseInt(valRow[columns.order_total_price_buy.index]);
                    }
                    if(valRow[columns.order_total_price_buy.index].length  === 0){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price);
                    }else{
                        total_price = parseInt(valRow[columns.order_total_price_buy.index]);
                    }
                }
                function setInterest(interest){
                    if(total_price_buy ===0 || total_price ==0){ return;}

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_price.index, r]),(function () {
                        return total_price_buy - total_price - interest;
                    })());
                }
                if(data.province.length > 0 ){
                    if(value.hasOwnProperty('price_ship')){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),value.price_ship);
                        setInterest(value.price_ship);
                    }else{
                        $.ajax({
                            type: "POST",
                            url:"{{ route('backend:shop_ja:order:excel:store') }}",
                            data:{act:'ship',data:data} ,
                            success: function (data) {
                                if(data && data.length > 0){
                                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),data[0].data.price_ship);
                                    setInterest(data[0].data.price_ship);
                                }

                            },
                        });
                    }
                }else{
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),-1 );
                }
            }
            let columns_index = Object.values(columns);

            let _data = InitData(data,config,columns_index);
            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:columns_index,
                data: _data,
                onload:function(instance, option){

                    console.log(instance);
                    console.log(option);


                },
                onselection:function (instance, x1, y1, x2, y2, origin) {
                    var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
                    let val = instance.jexcel.getValue(cellName1);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    console.log(val);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                        $html = $("<div>");
                        $("#zoe-dropdown-review").show().html($html);

                        jSuites.dropdown($html[0], {
                            data:columns_index[x1].source,
                            autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                            width:'100%',
                        }).setValue(val);

                    }else{
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").show().val(val).focus();
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);
                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';
                    // if(columns_index[col].hasOwnProperty('value')){
                    //     let vvv = instance.jexcel.setValue(jexcel.getColumnNameFromId([col, row]),columns_index[col].value);
                    //     if(vvv.length == 0 ){
                    //         instance.jexcel.setValue(jexcel.getColumnNameFromId([col, row]),{set:columns_index[col].value});
                    //     }
                    // }
                    if(columns.id.index === c){
                        let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));
                        if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');

                        let value = instance.jexcel.getRowData(row);
                        let count = 0;
                        for(let k in instance.jexcel.rows){
                            let _val  = instance.jexcel.getRowData(k);
                            if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                                count++;
                            }
                        }
                        if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');
                        if((value[columns.product_id.index].length > 0 || value[columns.product_name.index].length > 0 ) && value[columns.count.index].length === 0  ){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, row]),1);
                        }
                        let vvv = getValuePayMethod(value[columns.payMethod.index]);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }

                    }
                },
                onpaste:function(){

                },
                onbeforepaste:function(){

                },
                onbeforechange:function(instance, cell, c, r, value){
                    console.log("onbeforechange:"+value);
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);

                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            update(instance, cell, c, r,{
                                id:dropdown[value].data.id
                            });
                        }
                    }
                    else if(c === columns.count.index){
                        update(instance, cell, c, r,{
                            count:parseInt(value),
                        });
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{
                            province:value,
                        });
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },
                onafterchanges:function(instance, cell, c, r, value){
                   console.log("onafterchanges:"+value);
                },

            };
        }
        function KOGYJA() {
            let  sheetName  =  'KOGYJA';

            let data = [];
            if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){
                if(datacache[sheetName].data.token === token){
                    data = datacache[sheetName].data.data;
                }
            }
            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){
                data = datamodel[sheetName];
            }
            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};
            let index = 0;
            let columns = {
                status: {
                    type: 'checkbox',
                    title:'Status'
                },
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",
                    key:"demo",
                },
                timeCreate:{
                    title: '注文日',//A ngày đặt hàng
                    type: 'calendar',
                    width:'100px',
                    options: { format:'DD/MM/YYYY' },
                    value:['date','now']
                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                    value:"070-1398-2234",
                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',
                    key:"demo",
                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',
                    key:"demo",
                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',
                    key:"demo",
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',
                    key:"demo",
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    width:'100px',
                    value:['product','product_name','source',0,'id'],
                },
                price:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                   value:1
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY' },
                    width:'100px',
                    value:['date','now'],
                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    source:['14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00'],
                    width:'150px',
                    value:['product','this','source',3],
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_total_price:{
                    title: '仕入金額',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_total_price_buy:{
                    title: '代引き請求金額',//P Giá bán
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_ship_cou:{
                    title: '代引き手数料',//P Phí giao hàng
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };
            columnsAll[sheetName] = columns;

            for(var i in columns){
                columns[i].index = index;
                columns[i].title =i+"[ "+jexcel.getColumnName(index)+" ]-"+columns[i].title+"-"+index;
                columns[i].key = i;
                let v = setDefaultValue(i,columns);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }
                index++;
            }

            function update_count(instance, cell, c, r, value) {
                let _r1 = r;
                let _count = 0;
                let rowInfo = -1;
                let rowTotal = -1;
                do{
                    let _data =  instance.jexcel.getRowData(_r1);
                    if(_data[columns.count.index] > 0 && _data[columns.product_id.index]>0){
                        _count+= parseInt(_data[columns.count.index]);
                    }
                    if(_data[columns.fullname.index].length > 0){
                        rowInfo = _r1;
                        break;
                    }
                    _r1--;
                }while (_r1 >= 0);
                console.log(_count);
                let _r2 = parseInt(r)+1;
                console.log(_r2);
                while (_r2 < instance.jexcel.rows.length){
                    let _data =  instance.jexcel.getRowData(_r2);
                    if(_data[columns.count.index] > 0 && _data[columns.product_id.index]>0){
                        _count+= parseInt(_data[columns.count.index]);
                    }
                    if(_data[columns.fullname.index].length > 0){
                        break;
                    }
                    _r2++;
                }
                if(rowInfo!==-1){
                    let v = 0;
                    if(_count <= 5){
                        v = 37;
                    }else if(_count <= 10){
                        v = 74;
                    }else if(_count > 10){
                        v = 142;
                    }
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, rowInfo]),v);
                }
            }
            function update(instance, cell, c, r, value) {
                let data = {
                    count:value.hasOwnProperty('count')?value.count:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r])),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };
                let total_price_buy =  0;
                let total_price =  0;

                if(dropdown.hasOwnProperty(data.id)){
                    let product = dropdown[data.id];
                    total_price_buy =  parseFloat(product.data.price_buy) * data.count;
                    total_price =  parseFloat(product.data.price) * data.count;
                    // instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price_buy);
                    // instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price);
                }
                function setInterest(interest){
                    if(total_price_buy ===0 || total_price ==0){ return;}
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_price.index, r]),(function () {
                        return total_price_buy - total_price - interest;
                    })());
                }
                if(data.province.length > 0 ){
                    if(value.hasOwnProperty('price_ship')){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),value.price_ship);
                        setInterest(value.price_ship);
                    }else{
                        $.ajax({
                            type: "POST",
                            url:"{{ route('backend:shop_ja:order:excel:store') }}",
                            data:{act:'ship',data:data} ,
                            success: function (data) {
                                if(data && data.length > 0){
                                instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),data[0].data.price_ship);
                                setInterest(data[0].data.price_ship);
                                }
                            },
                        });
                    }
                }else{

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),-11);

                }
            }
            let columns_index = Object.values(columns);
            let _data = InitData(data,config,columns_index);
            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:columns_index,
                data: _data,
                onselection:function (instance, x1, y1, x2, y2, origin) {
                    var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
                    let val = instance.jexcel.getValue(cellName1);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    console.log(val);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                        $html = $("<div>");
                        $("#zoe-dropdown-review").show().html($html);

                        jSuites.dropdown($html[0], {
                            data:columns_index[x1].source,
                            autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                            width:'100%',
                        }).setValue(val);

                    }else{
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").show().val(val).focus();
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);
                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';

                    if(columns.id.index === c){
                        let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));

                        let value = instance.jexcel.getRowData(row);

                        if(value[columns.fullname.index].length > 0 && value[columns.fullname.index]){
                            if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                            else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');
                        }
                        let count = 0;

                        for(let k in instance.jexcel.rows){
                            let _val  = instance.jexcel.getRowData(k);
                            if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                                count++;
                            }
                        }
                        if(value[columns.fullname.index].length > 0 && value[columns.fullname.index]){
                            if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                            else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');
                        }
                        if(value[columns.fullname.index].length > 0 && value[columns.fullname.index]){
                            console.log("END");

                        }
                        let vvv = getValuePayMethod(value[columns.payMethod.index]);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);
                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){

                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.price.index, r]), dropdown[value].data.price);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, r]),1);
                            let _data =  instance.jexcel.getRowData(r);

                            if(_data[columns.fullname.index].length > 0){
                                update(instance, cell, c, r,{
                                    count:1,
                                    id:dropdown[value].data.id
                                });
                            }
                            update_count(instance, cell, c, r, value);
                        }
                    }else if(c === columns.count.index){
                        let _data =  instance.jexcel.getRowData(r);
                        if(_data[columns.fullname.index].length > 0){
                            update(instance, cell, c, r,{
                                count:parseInt(value),
                            });
                        }
                        update_count(instance, cell, c, r, value);
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{
                            province:value,
                        });
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },

            };
        }
        function KURICHIKU() {
            let  sheetName  =  'KURICHIKU';

            let data = [];
            if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){
                if(datacache[sheetName].data.token === token){
                    data = datacache[sheetName].data.data;
                }
            }
            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){
                data = datamodel[sheetName];
            }
            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};
            let index = 0;
            let columns = {
                status: {
                    type: 'checkbox',
                    title:'Status'
                },
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",
                    key:"demo",
                },
                timeCreate:{
                    title: '注文日',//A ngày đặt hàng
                    type: 'calendar',
                    width:'100px',
                    options: { format:'DD/MM/YYYY' },
                    value:['date','now']
                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                    value:"070-1398-2234"
                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',
                    key:"demo",
                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',
                    key:"demo",
                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',
                    key:"demo",
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',
                    key:"demo",
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    width:'100px',
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    width:'100px',
                    value:['product','product_name','source',0,'id'],
                },
                price:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                    value:"1",
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY' },
                    width:'100px',
                    value:['date','now']
                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    source:['8:00 ~ 12:00','14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00'],
                    width:'150px',
                    value:['product','this','source',4]
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_total_price:{
                    title: '仕入金額',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_total_price_buy:{
                    title: '代引き請求金額',//P Giá bán
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_ship_cou:{
                    title: '代引き手数料',//P Phí giao hàng
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_info:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };
            columnsAll[sheetName] = columns;

            for(var i in columns){
                columns[i].index = index;
                columns[i].title =i+"[ "+jexcel.getColumnName(index)+" ]-"+columns[i].title+"-"+index;
                columns[i].key = i;
                let v = setDefaultValue(i,columns);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }
                index++;
            }

            function update(instance, cell, c, r, value) {


                let data = {
                    count:value.hasOwnProperty('count')?value.count:parseFloat(instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r]))),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };

                let total_price_buy =  0;
                let total_price =  0;
                if(dropdown.hasOwnProperty(data.id)){
                    let product = dropdown[data.id];
                    total_price_buy =  parseFloat(product.data.price_buy) * data.count;
                    total_price =  parseFloat(product.data.price) * data.count;

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price_buy);
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price);

                }

                function setInterest(interest){
                    if(total_price_buy ===0 || total_price ==0){ return;}
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_price.index, r]),(function () {
                        return total_price_buy - total_price - interest;
                    })());
                }

                if(data.province.length > 0 ){
                    if(value.hasOwnProperty('price_ship')){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),value.price_ship);
                        setInterest(value.price_ship);
                    }else{
                        $.ajax({
                            type: "POST",
                            url:"{{ route('backend:shop_ja:order:excel:store') }}",
                            data:{act:'ship',data:data} ,
                            success: function (_data) {
                                if(_data && _data.length > 0){
                                    let price_ship = _data[0].data.price_ship * data.count;
                                    let order_ship_cou = _data[0].data.ship_cou;
                                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),price_ship);
                                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship_cou.index, r]),order_ship_cou);
                                    setInterest(price_ship);
                                }
                            },
                        });
                    }
                }else{
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),-1 );
                }
            }
            let columns_index = Object.values(columns);

            let _data = InitData(data,config,columns_index);
            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:columns_index,
                data:_data,
                onselection:function (instance, x1, y1, x2, y2, origin) {
                    var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
                    let val = instance.jexcel.getValue(cellName1);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    console.log(val);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                        $html = $("<div>");
                        $("#zoe-dropdown-review").show().html($html);

                        jSuites.dropdown($html[0], {
                            data:columns_index[x1].source,
                            autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                            width:'100%',
                        }).setValue(val);

                    }else{
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").show().val(val).focus();
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);
                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';

                    if(columns.id.index === c){
                        let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));
                        if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');

                        let value = instance.jexcel.getRowData(row);

                        let count = 0;
                        for(let k in instance.jexcel.rows){
                            let _val  = instance.jexcel.getRowData(k);
                            if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                                count++;
                            }

                        }

                        if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');
                        let vvv = getValuePayMethod(value[columns.payMethod.index]);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);
                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.price.index, r]),dropdown[value].data.price);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, r]),1);
                            update(instance, cell, c, r,{
                                count:1,
                                id:dropdown[value].data.id
                            });
                        }
                    }else if(c === columns.count.index){
                        update(instance, cell, c, r,{
                            count:parseInt(value),
                        });
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{
                            province:value,
                        });
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },

            };
        }
        function OHGA() {
            let  sheetName  =  'OHGA';
            let data = [];
            if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){
                if(datacache[sheetName].data.token === token){
                    data = datacache[sheetName].data.data;
                }
            }
            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){
                data = datamodel[sheetName];
            }
            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};
            let index = 0;
            let columns = {
                status: {
                    type: 'checkbox',
                    title:'Status'
                },
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",
                    key:"demo",
                },
                timeCreate:{
                    title: '注文日',//A ngày đặt hàng
                    type: 'calendar',
                    width:'100px',
                    options: { format:'DD/MM/YYYY' },
                    value:['date','now']
                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                    value:"070-1398-2234",
                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',
                    key:"demo",
                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',
                    key:"demo",
                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',
                    key:"demo",
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',
                    key:"demo",
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    width:'100px',
                    read:true,
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    width:'140px',
                    value:['product','this','source',0,'id']
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                    value:1
                },
                price:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                price_buy:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY'},
                    value:['date','now'],
                    width:'100px',

                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    source:['8:00 ~ 12:00','14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00'],
                    value:['product','this','source',4],
                    width:'150px',
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                    value:0
                },
                order_total_price:{
                    title: 'Tổng giá nhập',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                price_buy_sale:{
                    title: 'Tăng Giảm',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:0,
                },
                order_total_price_buy:{
                    title: 'Total Bán',//P Giá bán
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                order_ship_cou:{
                    title: '代引き手数料',//P Phí giao hàng
                    type: 'numeric',
                    width:'100px',
                    value:330
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                    value:0
                },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                },
                order_info:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };
            columnsAll[sheetName] = columns;

            for(var i in columns){
                columns[i].index = index;
                columns[i].title =i+"[ "+jexcel.getColumnName(index)+" ]-"+columns[i].title+"-"+index;
                columns[i].key = i;
                let v = setDefaultValue(i,columns);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }
                index++;
            }

            function update(instance, cell, c, r, value) {
                let data = {
                    count:value.hasOwnProperty('count')?value.count:parseInt(instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r]))),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };

                let total_price_buy =  0;
                let total_price =  0;

                let valueRow =  instance.jexcel.getRowData(r);

                if(dropdown.hasOwnProperty(data.id)){

                    let product = dropdown[data.id];
                    let price_buy = 0;
                    let price = 0;
                    if(valueRow[columns.price_buy.index] > 0){
                        price_buy = valueRow[columns.price_buy.index];
                    }else{
                        price_buy = product.data.price_buy;
                    }
                    if(valueRow[columns.price.index] > 0 ){
                        price = valueRow[columns.price.index];
                    }else{
                        price = product.data.price;
                    }

                    total_price =  parseFloat(price) * data.count;

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price);


                    console.log("price_buy:"+ price_buy);

                    console.log("count:"+data.count);

                    console.log( valueRow[columns.order_ship_cou.index]);
                    console.log( valueRow[columns.order_ship.index]);
                    console.log( valueRow[columns.price_buy_sale.index]);

                    total_price_buy =
                        parseFloat(price_buy) *
                        parseFloat(data.count) +
                        parseFloat(valueRow[columns.order_ship_cou.index]) +
                        parseFloat(valueRow[columns.order_ship.index]) +
                        parseFloat(valueRow[columns.price_buy_sale.index]);

                    console.log(typeof total_price_buy);
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price_buy );
                }
                function setInterest(interest,order_ship_cou){

                    if(total_price_buy ===0 || total_price == 0){ return;}

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_price.index, r]),(function () {
                        return total_price_buy - total_price - interest - order_ship_cou;
                    })());
                }
                if(value.hasOwnProperty('lock') && value.lock.indexOf(columns.order_ship.index)){
                    $.ajax({
                        type: "POST",
                        url:"{{ route('backend:shop_ja:order:excel:store') }}",
                        data:{act:'ship',data:data} ,
                        success: function (data) {
                            console.log(data);
                            if(data && data.length >0){
                                instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),data[0].data.price_ship* data.count);
                                setInterest(data[0].data.price_ship * data.count,parseInt(valueRow[columns.order_ship_cou.index]));
                            }

                        },
                    });
                } else{


                    setInterest(parseInt(valueRow[columns.order_ship.index]),parseInt(valueRow[columns.order_ship_cou.index]));
                }
            }

            let columns_index = Object.values(columns);

            let _data = InitData(data,config,columns_index);
            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:columns_index,
                data:_data,
                onselection:function (instance, x1, y1, x2, y2, origin) {
                    var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
                    let val = instance.jexcel.getValue(cellName1);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    console.log(val);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                        $html = $("<div>");
                        $("#zoe-dropdown-review").show().html($html);

                        jSuites.dropdown($html[0], {
                            data:columns_index[x1].source,
                            autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                            width:'100%',
                        }).setValue(val);

                    }else{
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").show().val(val).focus();
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);
                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';

                    if(columns.id.index === c){
                        let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));
                        if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');
                        let value = instance.jexcel.getRowData(row);
                        let count = 0;

                        for(let k in instance.jexcel.rows){
                            let _val  = instance.jexcel.getRowData(k);
                            if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                                count++;
                            }
                        }

                        if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');

                        let vvv = getValuePayMethod(value[columns.payMethod.index]);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();

                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }

                    }
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);
                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.price.index, r]),dropdown[value].data.price);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, r]),1);
                            update(instance, cell, c, r,{
                                count:1,
                                id:dropdown[value].data.id
                            });
                        }
                    }else if(c === columns.count.index ||
                        c === columns.price_buy_sale.index ||
                        c === columns.order_ship.index ||
                        c === columns.order_ship_cou.index
                    ){
                        update(instance, cell, c, r,{

                        });
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{"lock":[]});
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship_cou.index, r]), 0);
                        }else{
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship_cou.index, r]), 330);
                        }


                    }
                },
            };
        }
        function YAMADA() {
            let  sheetName  =  'YAMADA';

            let data = [];

            {{--if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){--}}

                {{--if(datacache[sheetName].data.token === token ||  "{!! isset($model)?"edit":"create" !!}" == "create"){--}}
                    {{--data = datacache[sheetName].data.data;--}}
                    {{--console.log("cache")--}}
                {{--}--}}
            {{--}--}}

            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){

                data = datamodel[sheetName];
            }

            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};
            let index = 0;

            let columns = {
                status: {
                    type: 'checkbox',
                    title:'Status'
                },
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",
                    key:"demo",
                },
                timeCreate:{
                    title: '注文日',//A ngày đặt hàng
                    type: 'calendar',
                    width:'100px',
                    options: { format:'DD/MM/YYYY' },
                    value:['date','now']
                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                    value:"070-1398-2234",
                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',
                    key:"demo",
                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',
                    key:"demo",
                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',
                    key:"demo",
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',
                    key:"demo",
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    width:'100px',
                    read:true,
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    width:'140px',
                    value:['product','this','source',0,'id']
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                    value:1
                },
                price:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                price_buy:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY'},
                    value:['date','now'],
                    width:'100px',

                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    source:['8:00 ~ 12:00','14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00'],
                    value:['product','this','source',4],
                    width:'150px',
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                    value:0
                },
                order_total_price:{
                    title: 'Tổng giá nhập',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                price_buy_sale:{
                    title: 'Tăng Giảm',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:0,
                },
                order_total_price_buy:{
                    title: 'Total Bán',//P Giá bán
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                order_ship_cou:{
                    title: '代引き手数料',//P Phí giao hàng
                    type: 'numeric',
                    width:'100px',
                    value:0
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                    value:0
                },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                },
                order_info:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };

            columnsAll[sheetName] = columns;

            for(var i in columns){
                columns[i].index = index;
                columns[i].title = i+"[ "+jexcel.getColumnName(index)+" ]-"+columns[i].title+"-"+index;
                columns[i].key = i;
                let v = setDefaultValue(i,columns);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }
                index++;
            }
            function update(instance, cell, c, r, value) {
                let data = {
                    count:value.hasOwnProperty('count')?value.count:parseInt(instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r]))),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };

                let total_price_buy =  0;
                let total_price =  0;

                let valueRow =  instance.jexcel.getRowData(r);
                console.log(valueRow);
                if(dropdown.hasOwnProperty(data.id)){

                    let product = dropdown[data.id];
                    let price_buy = 0;
                    let price = 0;
                    if(valueRow[columns.price_buy.index] > 0){
                        price_buy = valueRow[columns.price_buy.index];
                    }else{
                        price_buy = product.data.price_buy;
                    }
                    if(valueRow[columns.price.index] > 0 ){
                        price = valueRow[columns.price.index];
                    }else{
                        price = product.data.price;
                    }
                    total_price =  parseFloat(price) * data.count;

                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price);

                    total_price_buy =
                        parseFloat(price_buy) *
                        data.count +
                        parseFloat(valueRow[columns.order_ship_cou.index]) +
                        parseFloat(valueRow[columns.order_ship.index]) +
                        parseFloat(valueRow[columns.price_buy_sale.index]);
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price_buy );
                }
                function setInterest(interest,order_ship_cou){
                    if(total_price_buy ===0 || total_price == 0){ return;}
                    let a = (parseInt(total_price_buy) - parseInt(total_price) - parseInt(interest) - parseInt(order_ship_cou));
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_price.index, r]),a);
                }
               if(value.hasOwnProperty('lock') && value.lock.indexOf(columns.order_ship.index)){
                   $.ajax({
                       type: "POST",
                       url:"{{ route('backend:shop_ja:order:excel:store') }}",
                       data:{act:'ship',data:data} ,
                       success: function (data) {
                           if(data && data.length >0){
                               instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),data[0].data.price_ship);
                               setInterest(data[0].data.price_ship,parseInt(valueRow[columns.order_ship_cou.index]));
                           }
                       },
                   });
                } else{
                   console.log(valueRow);
                    setInterest(parseInt(valueRow[columns.order_ship.index]),parseInt(valueRow[columns.order_ship_cou.index]));
                }
            }

            let columns_index = Object.values(columns);

            let _data = InitData(data,config,columns_index);

            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:Object.values(columns),
                data:_data,
                onselection:function (instance, x1, y1, x2, y2, origin) {

                    var cellName1 = jexcel.getColumnNameFromId([columns_index[x1].index, y1]);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    let val = instance.jexcel.getValue(cellName1);
                    console.log({"x":x1-1,y:y1});
                    console.log(val);
                    console.log(columns_index[x1]);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                       $html = $("<div>");
                       $("#zoe-dropdown-review").show().html($html);

                       jSuites.dropdown($html[0], {
                           data:columns_index[x1].source,
                           autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                           width:'100%',
                           onchange:function (el, a, oldValue, Value) {
                                console.log(Value);
                               instance.jexcel.setValue(jexcel.getColumnNameFromId([x1, y1]), Value);
                           },
                       }).setValue(val);

                    }else{
                        $("#value-review").show().val("");
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").prop("disabled",false );
                        if(columns_index[x1] && columns_index[x1].type === "text"){
                            if(columns_index[x1].hasOwnProperty('read')){
                                $("#value-review").prop( "disabled", true );
                            }
                        }
                        $("#value-review").show().val(val);
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);

                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';

                    if(columns.id.index === c){
                       let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));
                       if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                       else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');

                       let value = instance.jexcel.getRowData(row);

                       let count = 0;
                       for(let k in instance.jexcel.rows){
                          let _val  = instance.jexcel.getRowData(k);
                          if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                              count++;
                          }

                       }
                        if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');
                        let vvv = getValuePayMethod(value[columns.payMethod.index]);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);
                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.price.index, r]),dropdown[value].data.price);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, r]),1);
                            update(instance, cell, c, r,{
                                count:1,
                                id:dropdown[value].data.id
                            });
                        }
                    }else if(c === columns.count.index ||
                        c === columns.price_buy_sale.index ||
                        c === columns.order_ship.index ||
                        c === columns.order_ship_cou.index
                    ){
                        update(instance, cell, c, r,{

                        });
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{"lock":[]});
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');

                        }
                    }
                },

            };
        }
        function AMAZON() {
            let  sheetName  =  'AMAZON';

            let data = [];
            if(datacache.hasOwnProperty(sheetName) &&  datacache[sheetName].data.data.length > 0){
                if(datacache[sheetName].data.token === token){
                    data = datacache[sheetName].data.data;
                }
            }
            if(data.length === 0 && datamodel.hasOwnProperty(sheetName)){
                data = datamodel[sheetName];
            }
            let dropdown = dataproduct.hasOwnProperty(sheetName)?dataproduct[sheetName]:{};
            let index = 0;

            let columns = {
                status: {
                    type: 'checkbox',
                    title:'Status'
                },
                image:{
                    title:'Image',
                    type:'image',
                    width:"50px",
                    key:"demo",
                },
                timeCreate:{
                    title: '注文日',//A ngày đặt hàng
                    type: 'calendar',
                    width:'100px',
                    options: { format:'DD/MM/YYYY' },
                    value:['date','now']
                },
                payMethod:{
                    title: '支払区分',//B Phương thức thanh toán
                    type:'dropdown',
                    source:[
                        "代金引換",
                        "銀行振込",
                        "決済不要",
                    ],
                    width:'130px',
                    value:['product','this','source',0],
                },
                phone:{
                    title: '配送先電話番号',//C Số điện thoại
                    type: 'text',
                    width:'100px',
                    value:"070-1398-2234",
                },
                zipcode:{
                    title: '配送先郵便番号',//D Mã bưu điện
                    type: 'text',
                    width:'60px',
                    key:"demo",
                },
                province:{
                    title: '配送先都道府県',//E Tỉnh/TP
                    type: 'text',
                    width:'200px',
                    key:"demo",
                },
                address:{
                    title: '配送先住所',//F Địa chỉ giao hàng
                    type: 'text',
                    width:'250px',
                    key:"demo",
                },
                fullname:{
                    title: '配送先氏名',//G Họ tên người nhận
                    type: 'text',
                    width:'150px',
                    key:"demo",
                },
                product_id:{
                    title: '品番',//H Mã SP
                    type: 'text',
                    width:'100px',
                    read:true,
                    value:['product','product_name','source',0,'id'],
                },
                product_name:{
                    title: '商品名',//I Tên SP
                    type:'dropdown',
                    source:Object.values(dropdown),
                    autocomplete:true,
                    width:'140px',
                    value:['product','this','source',0,'id']
                },
                price:{
                    title: '単価',//J Giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                count:{
                    title: '数量',//K SL
                    type: 'numeric',
                    width:'100px',
                    value:1
                },
                order_date:{
                    title: '到着希望日',//L Ngày nhận
                    type:'calendar',
                    options: { format:'DD/MM/YYYY'},
                    value:['date','now'],
                    width:'100px',

                },
                order_hours:{
                    title: '配送希望時間帯',//M Giờ nhận
                    type: 'dropdown',
                    source:['8:00 ~ 12:00','14:00～16:00','16:00～18:00','18:00～20:00','19:00～21:00'],
                    value:"19:00～21:00",
                    width:'150px',
                    key:"demo",
                },
                order_ship:{
                    title: '別途送料',//N Phí ship
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_total_price:{
                    title: '仕入金額',//O Tổng giá nhập
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price'],
                },
                order_total_price_buy:{
                    title: '代引き請求金額',//P Giá bán
                    type: 'numeric',
                    width:'100px',
                    value:['product','product_name','source',0,'data','price_buy'],
                },
                order_ship_cou:{
                    title: '代引き手数料',//P Phí giao hàng
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_price:{
                    title: '追跡番号',//P Lợi nhuận
                    type: 'numeric',
                    width:'100px',
                    key:"demo",
                },
                order_tracking:{
                    title: '振込み情報',//T Mã tracking
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_link:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                order_info:{
                    title: '振込み情報',//T Thông tin chuyển khoản
                    type: 'text',
                    width:'100px',
                    key:"demo",
                },
                id:{
                    title: 'ID',//T
                    type: 'text',
                    width:'100px',
                },
            };

            columnsAll[sheetName] = columns;

            for(var i in columns){
                columns[i].index = index;
                columns[i].title =i+"[ "+jexcel.getColumnName(index)+" ]-"+columns[i].title+"-"+index;
                columns[i].key = i;
                let v = setDefaultValue(i,columns);
                console.log(v);
                if(v[0]){
                    columns[i].value = v[1];
                }else{
                    delete columns[i].value;
                }
                index++;
            }

            function update(instance, cell, c, r, value) {
                let data = {
                    count:value.hasOwnProperty('count')?value.count:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.count.index, r])),
                    id:value.hasOwnProperty('id')?value.id:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.product_id.index, r])),
                    province:value.hasOwnProperty('province')?value.province:instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.province.index, r])),
                };
                if(dropdown.hasOwnProperty(data.id)){
                    let product = dropdown[data.id];
                    let total_price_buy =  parseFloat(product.data.price_buy) * data.count;
                    let total_price =  parseFloat(product.data.price) * data.count;
                    let order_ship = value.hasOwnProperty('order_ship')?value.order_ship:parseFloat(instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, r])));
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price.index, r]), total_price_buy);
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_total_price_buy.index, r]), total_price);
                    instance.jexcel.setValue((function () {
                        return 0;
                    })());
                }
                if(data.province.length > 0 ){
                    if(value.hasOwnProperty('price_ship')){
                        instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),value.price_ship);
                    }else{
                        $.ajax({
                            type: "POST",
                            url:"{{ route('backend:shop_ja:order:excel:store') }}",
                            data:{act:'ship',data:data} ,
                            success: function (data) {
                                if(data && data.length > 0){
                                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),data[0].data.price_ship);
                                }

                            },
                        });
                    }
                }else{
                    instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.order_ship.index, r]),-1 );
                }
            }

            let columns_index = Object.values(columns);

            let _data = InitData(data,config,columns_index);

            return {
                sheetName:sheetName,
                rowResize:true,
                columnDrag:true,
                columns:columns_index,
                data: _data,
                onselection:function (instance, x1, y1, x2, y2, origin) {
                    var cellName1 = jexcel.getColumnNameFromId([x1, y1]);
                    let val = instance.jexcel.getValue(cellName1);
                    $("#col-row-review").data({"x":x1,y:y1}).val(cellName1);
                    if(columns_index[x1] && columns_index[x1].type === "dropdown"){
                        $("#value-review").hide();
                        $html = $("<div>");
                        $("#zoe-dropdown-review").show().html($html);
                        jSuites.dropdown($html[0], {
                            data:columns_index[x1].source,
                            autocomplete: columns_index[x1].hasOwnProperty('autocomplete'),
                            width:'100%',
                        }).setValue(val);
                    }else{
                        $("#zoe-dropdown-review").hide();
                        $("#value-review").show().val(val).focus();
                    }
                },
                updateTable: function (instance, cell, col, row, val, id) {
                    let c = parseInt(col);
                    if (c === columns.image.index && val.length>0) {
                        cell.innerHTML = '<img src="' + val + '" style="width:20px;height:20px">';
                    }
                    cell.style.overflow = 'hidden';

                    if(columns.id.index === c){
                        let v = instance.jexcel.getValue(jexcel.getColumnNameFromId([columns.order_ship.index, row]));
                        if(v == -1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.province.index, row])).classList.remove('error');

                        let value = instance.jexcel.getRowData(row);

                        let count = 0;
                        for(let k in instance.jexcel.rows){
                            let _val  = instance.jexcel.getRowData(k);
                            if(value[columns.fullname.index].length > 0 && value[columns.fullname.index] === _val[columns.fullname.index]){
                                count++;
                            }
                        }
                        if(count > 1) instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.add('error');
                        else instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.fullname.index, row])).classList.remove('error');

                        let vvv = getValuePayMethod(value[columns.payMethod.index]);

                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, row]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(vvv === 2){
                            parent.addClass('pay-method-oke');
                        }

                    }
                },
                onchange:function(instance, cell, c, r, value) {
                    c = parseInt(c);
                    if (c === columns.product_name.index) {
                        if(dropdown[value] && dropdown[value].hasOwnProperty('data')){
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.product_id.index, r]), dropdown[value].data.id);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.price.index, r]),dropdown[value].data.price);
                            instance.jexcel.setValue(jexcel.getColumnNameFromId([columns.count.index, r]),1);

                            update(instance, cell, c, r,{
                                count:1,
                                id:dropdown[value].data.id
                            });
                        }
                    }else if(c === columns.count.index){
                        update(instance, cell, c, r,{
                            count:parseInt(value),
                        });
                    }else if(c === columns.province.index){
                        update(instance, cell, c, r,{
                            province:value,
                        });
                    }else if(c === columns.payMethod.index){
                        let v = getValuePayMethod(value);
                        let parent = $(instance.jexcel.getCell(jexcel.getColumnNameFromId([columns.payMethod.index, r]))).parent();
                        parent.removeClass('pay-method-oke');
                        if(v === 2){
                            parent.addClass('pay-method-oke');
                        }
                    }
                },

            };
        }
        var sheets = [
            // Object.assign(AMAZON(config),config ),
            // Object.assign(FUKUI(config),config),
            // Object.assign(KOGYJA(config),config),
            // Object.assign(KURICHIKU(config),config),
            Object.assign(OHGA(config),config),
            Object.assign(YAMADA(config),config ),
        ];
        let spreadsheet =  document.getElementById('spreadsheet');
        let worksheets = jexcel.tabs(spreadsheet, sheets);

        setInterval(function () {
         //   Save(true);
        },5000);
        $(document).ready(function () {
            let col_row_review = $("#col-row-review");
            $("#value-review").on("input", function(){
                console.log($(this).val());
                let col_row = col_row_review.data();
                if(col_row.hasOwnProperty('x') && col_row.hasOwnProperty('y')){
                    let _spreadsheet = document.getElementById('spreadsheet').children[0].querySelector('.selected');
                    let  worksheet = _spreadsheet.getAttribute('data-spreadsheet');

                    let data = spreadsheet.jexcel[worksheet].options.data;
                    let name = _spreadsheet.textContent;

                    spreadsheet.jexcel[worksheet].setValue(jexcel.getColumnNameFromId([col_row.x, col_row.y]), $(this).val());
                }
            }).focus(function() {
                console.log("in");
                console.log(col_row_review.data());
            }).focusout(function(){
                console.log("out");
                console.log();



            });
        });
       function Save(status) {
            if(status === true){
                let _spreadsheet = document.getElementById('spreadsheet').children[0].querySelector('.selected');
                let  worksheet = _spreadsheet.getAttribute('data-spreadsheet');
                let data = spreadsheet.jexcel[worksheet].options.data;
                let name = _spreadsheet.textContent;
                let key = datacache.hasOwnProperty(name)?datacache[name].key:false;
                _spreadsheet.classList.add("cacheAction");
                $.ajax({
                    type: "POST",
                    url:"{{ route('backend:shop_ja:order:excel:store') }}",

                    data:{
                        data:JSON.stringify(data),
                        token:token,
                        act:"cache",key:key,name:name,'id':'{{isset($model)?$model->id:0}}','type':'{{isset($model)?'edit':'create'}}'} ,
                        success: function (data) {
                            console.log(data);
                            _spreadsheet.classList.remove("cacheAction");
                        },
                });
            }else{
                let datas = {};
                $("#spreadsheet .jexcel_tab_link").each(function () {
                    let  worksheet = this.getAttribute('data-spreadsheet');
                    let data = spreadsheet.jexcel[worksheet].options.data;
                    let name = this.textContent;
                    let _columns = [];
                    for(let k in  columnsAll[name] ){
                        _columns.push(k);
                    }
                    datas[name] = {
                        data:data,
                        columns:_columns
                    };
                });
                let form_store = $("#form_store");
                $.ajax({
                    type: "POST",
                    url:"{{ route('backend:shop_ja:order:excel:store') }}",
                    data:{
                        datas:JSON.stringify(datas),
                        info: form_store.zoe_inputs('get'),
                        act:"save",
                        token:token,
                        'id':'{{isset($model)?$model->id:0}}',
                        'type':'{{isset($model)?'edit':'create'}}'} ,
                    success: function (data) {
                        if(data.hasOwnProperty('url')){
                             window.location.replace(data.url);
                        }
                    },
                });
            }
       }
       function Export() {
           let _spreadsheet = document.getElementById('spreadsheet').children[0].querySelector('.selected');
           let  worksheet = _spreadsheet.getAttribute('data-spreadsheet');

           let data = spreadsheet.jexcel[worksheet].options.data;
           let name = _spreadsheet.textContent;
           console.log(data);
       }
    </script>
@endsection
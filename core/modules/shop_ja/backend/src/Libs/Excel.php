<?php
namespace  ShopJa\Libs;
use \PhpOffice\PhpSpreadsheet;
use \PhpOffice\PhpSpreadsheet\Style\Border;
use \PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
class Excel{
    public function FUKUI($datas){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->createSheet();
        $spreadsheet->getSheet(1)->setTitle('Sheet2');

        $sheet->setTitle("Sheet1");
        $spreadsheet->getProperties()
            ->setTitle('PHP Download Example')
            ->setSubject('A PHPExcel example')
            ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
            ->setCreator('php-download.com')
            ->setLastModifiedBy('php-download.com');


        $titles = [
            ['A1','グエン様専用注文フォーマット'],
            ['G2','別途送料'],
            ['H2','北海道：800円'],
            ['H2','沖縄：1200円'],
            ['N5','VU THI 様 14 日に 6250  円入金済み'],
        ];
        foreach ($titles as $title){
            $sheet->setCellValue($title[0], $title[1]);
        }
        $titles = [
            '選択','入力','選択','入力','入力','入力','入力','入力','入力','不要','入力','入力','不要','不要','入力'
        ];
        $start = 6;
        foreach($titles as $key=>$value){
            $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
            $sheet->setCellValue($nameCol.$start, $value);
        }

        $styleArray = array(
            'font'  => array(
                'size'  => 9,
                'name' => 'Times New Roman'
            ));
        $style_header = array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb'=>'FFE100'),
            ),
            'borders' => [
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_DOTTED,
                    'color' => array('rgb'=>'000000')
                ),
            ],
            'font' => array(
                'size' => 10
            )
        );
        $sheet->getStyle('B1')->applyFromArray($styleArray);
        $sheet->getStyle('F2')->applyFromArray($styleArray);
        $sheet->getStyle('P2')->applyFromArray(array(
                'font'  => array(
                    'size'  => 9,
                    'name' => 'Times New Roman',
                    'color' => array('rgb' => '0070c0'),
                ),
            )
        );
        $colums = [
            ["支払区分",'payMethod',10,9],//A Phương thức thanh toán
            ["到着希望日",'order_date',15,9],//B ngày giao hàng
            ["配送希望時間帯",'order_hours',15,9],//C Giờ nhận
            ["配送先氏名",'fullname',18,9],//D Họ và tên khách hàng
            ["配送先郵便番号",'zipcode',9,9],// E Mã bưu điện
            ["配送先都道府県",'province',14,9], // F Tỉnh
            ["配送先住所",'address',18,9], // G Địa chỉ giao hàng
            ["配送先電話番号",'phone',10,9], // H Số điện thoại
            ["別途送料",'order_ship',15,9], //I Phí Ship
            ["紹介料",'order_price',15,9],// Lợi nhuận J
            ["仕入金額",'order_total_price_buy',15,9], // Tổng giá đơn hàng K
            ["品番",['product'=>['product_id','code']],10,9], // Mã sản phẩm L
            ["商品名",['product'=>['product_id','title']],18,9], // Tên sản phẩm M
            ["単価",'order_total_price',15,9], // Giá nhập N
            ["数量",'count',15,9], // Số lượng O
        ];
        $start=7;
        $sheet->getStyle('A'.$start.':'.PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).$start)->applyFromArray( $style_header );
        foreach($colums as $key=>$value){
            $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
            $sheet->setCellValue($nameCol.$start, $value[0])->getStyle($nameCol.$start)->applyFromArray(array(
                    'font'  => array(
                        'size'  => $value[3]
                    ),
                )
            );
            if($value[2] > 0){
                $spreadsheet->getActiveSheet()->getColumnDimension($nameCol)->setWidth($value[2]);
            }
        }
        $start++;
        $defaultStart = $start;
        $lastIndex = "";


        $company = "36";

        $orders = [

        ];
        $columns_value = array_flip($datas['columns']);
        $products =  DB::table('shop_product')->get()->keyBy('id')->all();
        foreach ($datas['datas'] as $key=>$values){
            $payMethod = "";
            foreach($colums as $key=>$value){
                $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
                if(is_array($value[1])){
                    if(isset($value[1]['product'])){
                        $conf = $value[1]['product'];
                        $id = (isset($columns_value[$conf[0]])?$values[$columns_value[$conf[0]]]:"");
                        $_val = "";
                        if(isset($products[$id]) && property_exists($products[$id],$conf[1])){
                            $_val = $products[$id]->{$conf[1]};
                        }
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }else if(isset($value[1]['callback']) && isset($value[1]['key'])){
                        $conf = $value[1]['callback'];
                        $_val = call_user_func_array($conf,[$start,(isset($columns_value[$value[1]['key']])?$values[$columns_value[$value[1]['key']]]:""),$nameCol.$start]);
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }
                }else{
                    $v = (isset($columns_value[$value[1]])?$values[$columns_value[$value[1]]]:"");
                    $sheet->setCellValue($nameCol.$start,$v);
                    if($value[1] == "payMethod"){
                        $payMethod = $v;
                    }
                }
            }
            if($payMethod == "銀行振込"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => '0070c0'),
                    ),
                ) );
            }else  if($payMethod == "決済不要"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => 'ff0000'),
                    ),
                ) );
            }
            $start++;
        }

        $sheet->getStyle('K6:K'.$start)->applyFromArray(array(
                'font'  => array(
                    'color' => array('rgb' => 'ff0000'),
                ),
            )
        );
//        $sheet->getStyle('K6:K'.$start)->getStyleArray(array(
//                'fill' => array(
//                    'fillType' => Fill::FILL_SOLID,
//                    'color' => array('rgb'=>'c00010'),
//                ),
//            )
//        );
        // $sheet->setCellValue("J".$start, "=SUM(K".$defaultStart.":K".($start-1).")");
//        $sheet->setCellValue("P".$start, "=SUM(P".$defaultStart.":P".($start-1).")");
//        $sheet->setCellValue("R".$start, "=SUM(R".$defaultStart.":R".($start-1).")");
//        $sheet->setCellValue("Q".$start, "=SUM(Q".$defaultStart.":Q".($start-1).")");

        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path().'/uploads/exports/FUKUI.xlsx');
        return ['link'=>url('/uploads/exports/FUKUI.xlsx')];
    }
    public function OHGA($datas){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->createSheet();
        $spreadsheet->getSheet(1)->setTitle('Sheet2');

        $sheet->setTitle("Sheet1");
        $spreadsheet->getProperties()
            ->setTitle('PHP Download Example')
            ->setSubject('A PHPExcel example')
            ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
            ->setCreator('php-download.com')
            ->setLastModifiedBy('php-download.com');

        $title1 = "株式会社ヤマダ 様 注文フォーマット";
        $title2 = "見本";

        $info = "依頼人名. VO HOANG 様 22日に 7410 円入金済み";

        $sheet->setCellValue('B1', $title1);
        $sheet->setCellValue('F2', $title2);
        $sheet->setCellValue('P2', $info);

        $styleArray = array(
            'font'  => array(
                'size'  => 9,
                'name' => 'Times New Roman'
            ));
        $style_header = array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb'=>'FFE100'),
            ),
            'borders' => [
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_DOTTED,
                    'color' => array('rgb'=>'000000')
                ),
            ],
            'font' => array(
                'size' => 10
            )
        );
        $sheet->getStyle('B1')->applyFromArray($styleArray);
        $sheet->getStyle('F2')->applyFromArray($styleArray);
        $sheet->getStyle('P2')->applyFromArray(array(
                'font'  => array(
                    'size'  => 9,
                    'name' => 'Times New Roman',
                    'color' => array('rgb' => '0070c0'),
                ),
            )
        );
        $sheet->getStyle('A3:T3')->applyFromArray( $style_header );

        $colums = [
            ["注文日",['callback'=>function($index,$date){return date("d", strtotime($date)).'日';},'key'=>'timeCreate'],10,9],//A
            ["支払区分",'payMethod',10,9],//B
            ["配送先電話番号",'phone',10,9],//C
            ["配送先郵便番号",'zipcode',9,9],//D
            ["配送先都道府県",'province',14,9],//E
            ["配送先住所",'address',18,9],//F
            ["配送先氏名",'fullname',18,9],//G
            ["品番",['product'=>['product_id','code']],10,9],//H
            ["商品名",['product'=>['product_name','title']],18,9],//I
            ["単価",'price',15,9],//J
            ["数量",'count',15,9],//K
            ["到着希望日",'order_date',15,9],//L
            ["配送希望時間帯",'order_hours',15,9],//M
            ["別途送料",'order_ship',15,9],//N
            ["仕入金額",'order_total_price',15,9],//O
            ["代引き請求金額",'order_total_price_buy',15,9],//P
            ["代引き手数料",'order_ship_cou',15,9],//Q
            ["紹介料",'order_price',15,9],//R
            ["追跡番号",'order_tracking',15,9],//S
            ["振込み情報",'order_info',25,9],//T
            ["",'order_link',25,9],//U
        ];
        $start=3;
        foreach($colums as $key=>$value){
            $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
            $sheet->setCellValue($nameCol.$start, $value[0])->getStyle($nameCol.$start)->applyFromArray(array(
                    'font'  => array(
                        'size'  => $value[3]
                    ),
                )
            );
            if($value[2] > 0){
                $spreadsheet->getActiveSheet()->getColumnDimension($nameCol)->setWidth($value[2]);
            }
        }
        $start++;
        $defaultStart = $start;
        $lastIndex = "";

        $company = "37";

        $orders = [

        ];

        $products =  DB::table('shop_product')->get()->keyBy('id')->all();

        $category = config_get("category", "shop-ja:japan:category");
        $category_ship = get_category_type('shop-ja:japan:category:com-ship');

        $columns_value = array_flip($datas['columns']);
        $products =  DB::table('shop_product')->get()->keyBy('id')->all();

        foreach ($datas['datas'] as $key=>$values){
            $payMethod = "";
            foreach($colums as $key=>$value){
                $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
                if(is_array($value[1])){
                    if(isset($value[1]['product'])){
                        $conf = $value[1]['product'];
                        $id = (isset($columns_value[$conf[0]])?$values[$columns_value[$conf[0]]]:"");
                        $_val = "";
                        if(isset($products[$id]) && property_exists($products[$id],$conf[1])){
                            $_val = $products[$id]->{$conf[1]};
                        }
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }else if(isset($value[1]['callback']) && isset($value[1]['key'])){
                        $conf = $value[1]['callback'];
                        $_val = call_user_func_array($conf,[$start,(isset($columns_value[$value[1]['key']])?$values[$columns_value[$value[1]['key']]]:""),$nameCol.$start]);
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }
                }else{
                    $v = (isset($columns_value[$value[1]])?$values[$columns_value[$value[1]]]:"");
                    $sheet->setCellValue($nameCol.$start,$v);
                    if($value[1] == "payMethod"){
                        $payMethod = $v;
                    }
                }
            }
            if($payMethod == "銀行振込"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => '0070c0'),
                    ),
                ) );
            }else  if($payMethod == "決済不要"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => 'ff0000'),
                    ),
                ) );
            }
            $start++;
        }

        $sheet->setCellValue("K".$start, "=SUM(K".$defaultStart.":K".($start-1).")");
        $sheet->setCellValue("P".$start, "=SUM(P".$defaultStart.":P".($start-1).")");
        $sheet->setCellValue("R".$start, "=SUM(R".$defaultStart.":R".($start-1).")");
        $sheet->setCellValue("Q".$start, "=SUM(Q".$defaultStart.":Q".($start-1).")");
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path().'/uploads/exports/OHGA.xlsx');
        return ['link'=>url('/uploads/exports/OHGA.xlsx')];
    }
    public function YAMADA($datas,$name){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->createSheet();
        $spreadsheet->getSheet(1)->setTitle('Sheet2');
        $sheet->setTitle("Sheet1");
        $spreadsheet->getProperties()
            ->setTitle('PHP Download Example')
            ->setSubject('A PHPExcel example')
            ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
            ->setCreator('php-download.com')
            ->setLastModifiedBy('php-download.com');
        $title1 = "株式会社ヤマダ 様 注文フォーマット";
        $title2 = "見本";

        $info = "依頼人名. VO HOANG 様 22日に 7410 円入金済み";

        $sheet->setCellValue('B1', $title1);
        $sheet->setCellValue('F2', $title2);
        $sheet->setCellValue('P2', $info);

        $styleArray = array(
            'font'  => array(
                'size'  => 9,
                'name' => 'Times New Roman'
            ));
        $style_header = array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb'=>'FFE100'),
            ),
            'borders' => [
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_DOTTED,
                    'color' => array('rgb'=>'000000')
                ),
            ],
            'font' => array(
                'size' => 10
            )
        );
        $sheet->getStyle('B1')->applyFromArray($styleArray);
        $sheet->getStyle('F2')->applyFromArray($styleArray);
        $sheet->getStyle('P2')->applyFromArray(array(
                'font'  => array(
                    'size'  => 9,
                    'name' => 'Times New Roman',
                    'color' => array('rgb' => '0070c0'),
                ),
            )
        );
        $sheet->getStyle('A3:T3')->applyFromArray( $style_header );
        $colums = [
            ["注文日",['callback'=>function($index,$date){return date("d", strtotime($date)).'日';},'key'=>'timeCreate'],10,9],//A
            ["支払区分",'payMethod',10,9],//B
            ["配送先電話番号",'phone',10,9],//C
            ["配送先郵便番号",'zipcode',9,9],//D
            ["配送先都道府県",'province',14,9],//E
            ["配送先住所",'address',18,9],//F
            ["配送先氏名",'fullname',18,9],//G
            ["品番",['product'=>['product_id','code']],10,9],//H
            ["商品名",['product'=>['product_name','title']],18,9],//I
            ["単価",'price',15,9],//J
            ["数量",'count',15,9],//K
            ["到着希望日",'order_date',15,9],//L
            ["配送希望時間帯",'order_hours',15,9],//M
            ["別途送料",'order_ship',15,9],//N
            ["仕入金額",'order_total_price',15,9],//O
            ["代引き請求金額",'order_total_price_buy',15,9],//P
            ["代引き手数料",'order_ship_cou',15,9],//Q
            ["紹介料",'order_price',15,9],//R
            ["追跡番号",'order_tracking',15,9],//S
            ["振込み情報",'order_info',25,9],//T
            ["",'order_link',25,9],//U
        ];
        $start=3;
        foreach($colums as $key=>$value){
            $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);

            $sheet->setCellValue($nameCol.$start, $value[0])->getStyle($nameCol.$start)->applyFromArray(array(
                    'font'  => array(
                        'size'  => $value[3]
                    ),
                )
            );

            if($value[2] > 0){
                $spreadsheet->getActiveSheet()->getColumnDimension($nameCol)->setWidth($value[2]);
            }
        }
        $start++;
        $defaultStart = $start;
        $lastIndex = "";

        $company = "22";
        $orders = [

        ];

        $columns_value = array_flip($datas['columns']);
        $products =  DB::table('shop_product')->get()->keyBy('id')->all();
        foreach ($datas['datas'] as $key=>$values){
            $payMethod = "";
            foreach($colums as $key=>$value){
                $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
                if(is_array($value[1])){
                    if(isset($value[1]['product'])){
                        $conf = $value[1]['product'];
                        $id = (isset($columns_value[$conf[0]])?$values[$columns_value[$conf[0]]]:"");
                        $_val = "";
                        if(isset($products[$id]) && property_exists($products[$id],$conf[1])){
                            $_val = $products[$id]->{$conf[1]};
                        }
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }else if(isset($value[1]['callback']) && isset($value[1]['key'])){
                        $conf = $value[1]['callback'];
                        $_val = call_user_func_array($conf,[$start,(isset($columns_value[$value[1]['key']])?$values[$columns_value[$value[1]['key']]]:""),$nameCol.$start]);
                        $sheet->setCellValue($nameCol.$start,$_val);
                    }
                }else{
                    $v = (isset($columns_value[$value[1]])?$values[$columns_value[$value[1]]]:"");
                    $sheet->setCellValue($nameCol.$start,$v);
                    if($value[1] == "payMethod"){
                        $payMethod = $v;
                    }
                }
            }
            if($payMethod == "銀行振込"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => '0070c0'),
                    ),
                ) );
            }else  if($payMethod == "決済不要"){
                $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).''.$start)->applyFromArray( array(
                    'font'  => array(
                        'size'  => 9,
                        'name' => 'Times New Roman',
                        'color' => array('rgb' => 'ff0000'),
                    ),
                ) );
            }
            $start++;
        }
        $sheet->setCellValue("K".$start, "=SUM(K".$defaultStart.":K".($start-1).")");
        $sheet->setCellValue("P".$start, "=SUM(P".$defaultStart.":P".($start-1).")");
        $sheet->setCellValue("R".$start, "=SUM(R".$defaultStart.":R".($start-1).")");
        $sheet->setCellValue("Q".$start, "=SUM(Q".$defaultStart.":Q".($start-1).")");
        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path().'/uploads/exports/'.$name.'.xlsx');
        return ['link'=>url('/uploads/exports/'.$name.'.xlsx')];

    }
    public function KOGYJA($datas){

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->createSheet();
        $spreadsheet->getSheet(1)->setTitle('Sheet2');

        $sheet->setTitle("Sheet1");
        $spreadsheet->getProperties()
            ->setTitle('PHP Download Example')
            ->setSubject('A PHPExcel example')
            ->setDescription('A simple example for PhpSpreadsheet. This class replaces the PHPExcel class')
            ->setCreator('php-download.com')
            ->setLastModifiedBy('php-download.com');

        $sheet->setCellValue('B1', '株式会社コギ家　様 注文フォーマット');


        $styleArray = array(
            'font'  => array(
                'size'  => 9,
                'name' => 'Times New Roman'
            ));
        $style_header = array(
            'fill' => array(
                'fillType' => Fill::FILL_SOLID,
                'color' => array('rgb'=>'FFE100'),
            ),
            'borders' => [
                'allBorders' => array(
                    'borderStyle' => Border::BORDER_DOTTED,
                    'color' => array('rgb'=>'000000')
                ),
            ],
            'font' => array(
                'size' => 10
            )
        );
        $sheet->getStyle('B1')->applyFromArray($styleArray);
        $start=2;
        for($typeMethod = 0; $typeMethod< 2 ; $typeMethod++){
            $colums = [
                ["注文日",'timeCreate',10,9],//ngày đặt hàng
                ["支払区分",'payMethod',10,9],//Phương thức thanh toán
                ["配送先電話番号",'phone',10,9],//Số điện thoại
                ["配送先郵便番号",'zipcode',9,9],//Mã bưu điện
                ["配送先都道府県",'province',14,9],//Tỉnh/TP
                ["配送先住所",'address',18,9],//Địa chỉ giao hàng
                ["配送先氏名",'fullname',18,9],//Họ tên người nhận
                ["品番",['product'=>['product_id','code']],10,9],//Mã SP
                ["商品名",['product'=>['product_id','title']],18,9],//Tên SP
                ["単価",['product'=>['product_id','price']],15,9],//Giá nhập
                ["数量",'count',15,9],//SL
                ["到着希望日",'day_ship',15,9],//Ngày nhận
                ["配送希望時間帯",'time_ship',15,9],//Giờ nhận
                ["別途送料",'price_ship',15,9],//Phí ship
                ["仕入金額",['product'=>['product_id','price','totalPrice']],15,9],//Tổng giá nhập
                ["代引き請求金額",['product'=>['product_id','price_buy','totalPriceBuy']],15,9],//Giá bán
                ["代引き手数料",['product'=>['product_id','price_buy','totalCOU']],15,9],
                ["紹介料",['callback'=>function($index){return '=IF(J'.$index.'="","",P'.$index.'-J'.$index.'*K'.$index.'-N'.$index.'-Q'.$index.')';}],15,9],
                ["追跡番号",'tracking',15,9],
                ["振込み情報",'info',25,9],
            ];
            foreach($colums as $key=>$value){
                $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
                $sheet->setCellValue($nameCol.$start, $value[0])->getStyle($nameCol.$start)->applyFromArray(array(
                        'font'  => array(
                            'size'  => $value[3]
                        ),
                    )
                );
                if($value[2] > 0){
                    $spreadsheet->getActiveSheet()->getColumnDimension($nameCol)->setWidth($value[2]);
                }
            }
            $sheet->getStyle('A'.$start.':'. PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($colums)).$start)->applyFromArray( $style_header );
//            $ship = 34;
//            $datas = [];
//            $company = "22";
//            $orders = [
//
//            ];
            if($typeMethod == 0){
                $start+=2;
                $sheet->setCellValue('N'.$start, '合計');
                $sheet->setCellValue('P'.$start, '合計代引き金額：　19330');

                $sheet->getStyle('N'.$start)->applyFromArray(array(
                        'font'  => array(
                            'size'  => 9,
                            'name' => 'Times New Roman',
                            'color' => array('rgb' => 'ff1100'),
                        ),
                    )
                );
                $sheet->getStyle('P'.$start)->applyFromArray(array(
                        'font'  => array(
                            'size'  => 9,
                            'name' => 'Times New Roman',
                            'color' => array('rgb' => 'ff1100'),
                        ),
                    )
                );

                $start++;
                $sheet->setCellValue('I'.$start, '※1キロずつの小分けをお願いします。');
                $sheet->getStyle('I'.$start)->applyFromArray(array(
                        'font'  => array(
                            'size'  => 9,
                            'name' => 'Times New Roman',
                            'color' => array('rgb' => 'ff1100'),
                        ),
                    )
                );
            }
            $columns = array_flip($datas['columns']);
            var_dump($columns);
            foreach ($datas['datas'] as $key=>$values){
                foreach($colums as $key=>$value){
                    $nameCol = PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($key+1);
                    if(is_array($value[1])){
                        $sheet->setCellValue($nameCol.$start,"");
                    }else{
                        $sheet->setCellValue($nameCol.$start,(isset($columns[$value[1]])?$values[$columns[$value[1]]]:""));
                    }

                }
                $start++;
            }
            $start+=1;
            $dataRow = [];
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save(public_path().'/uploads/exports/KOGYJA.xlsx');
    }
}
<?php
namespace BetoGaizinTheme\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
class WidgetController extends \Zoe\Http\ControllerFront
{
    public static function MainSchedule(){
        $results = DB::table('miss_room')->where('status',1)->get()->all();
        $config_language = app()->config_language;

        if(isset($config_language['lang'])){
            $translation = DB::table('miss_room_translation')->where('lang_code',$config_language['lang'])->get()->keyBy('room_id')->all();
            foreach ($results as $key=>$value){

                $prices = json_decode($value->prices,true);

                $value->prices = [];
                foreach ($prices as $k=>$v){
                    $value->prices[$k] = $v;
                    $value->prices[$k]['keys'] = explode('-',$k);
                }
                if(empty($value->prices_event)){
                    $value->prices_event = [];
                }else{
                    $prices_event = json_decode($value->prices_event,true);
                    $value->prices_event = [];
                    foreach ($prices_event as$k=>$v){
                        if(!isset($result->prices_event[$v['date']])){
                            $value->prices_event[$v['date']] = [];
                        }
                        $value->prices_event[$v['date']][$k] = $v;
                        $value->prices_event[$v['date']][$k]['keys'] = explode('-',$v['user']);
                    }
                }
                if(isset($translation[$value->id])){
                    $value->title = $translation[$value->id]->title;
                    $value->address = $translation[$value->id]->address;
                    $value->info = $translation[$value->id]->info;
                    $value->description = $translation[$value->id]->description;
                    $value->content = $translation[$value->id]->content;
                }
            }
        }

        return [
            'results'=>$results,
        ];
    }
    public function WidgetSchedule(Request $request){
        $data = $request->all();
        return $this->render('widget.schedule',['data'=>static::MainSchedule(),'requests'=>$data]);
    }
    public function WidgetSubscribe(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'email' => 'required|email|max:255',
        ]);
        $rules = [];

        if ($validator->passes()) {
            DB::table('email_user')->updateOrInsert([
                'email'=>$data['email']
            ],[
                'created_at'=>date('Y-m-d H:i:s'),
                'status'=>1
            ]);
            return response()->json(['oke' => z_language('Success Subscribe!')]);
        }else{
            return response()->json(['errors' => $validator->errors(), 'data_rules' => $rules]);
        }

    }
    public static $keyCart = 'carts_ver_1';
    public static $keyCart_ship_time = 'carts_time_ship';

    public function WidgetCartAdd(Request $request){
        $data = $request->all();

        $carts = $request->session()->get(WidgetController::$keyCart,[]);


        if($data['act'] == "update"){
            if(isset($carts[$data['id']])){
                $carts[$data['id']]['count'] = $data['count'];
            }
        }else if($data['act'] == "add"){
            if(isset($carts[$data['id']])){
                $carts[$data['id']]['count']+= $data['count'];
            }else{
                $carts[$data['id']] = ['id'=>$data['id'],'count'=>(int) $data['count'],'time'=>time(),'cate'=>$data['cate']];
            }
        }
        if(isset( $carts[$data['id']]['count']) && $carts[$data['id']]['count']<=0 ){
            unset($carts[$data['id']]);
        }



        $request->session()->put(WidgetController::$keyCart ,$carts);

        return response()->json(['carts'=>$carts]);
    }

    public function WidgetCartList(Request $request){
        $carts = $request->session()->get(WidgetController::$keyCart,[]);
        $ids = array_keys($carts);
        $_products = DB::table('shop_product')->whereIn('id',$ids)->get()->keyBy('id')->all();
        $configs = new \BetoGaizinTheme\Lib\Price();
        foreach ($_products as $key=>$product){
            $_products[$key]->count = $carts[$product->id]['count'];
            $_products[$key]->price_total = $_products[$key]->count * $product->price_buy;
            $_products[$key]->order_index = $carts[$product->id]['time'];
        }
        usort($_products, function($a,$b){
            return $a->order_index - $b->order_index;
        });
        //$configs->prices($carts);
       // dd($carts);
        return $this->render('widget.cart-list',['counts'=>count($ids),'products'=>$_products]);
    }
    public function WidgetShipTime(Request $request){
        $data = $request->all();
        $request->session()->put(WidgetController::$keyCart_ship_time,$data);
        return response()->json([]);
    }
    public function WidgetPriceCart(Request $request){

        $carts = $request->session()->get(WidgetController::$keyCart,[]);
        $configs = new \BetoGaizinTheme\Lib\Price();

        return response()->json([
            'prices'=>$configs->prices($carts)
        ]);
    }
    public function WidgetAddress(Request $request){
        $data = $request->all();

        if(isset($data['id'])){
          $id =  $data['id'];
          DB::table('shop_adresss')->update(
              [
                  'last_name'=>isset($data['last_name'])?$data['last_name']:"",
                  'first_name'=>isset($data['first_name'])?$data['first_name']:"",
                  'last_name_kana'=>isset($data['last_name_kana'])?$data['last_name_kana']:"",
                  'first_name_kana'=>isset($data['first_name_kana'])?$data['first_name_kana']:"",
                  'postal_code'=>isset($data['postal_code'])?$data['postal_code']:"",
                  'prefecture_code'=>isset($data['prefecture_code'])?$data['prefecture_code']:"",
                  'address2'=>isset($data['address2'])?$data['address2']:"",
                  'address3'=>isset($data['address3'])?$data['address3']:"",
                  'national_address_code'=>isset($data['national_address_code'])?$data['national_address_code']:"",
                  'address5'=>isset($data['address5'])?$data['address5']:"",
                  'address6'=>isset($data['address6'])?$data['address6']:"",
                  'phone1'=>isset($data['phone1'])?$data['phone1']:"",
                  'phone2'=>isset($data['phone2'])?$data['phone2']:"",
                  'phone3'=>isset($data['phone3'])?$data['phone3']:"",
                  'phone4'=>isset($data['phone4'])?$data['phone4']:"",
                  'phone5'=>isset($data['phone5'])?$data['phone5']:"",
                  'phone6'=>isset($data['phone6'])?$data['phone6']:"",
                  'update_create'=>date('Y-m-d H:i:s'),
              ],
              ['id'=>$id]
          );
        }else{
          $id =  DB::table('shop_adresss')->insertGetId(
              [
                  'user_id'=>auth('frontend')->user()->id,
                  'last_name'=>isset($data['last_name'])?$data['last_name']:"",
                  'first_name'=>isset($data['first_name'])?$data['first_name']:"",
                  'last_name_kana'=>isset($data['last_name_kana'])?$data['last_name_kana']:"",
                  'first_name_kana'=>isset($data['first_name_kana'])?$data['first_name_kana']:"",
                  'postal_code'=>isset($data['postal_code'])?$data['postal_code']:"",
                  'prefecture_code'=>isset($data['prefecture_code'])?$data['prefecture_code']:"",
                  'address2'=>isset($data['address2'])?$data['address2']:"",
                  'address3'=>isset($data['address3'])?$data['address3']:"",
                  'national_address_code'=>isset($data['national_address_code'])?$data['national_address_code']:"",
                  'address5'=>isset($data['address5'])?$data['address5']:"",
                  'address6'=>isset($data['address6'])?$data['address6']:"",
                  'phone1'=>isset($data['phone1'])?$data['phone1']:"",
                  'phone2'=>isset($data['phone2'])?$data['phone2']:"",
                  'phone3'=>isset($data['phone3'])?$data['phone3']:"",
                  'phone4'=>isset($data['phone4'])?$data['phone4']:"",
                  'phone5'=>isset($data['phone5'])?$data['phone5']:"",
                  'phone6'=>isset($data['phone6'])?$data['phone6']:"",
                  'time_create'=>date('Y-m-d H:i:s'),
                  'time_update'=>date('Y-m-d H:i:s'),
              ]
          );
        }
    }
    public function WidgetAddressActive(Request $request){
        $data = $request->all();
        if($data['act']){
            if($data['act'] == "active"){

                DB::table('shop_adresss')->update(
                    [
                        'active'=>0,
                    ],
                    ['user_id'=>auth('frontend')->user()->id]
                );

                DB::table('shop_adresss')->where(['user_id'=>auth('frontend')->user()->id,'id'=>$data['id']])->update(
                    [
                        'active'=>1,
                    ]
                );
            }else if($data['act'] == "delete"){
                DB::table('shop_adresss')->where(['user_id'=>auth('frontend')->user()->id,'id'=>$data['id']])->delete();
            }
        }
    }

    public function WidgetCartOrder(Request $request){
        $data = $request->all();



        $carts = $request->session()->get(WidgetController::$keyCart,[]);
        $ids = array_keys($carts);
        $_products = DB::table('shop_product')->whereIn('id',$ids)->get()->keyBy('id')->all();
        $configs = new \BetoGaizinTheme\Lib\Price();
        foreach ($_products as $key=>$product){
            $_products[$key]->count = $carts[$product->id]['count'];
            $_products[$key]->price_total = $_products[$key]->count * $product->price_buy;
            $_products[$key]->order_index = $carts[$product->id]['time'];
        }
        usort($_products, function($a,$b){
            return $a->order_index - $b->order_index;
        });

        if(auth('frontend')
                ->user() == null){
            return redirect(route('login'));
        }
        $address = DB::table('shop_adresss')
            ->where('user_id',auth('frontend')
                ->user()->id)->where('active',1)
            ->orderBy('active','desc')->get()->all();

        $prices = $configs->prices($carts);

        $timeShip = request()->session()->get(\BetoGaizinTheme\Http\Controllers\WidgetController::$keyCart_ship_time,[]);

        $category = get_category_type("shop-ja:product:category");

        $totals_product = 0;
        $totals_ship =0;
        $total_cou = 0;
        $sale = 0;





        $address = DB::table('shop_adresss')
            ->where('user_id',auth('frontend')
                ->user()->id)->where('active',1)
            ->orderBy('active','desc')->get()->all();


        DB::beginTransaction();
        try{
            //$timeShip['year'].'年'.$timeShip['month'].'月'.$timeShip['day'].'日(日) '.$timeShip['time']
           $id = DB::table('shop_order')->insertGetId([
               'fullname'=>$address[0]->first_name .' '.$address[0]->last_name,
               'user_id'=>auth('frontend')
                   ->user()->id,
               'postal_code'=>$address[0]->postal_code,
               'admin_id'=>auth()
                       ->user() != null?auth()
                   ->user()->id:1,
               'pay_method'=>$data['payment'],
               'phone'=>$address[0]->phone1.'-'.$address[0]->phone1.'-'.$address[0]->phone1,
               'country'=>$address[0]->address2,
               'city'=>$address[0]->prefecture_code,
               'address'=>$address[0]->address5,
               'bank_info'=>'',
               'day_ship'=>$timeShip['year'].'-'.$timeShip['month'].'-'.$timeShip['day'],
               'time_ship'=>$timeShip['time'],
               'info'=>'',
               'created_at'=>date('Y-m-d'),
               'updated_at'=>date('Y-m-d'),
           ]);

            foreach($category as $cate=>$value){
                foreach($_products as $k=>$product){
                    if($product->category_id != $cate) continue;
                    $isSub = true;

                    $price = isset($prices[$value->name]['products'][$product->id])?$prices[$value->name]['products'][$product->id]:[];

                    DB::table('shop_order_detail')->insert([
                        'order_id'=>$id,
                        'product_id'=>$product->id,
                        'count'=>$product->count,
                        'price_buy'=>$product->price_buy,
                        'price'=>$product->price,
                        'price_ship'=>isset($price['ship'])?$price['ship']:0,
                        'company'=>$product->category_id,
                        'ship'=>isset($price['cou'])?$price['cou']:0,
                        'image'=>"",
                        'image_order'=>$product->image,
                        'tracking'=>"",
                        'status'=>0,
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                }
            }
            DB::commit();
            $request->session()->put(WidgetController::$keyCart,[]);
            $request->session()->put(WidgetController::$keyCart_ship_time,[]);
            return response()->json([
                'url'=>router_frontend_lang('page:order_success',['id'=>'id','slug'=>'slug'])
            ]);
        }catch (\Exception $ex){
            DB::rollBack();
            return response()->json([
                'url1'=>router_frontend_lang('home:cart-product',[]),
                'error'=>$ex->getMessage()
            ]);
        }

    }
}
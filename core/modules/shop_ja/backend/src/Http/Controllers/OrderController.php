<?php
namespace ShopJa\Http\Controllers;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use \ShopJa\Http\Models\OrderModel;
class OrderController extends \Zoe\Http\ControllerBackend
{
    public function init()
    {
        $this->data['language'] = config('zoe.language');
        $this->data['nestables'] = config_get("category", "shop-ja:japan:category");
        $this->data['configs'] = config_get("config", "shopja");
        $this->data['current_language'] = isset($this->data['configs']['shopja']['language']['default']) ? $this->data['configs']['shopja']['language']['default'] : "en";

    }
    public function getCrumb()
    {
        $this->breadcrumb(z_language("Quản lý đơn hàng"), route('backend:shop_ja:order:list'));
        return $this;
    }
    public function ajax(Request $request){
        $output = [];
        $data = $request->all();

        if(isset($data['term']) || isset($data['id']) || isset($data['lists']) ){

          if(isset($data['term'])){
              $results =  DB::table('shop_product')->where('description', 'like', '%' . $data['term'] . '%')->get()->all();
          }else if(isset($data['id'])){
              $results =  DB::table('shop_product')->where('id', $data['id'])->get()->all();
          }else if(isset($data['lists'])){
              $ids = [

              ];
              foreach ($data['lists'] as $row){
                $ids[] = $row['id'];
              }
              $results =  DB::table('shop_product')->whereIn('id',$ids )->get()->all();
          }
          $category = get_category_type('shop-ja:product:category');
          foreach ($results as $key=>$result){
              $temp_array = array();
              $temp_array['value'] = $result->description;

              $ship_category = DB::table('shop_ship_category')->where('category_id', $data['city'])->where('product_id',$result->id)->get()->all();
              $price_ship = "";
              $ship = isset($category[$result->category_id])?isset($category[$result->category_id]->data['ship'])?$category[$result->category_id]->data['ship']:"-1":"-1";

              if(isset($ship_category[0])){
                $_info = unserialize($ship_category[0]->data);
                if(isset($_info[$ship]) && count($_info[$ship]) > 0){
                    $price_ship = $_info[$ship];
                }
              }

              $temp_array['data'] = [
                  'id'=>$result->id,
                  'code'=>$result->code,
                  'title'=>$result->title,
                  'description'=>$result->description,
                  'price'=>$result->price,
                  'price_buy'=>$result->price_buy,
                  'unit'=>$result->unit,
                  'company'=>isset($category[$result->category_id])?$category[$result->category_id]->name:"empty",
                  'ship'=>$ship,
                  'count'=>'1',
                  'image'=>'image',
                  'price_ship'=> $price_ship,
                  'total_price'=>$result->price,
                  'total_price_buy'=>$result->price_buy,
              ];
              $temp_array['hidden'] = [
                  'company'=>isset($category[$result->category_id])?$category[$result->category_id]->id:0,
                  'ship'=>isset($category[$result->category_id])?isset($category[$result->category_id]->data['ship'])?$category[$result->category_id]->data['ship']:"-1":"-1",
              ];
              $temp_array['label'] = '<img src="'.(!empty($result->image) || $result->image != 'null'  ?$result->image:"http://placehold.jp/100x150.png").'" width="70" />&nbsp;&nbsp;&nbsp;'. $result->description.'-'.$result->title;
              $output[] = $temp_array;
          }
        }
        return response()->json($output);
    }
    public function list(Request $request)
    {
        $this->getcrumb();
        $filter = $request->query('filter', []);
        $search = $request->query('search', "");
        $status = $request->query('status', "");
        $date = $request->query('date', "");
        $config = config_get('option', "module:shop_ja:order");
        $item = isset($config['pagination']['item']) ? $config['pagination']['item'] : 20;
        $models = DB::table('shop_order');

        if(isset($filter['fullname'])){
            $models->where('fullname', 'like', '%' . $filter['code']);
        }

        if (!empty($status) || $status != "") {
            $models->where('status', $status);
        }
        $models->orderBy('id', 'desc');
        return $this->render('order.list', [
            'models' => $models->paginate($item),
            'callback' => [
                "GetUserName" => function ($model){
                    $rs = DB::table('admin as t')->where('id', $model->admin_id)->get('username');
                    return $rs && count($rs) > 0 ? $rs[0]->username : "Empty";
                },
                "GetCountOrder" => function ($model){
                    $count =  DB::table('shop_order_detail as t')->where('order_id', $model->id)->count('order_id');
                    $html = "<ul>";
                    $results = DB::table('shop_order_detail as t')->where('order_id', $model->id)->get(['product_id','count','status'])->all();
                    $ids = [];
                    foreach ($results as $index=>$result){
                        $results_products =  DB::table('shop_product')->where('id', $result->product_id)->get(['title','description'])->all();
                        foreach ($results_products as $value){
                            if($result->status == 1){
                                $html.='<li> SL('.$result->count.') <span class="label bg-green">'.$value->title.'-'.$value->description.'</span></li>';
                            }else if($result->status == 3){
                                $html.='<li>SL('.$result->count.') <span class="label bg-red">'.$value->title.'-'.$value->description.'</span></li>';
                            }else {
                                $html.='<li>SL('.$result->count.') <span class="label bg-yellow">'.$value->title.'-'.$value->description.'</span></li>';
                            }
                        }
                    }

                    $html.= "</ul>";

                    return $html;
                },
                "GetStatus"=>function($model){
                    if($model->status == 1){
                        return z_language('Bản nháp');
                    }else if($model->status == 2){
                        return z_language('Lập đơn');
                    }else if($model->status == 3){
                        return z_language('Đã hoàn thành');
                    }
                }
            ],
        ]);
    }
    public function create()
    {
        $this->getCrumb()->breadcrumb(z_language("Tạo mới"), route('backend:shop_ja:order:create'));
        return $this->render('order.create', ['item' => []], 'blog');
    }

    public function edit($id)
    {
        $this->getcrumb()->breadcrumb(z_language("Sửa"), false);
        $model = OrderModel::find($id);
        $model->detailOrder = json_encode($model->GetDetails());
        return $this->render('order.edit', ["model" => $model]);
    }
    public function delete()
    {

    }
    public function status()
    {

    }
    public function store(Request $request){
        $data = $request->all();
        $validator = Validator::make($data, [
            'fullname' => 'required',
            'phone' => 'required',
            'postal_code' => 'required|integer',
            'city' => 'required',
            'country' => 'required',
            'address' => 'required',
            'day_ship' => 'required|date',
            'time_ship' => 'required',
            'pay_method' => 'required',
        ], [
            'image.required' => z_language('Ảnh sản phẩm không được phép bỏ trống.'),
            'title.required' => z_language('Tên sản phẩm không được phép bỏ trống.'),
            'category_id.required' => z_language('Chuyên mục không được phép bỏ trống.'),
            'price.required' => z_language('Giá nhập không được bỏ trống.'),
            'price.integer' => z_language('Giá nhập phải là giá trị số.'),
            'price_buy.required' => z_language('Giá bán không được bỏ trống.'),
            'price_buy.integer' => z_language('Giá bán phải là giá trị số.'),
        ]);

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        if (isset($data['id']) && !empty($data['id'])) {
            $model = OrderModel::find($data['id']);
        } else {
            $model = new OrderModel();
        }
        try {

            $model->fullname = $data['fullname'];
            $model->admin_id = 1;
            $model->postal_code = $data['postal_code'];
            $model->pay_method = $data['pay_method'];
            $model->phone = $data['phone'];
            $model->address = $data['address'];
            $model->country = $data['country'];
            $model->city = $data['city'];
            $model->day_ship = $data['day_ship'];
            $model->time_ship = $data['time_ship'];
            $model->info = $data['info'];
            $model->link = $data['link'];
            $model->bank_info = $data['bank_info'];
            $model->status = $data['status'];
            $model->save();

            if(isset($data['dataDetailOrder'])){
                $dataDetailOrder = json_decode($data['dataDetailOrder'],true);
                $updated_at = date('Y-m-d H:i:s');
                foreach ($dataDetailOrder as $k=>$item){
                  DB::table('shop_order_detail')
                      ->updateOrInsert(
                          ['order_id' => $model->id, 'product_id' => $item['id']],
                          [
                              'count' =>$item['count'],
                              'company' =>$item['company'],
                              'ship' =>$item['ship'],
                              'image' =>$item['image'],
                              'price' =>(int) $item['price'],
                              'price_buy' =>(int)$item['price_buy'],
                              'price_ship' => (int) $item['price_ship'],
                              'updated_at' => $updated_at]);
                }
                DB::table('shop_order_detail')->where('order_id',$model->id)->where('updated_at','!=',$updated_at)->delete();
            }
            return redirect(route('backend:shop_ja:order:edit', ['id' => $model->id]));
        }catch (\Exception $ex){
            $validator->getMessageBag()->add('id', $ex->getMessage());
            echo $ex->getMessage();
            die;
        }
        return back();
    }
}

<?php
namespace BetoGaizinTheme\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Mail;
use BetoGaizinTheme\Mail\MyEmail;
class HomeController extends \Zoe\Http\ControllerFront
{
    public $config_language = [];

    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->config_language = app()->config_language;
    }

    public function getHome()
    {

    }
    public function getCategoryGroupProduct($id){
        $total_records = DB::table('shop_product')->where('group_id',$id)->count();
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $total_page = ceil($total_records / $limit);
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;
        $config_language = app()->config_language;

        $results = DB::table('shop_product as p')->where('p.status',1)->where('p.group_id',$id)
            ->join('shop_product_translation as t','t._id','=','p.id')
            ->select('p.id','p.image','p.price_buy','p.category_id','t.name','t.slug','t.content')
            ->where('lang_code',$config_language['lang'])
            ->offset($start)->limit($limit)->get()->all();
        $cate = [];

        $name = "";
        if(isset($config_language['lang'])){

            $cate =(array) DB::table('categories_translation')
                ->select(['slug','name'])
                ->where('lang_code',$config_language['lang'])
                ->where('_id',$id)
                ->get()->first();
            $cate['id'] = $id;
            $name = $cate['name'];
            unset($cate['name']);
        }

        return $this->render('home.category-product', [
            'results'=>$results,
            'current_page'=>$current_page,
            'total_page'=>$total_page,
            'cate'=>[
                'router'=>$cate,
                'name'=>$name
            ]
        ]);
    }
    public function getCategoryProduct($id){
        $total_records = DB::table('shop_product')->where('status',1)->where('category_id',$id)->count();
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $total_page = ceil($total_records / $limit);
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;
        $results = DB::table('shop_product')->where('status',1)->where('category_id',$id)->offset($start)->limit($limit)->get()->all();

        return $this->render('home.category-product', [
            'results'=>$results,
            'current_page'=>$current_page,
            'total_page'=>$total_page,
            'cate'=>(array)DB::table('categories')->select(['id','slug'])->where('id',$id)->get()->first()
        ]);
    }
    public function getSearchProduct(Request $request){
        $kw = $request->keyword;
        $model = DB::table('shop_product')->where('status',1)->where('title', 'like', '%'.$kw.'%');
        $total_records = $model->count();
        $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $limit = 10;
        $total_page = ceil($total_records / $limit);
        if ($current_page > $total_page){
            $current_page = $total_page;
        }
        else if ($current_page < 1){
            $current_page = 1;
        }
        $start = ($current_page - 1) * $limit;
        $results = $model->offset($start)->limit($limit)->get()->all();

        return $this->render('home.search-product', [
            'results'=>$results,
            'current_page'=>$current_page,
            'total_page'=>$total_page,
            'keyword'=>$kw
        ]);
    }
    public function getItemProduct($id){

        $config_language = app()->config_language;

        $model = \ShopJa\Http\Models\ProductModel::where('status', 1)->where('id',$id)->first();


        if($model == null){
            return redirect('/404');
        }
        $trans = $model->table_translation_model()
            ->where(['_id' => $id])
            ->where('lang_code',$config_language['lang'])
            ->get()->all();

        foreach ($trans as $tran) {

            $model->offsetSet("name", $tran->name);
            $model->offsetSet("slug", $tran->slug);
            $model->offsetSet("content", $tran->content);
        }

        $array = array_merge([$model->image],\PluginGallery\Views\GalleryComposer::get($id,"shop_ja::form.product"));

        $results = DB::table('shop_product as p')->where('p.status',1)->where('p.group_id',$model->group_id)
            ->join('shop_product_translation as t','t._id','=','p.id')
            ->select('p.id','p.image','p.price_buy','p.category_id','t.name','t.slug','t.content')
            ->where('lang_code',$config_language['lang'])
            ->orderByRaw('RAND()')
            ->offset(0)->limit(10)->get()->all();
        return $this->render('home.item-product', [
            'item'=>$model,
            'categorys'=>$results,
            'gallerys'=>$array
        ]);
    }
    public function getCart(Request $request){
        if(auth('frontend')
                ->user() == null){
            return redirect(route('login'));
        }
        $carts = $request->session()->get(WidgetController::$keyCart,[]);
        $ids = array_keys($carts);
        $_products = DB::table('shop_product')->whereIn('id',$ids)->get()->keyBy('id')->all();
        $configs = new \BetoGaizinTheme\Lib\PriceAction();

        foreach ($_products as $key=>$product){
            $_products[$key]->count = $carts[$product->id]['count'];
            $_products[$key]->price_total = $_products[$key]->count * $product->price_buy;
            $_products[$key]->order_index = $carts[$product->id]['time'];
            $rs = DB::table('shop_product_translation')->select('slug','name')->where('lang_code','vi')->where('_id',$product->id)->get()->all();
            if(isset($rs[0])){
                 $_products[$key]->slug = $rs[0]->slug;
                 $_products[$key]->name = $rs[0]->name;
            }
            $carts[$product->id]['data'] = $product;
        }

        $address = DB::table('shop_adresss')
            ->where('user_id',auth('frontend')
                ->user()->id)->where('active',1)
            ->orderBy('active','desc')->get()->all();

        $pay = isset($address[0])?$address[0]->prefecture_code:"";
        return $this->render('home.step.step1', [
            'counts'=>count($ids),
            'products'=>$_products,
            'prices'=> $configs->prices($carts,$pay),
            'address'=> $address
        ]);
    }
    public function getchangeInfoaddress(){
        $lists = DB::table('shop_adresss')->where('user_id',auth('frontend')->user()->id)->orderBy('active','desc')->get()->all();
        return $this->render(
            'home.address.lists',[
                'lists'=>$lists
            ]
        );
    }
    public function getchangeEditaddress(Request $request){
        $id = $request->id;

        $model = \BetoGaizinTheme\Http\Model\AddressModel::find($id);

        return $this->render('home.address.edit',[
            'model'=>$model
        ]);
    }
    public function getchangeCreateaddress(Request $request){

        return $this->render(
            'home.address.edit',['lists_city'=>config('shop_ja.configs.lists_city')]
        );
    }
    public function get_order_oke(){

    }
}
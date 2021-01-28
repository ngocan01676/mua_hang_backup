<?php
namespace MissTerryTheme\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Str;
use Mail;
use MissTerryTheme\Mail\MyEmail;
class HomeController extends \Zoe\Http\ControllerFront
{
    public $config_language = [];
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->config_language = app()->config_language;
    }
    public function getLists()
    {
        return $this->render('home.list', [
            'MetaViewComposer'=>[
                'key'=>'17:blog::form.post:vi',
            ]
        ]);
    }
    public function getRoom(){
        return $this->render('home.room', []);
    }
    public function getPricing(){
        return $this->render('home.pricing', []);
    }
    public function getRoomDetail($slug){

        $translation = DB::table('miss_room_translation')->where('lang_code',$this->_language['code'])->where('slug',$slug)->get()->all();
        if(isset($translation[0])){
            $results = DB::table('miss_room')
                ->where('status',1)
                ->where('id',$translation[0]->room_id)
                ->get()
                ->all();
            if(isset($results[0])){
                $result = $results[0];
                $images = DB::table('plugin_gallery')
                    ->where('name','GalleryComposer')
                    ->where('key_group','MissTerry::form.room')
                    ->where('key_id',$result->id)->get()->all();
                $prices = json_decode($result->prices,true);
                $result->prices = [];
                foreach ($prices as $key=>$value){
                    $result->prices[$key] = $value;
                    $result->prices[$key]['keys'] = explode('-',$key);
                }
                if(empty($result->prices_event)){
                    $result->prices_event = [];
                }else{
                    $prices_event = json_decode($result->prices_event,true);

                    $result->prices_event = [];
                    foreach ($prices_event as $key=>$value){
                        if(!isset($result->prices_event[$value['date']])){
                            $result->prices_event[$value['date']] = [];
                        }
                        $result->prices_event[$value['date']][$key] = $value;
                        $result->prices_event[$value['date']][$key]['keys'] = explode('-',$value['user']);
                    }
                }
                $result->times = json_decode($result->times,true);
                if(isset($this->_language['lang'])){
                    if(isset($translation[0])){
                        $result->title = $translation[0]->title;
                        $result->description = $translation[0]->description;
                        $result->content = $translation[0]->content;
                        $result->address = $translation[0]->address;
                        $result->info = $translation[0]->info;
                    }else{
                        $result->title = "";
                        $result->description = "";
                        $result->content = "";
                        $result->info = "";
                        $result->address  = "";
                    }
                }
                if(isset($images[0])){
                    $images[0]->data = unserialize($images[0]->data);
                    $result->images =  $images[0];
                }else{
                    $result->images = [];
                }

                return $this->render('home.detail', ['result'=> $result]);
            }
        }else{
            redirect('/error/404');
        }
    }
    public function action_register_room(Request $request){
        $data = $request->all();
        $f = [
            'fullname' => 'required|max:255',
            'phone' => 'required|max:15',
            'time' => 'required|regex:/(\d+\:\d+)/',
            'date' => 'required|date_format:d-m-Y',
            'email' => 'required|email|max:255',
            'number' => 'required|integer|gt:0|lt:7',
            'id' => 'required|integer|gt:0',
            'price' => 'required|integer|gt:0',
            'g-recaptcha-response'=>'required|captcha'
        ];
        if( Auth::user() != null){
            unset($f['g-recaptcha-response']);
        }
        $validator = Validator::make($data['data'], $f);
        $rules = [];
        if ($validator->passes()) {
            DB::beginTransaction();
            try{
                $booking_date = formatDateYMD($data['data']['date']);
                $count = DB::table('miss_booking')
                    ->where('room_id',$data['data']['id'])
                    ->where('booking_date',$booking_date)
                    ->where('status','!=',3)
                    ->where('booking_time',$data['data']['time'])
                    ->get()->all();
                if(count($count) == 0 || (isset($count[0]) && isset($data['data']['booking']) && $count[0]->id == $data['data']['booking'])){
                    if( isset($count[0]) && isset($data['data']['booking']) && $count[0]->id == $data['data']['booking']){
                        $id = $count[0]->id;
                        DB::table('miss_booking')->where('id',$data['data']['booking'])->update([
                            'room_id'=>$data['data']['id'],
                            'fullname'=>$data['data']['fullname'],
                            'phone'=>$data['data']['phone'],
                            'email'=>$data['data']['email'],
                            'count'=>$data['data']['number'],
                            'note'=>$data['data']['note'],
                            'sex'=>isset($data['data']['sex'])?$data['data']['sex']:0,
                            'booking_date'=>formatDateYMD($data['data']['date']),
                            'booking_time'=>$data['data']['time'],
                            'status'=>isset($data['data']['status'])?$data['data']['status']:0,
                            'price'=>$data['data']['price'],
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ]);
                    }else{
                        $id = DB::table('miss_booking')->insertGetId([
                            'room_id'=>$data['data']['id'],
                            'user_id'=>auth('frontend')->user()?auth('frontend')->user()->id:0,
                            'fullname'=>$data['data']['fullname'],
                            'phone'=>$data['data']['phone'],
                            'email'=>$data['data']['email'],
                            'count'=>$data['data']['number'],
                            'sex'=>isset($data['data']['sex'])?$data['data']['sex']:0,
                            'booking_date'=>formatDateYMD($data['data']['date']),
                            'booking_time'=>$data['data']['time'],
                            'status'=>isset($data['data']['status'])?$data['data']['status']:0,
                            'price'=>$data['data']['price'],
                            'note'=>$data['data']['note'],
                            'created_at'=>date('Y-m-d H:i:s'),
                            'updated_at'=>date('Y-m-d H:i:s'),
                        ]);
                    }
                    $response =  response()->json(['success' => $data,'id'=>$id,
                        'uri'=>router_frontend_lang('page:booking_success',['slug'=>Str::slug($data['data']['fullname']),'id'=>base_64_en($id*10000)])]);
                    DB::commit();
                    return $response;
                }else{
                    return response()->json(['errors' => [
                        'fullname'=>[z_language('Thơi gian :DATE :TIME đã có người đặt',['DATE'=>$booking_date,"TIME"=>$data['data']['time']])]], 'data_rules' => $rules]);
                }
            }catch (\Exception $ex){
                DB::rollBack();
                return response()->json(['errors' => ['fullname'=>[$ex->getMessage()]], 'data_rules' => $rules]);
            }
        }else{
            return response()->json(['errors' => $validator->errors(), 'data_rules' => $rules]);
        }
        return json_encode($data);
    }
    public function register_room_oke($slug,$id){
        $id = (int)base_64_de($id)/10000;
        $miss_booking = DB::table('miss_booking')->where('id',$id)->get()->all();
        $dataSend = [];
        if(isset($miss_booking[0])){
            $to_email = $miss_booking[0]->email;
            $results = DB::table('miss_room')->where('status',1)->where('id',$miss_booking[0]->room_id)->get()->all();
            if(isset($results[0])){
                $result = $results[0];
                if(isset($this->_language['lang'])){
                    $translation = DB::table('miss_room_translation')->where('lang_code',$this->_language['code'])->where('room_id',$result->id)->get()->all();
                    if(isset($translation[0])){
                        $result->title = $translation[0]->title;
                        $result->description = $translation[0]->description;
                        $result->content = $translation[0]->content;
                        $result->address = $translation[0]->address;
                        $result->info = $translation[0]->info;
                    }else{
                        $result->title = "";
                        $result->description = "";
                        $result->content = "";
                        $result->info = "";
                        $result->address  = "";
                    }
                }
                $data = [
                    'fullname'=>$miss_booking[0]->fullname,
                    'phone'=>$miss_booking[0]->phone,
                    'booking_date'=>$miss_booking[0]->booking_date,
                    'booking_time'=>$miss_booking[0]->booking_time,
                    'price'=>$miss_booking[0]->price,
                    'count'=>$miss_booking[0]->count,
                    'title'=>$result->title,
                    'email'=>$miss_booking[0]->email,
                    'address'=>$result->address,
                ];
                $dataSend['SendMailComposer'] = [
                    'data'=>$data,
                    'to_email'=>$to_email,
                ];
               // Mail::to($to_email)->send(new MyEmail('booking',$data));
            }
        }
        $this->addDataGlobal("Blog-featured-background",  'uploads/room/background/background.png');
        return $this->render('home.register_room_oke',$dataSend);
    }
    public function get_escape_room(){
        return $this->render('home.escape_room');
    }
    public function get_faqs(){
        $results = DB::table('plugin_faq')->where('status',1)->get()->all();
        $config_language = app()->config_language;
        if(isset($config_language['lang'])){
            $translation = DB::table('plugin_faq_translation')->where('lang_code',$config_language['lang'])->get()->keyBy('_id')->all();
            $this->addDataGlobal("Blog-featured-title",z_language('Frequently Asked Questions'));
            $this->addDataGlobal("Blog-featured-style",2);
            $this->addDataGlobal("Blog-featured-background", '/theme/missterry/images/IMG_2769-1.jpg');
            foreach ($results as $key=>$value){
                if(isset($translation[$value->id])){
                    $value->title = $translation[$value->id]->title;
                    $value->content = $translation[$value->id]->content;
                }
            }
        }
        return $this->render('home.faqs',['results'=>$results]);
    }
    public function get_offer(){

        if(isset($this->config_language['lang'])){
            $results = DB::table('categories_translation')->where('_id',50)->where('lang_code',$this->config_language['lang'])->get()->all();

            $this->addDataGlobal("Blog-featured-title",$results[0]->name);

            $models = DB::table('blog_post')->where('blog_post.category_id',$results[0]->_id);
            $models->join('blog_post_translation as rt', 'rt._id', '=', 'blog_post.id');
            $models->where('lang_code',$this->config_language['lang']);

            $total_records = $models->count();

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 4;
            $total_page = ceil($total_records / $limit);
            if ($current_page > $total_page){
                $current_page = $total_page;
            }
            else if ($current_page < 1){
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;
            $results = $models->offset($start)->limit($limit)->get()->all();

            return $this->render('home.offer',[
                'results'=>$results,
                'pagination'=>[
                    'current_page'=>$current_page,
                    'total_page'=>$total_page,
                ]
            ]);
        }
    }
    public function get_news(){
        if(isset($this->config_language['lang'])){
            $results = DB::table('categories_translation')->where('_id',12)->where('lang_code',$this->config_language['lang'])->get()->all();

            $this->addDataGlobal("Blog-featured-title",$results[0]->name);
            $this->addDataGlobal("Blog-featured-style",2);
            $this->addDataGlobal("Blog-featured-background", '/theme/missterry/images/IMG_2769-1.jpg');
            $models = DB::table('blog_post')->where('blog_post.category_id',$results[0]->_id);
            $models->join('blog_post_translation as rt', 'rt._id', '=', 'blog_post.id');
            $models->where('lang_code',$this->config_language['lang']);
            $total_records = $models->count();

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 4;
            $total_page = ceil($total_records / $limit);
            if ($current_page > $total_page){
                $current_page = $total_page;
            }
            else if ($current_page < 1){
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;
            $results = $models->offset($start)->limit($limit)->get()->all();

            return $this->render('home.blog-list',[
                'results'=>$results,
                'pagination'=>[
                    'current_page'=>$current_page,
                    'total_page'=>$total_page,
                ]
            ]);
        }
        return $this->render('home.news');
    }
    public function get_contact(){
        return $this->render('home.contact');
    }
    public function get_blog_people_talk_about_about($slug){

        $config_language = app()->config_language;
        $result = [];
        if(isset($config_language['lang'])){
            $db = DB::table('blog_post_translation')->where('slug',$slug)->get()->all();
            if(count($db) > 0){
                $results = DB::table('blog_post')->where('id',$db[0]->_id)->get()->all();
                if(isset($results[0])){
                    $result = $results[0];
                    $result->title = $db[0]->title;
                    $result->content = $db[0]->content;
                    $result->slug = $db[0]->content;
                    $this->addDataGlobal("Blog-featured-title",$result->title);
                }
            }
        }
        return $this->render('home.blog-item',['result'=>$result,'url'=>url()->current()]);
    }
    public function get_blog_item($slug){

        $config_language = app()->config_language;
        $result = [];
        $tags = [];
        if(isset($config_language['lang'])){
            $db = DB::table('blog_post_translation')->where('slug',$slug)->where('lang_code',$config_language['lang'])->get()->all();
            if(count($db) > 0){
                $results = DB::table('blog_post')->where('id',$db[0]->_id)->get()->all();
                if(isset($results[0])){
                    $result = $results[0];
                    $result->title = $db[0]->title;
                    $result->content = $db[0]->content;
                    $result->slug = $db[0]->content;
                    $this->addDataGlobal("Blog-featured-title",$result->title);
                }
                $results_tag = DB::table('tag_item')->where('item_id',$db[0]->_id)->get()->keyBy('tag_id')->all();
                $tag_keys = array_keys($results_tag);

                if(isset($tag_keys[0])){
                    $tags =  DB::table('tag')->whereIn('id',$tag_keys)->get()->all();
                }
            }
        }

        return $this->render('home.blog-item',['result'=>$result,'url'=>url()->current(),'tags'=>$tags]);
    }
    public function get_list_blog_category($slug){

      //  $this->addDataGlobal("Blog-featured-title",$result->title);
        if(isset($this->config_language['lang'])){
            $results = DB::table('categories_translation')->where('slug',$slug)->where('lang_code',$this->config_language['lang'])->get()->all();

            $this->addDataGlobal("Blog-featured-style",2);
            $this->addDataGlobal("Blog-featured-background",  'theme/missterry/images/IMG_2769-1.jpg');
            $this->addDataGlobal("Blog-featured-title",$results[0]->name);

            $models = DB::table('blog_post')->where('blog_post.category_id',$results[0]->_id);
            $models->join('blog_post_translation as rt', 'rt._id', '=', 'blog_post.id');
            $models->where('lang_code',$this->config_language['lang']);
            $total_records = $models->count();

            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $limit = 4;
            $total_page = ceil($total_records / $limit);
            if ($current_page > $total_page){
                $current_page = $total_page;
            }
            else if ($current_page < 1){
                $current_page = 1;
            }

            $start = ($current_page - 1) * $limit;
            $results = $models->offset($start)->limit($limit)->get()->all();

            return $this->render('home.blog-list',[
                'results'=>$results,
                'pagination'=>[
                    'current_page'=>$current_page,
                    'total_page'=>$total_page,
                ]
            ]);
        }
    }
    public function get_franchise(){

        $this->addDataGlobal("Blog-featured-style",  1);
        $this->addDataGlobal("Blog-featured-background",  'theme/missterry/images/IMG_2769-1.jpg');
        $this->addDataGlobal("Blog-featured-height",  '268px');
        $this->addDataGlobal("Blog-featured-title",  z_language('Nhượng quyền thương mại'));
        return $this->render('home.franchise');
    }
    public function get_Tag($slug){
        $this->addDataGlobal("Blog-featured",  false);
        if(isset($this->config_language['lang'])){
            $tag = DB::table('tag')->where('type','blog:post')->where('slug',$slug)->get()->all();
            $rowNew = [];
            $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
            $total_page = 0;
            $model = new \stdClass();
            if(isset($tag[0])){
                $model = $tag[0];
                $tag_item = DB::table('tag_item')->where('tag_id',$tag[0]->id)->get()->keyBy('item_id')->all();
                $arrays_id = array_keys($tag_item);
                if(isset($arrays_id[0])){
                    $blog_post_translation = DB::table('blog_post_translation')->where('lang_code',$this->config_language['lang'])->whereIn('_id',$arrays_id)->get()->keyBy('_id')->all();
                    $models = DB::table('blog_post')->whereIn('id',$arrays_id);
                    $total_records = $models->count();
                    $limit = 8;
                    $total_page = ceil($total_records / $limit);
                    if ($current_page > $total_page){
                        $current_page = $total_page;
                    }
                    else if ($current_page < 1){
                        $current_page = 1;
                    }

                    $start = ($current_page - 1) * $limit;
                    $results = $models->offset($start)->limit($limit)->get()->all();

                    foreach ($results as $id=>$item){
                        if(isset($blog_post_translation[$item->id])){
                            $item->title = $blog_post_translation[$item->id]->title;
                            $item->content = $blog_post_translation[$item->id]->content;
                            $item->slug = $blog_post_translation[$item->id]->slug;
                            $rowNew[] = $item;
                        }
                    }
                }
            }
            return $this->render('home.tag',[
                'items'=>$rowNew,
                'model'=>$model,
                'pagination'=>[
                    'current_page'=>$current_page,
                    'total_page'=>$total_page,
                ]
            ]);
        }
    }

}
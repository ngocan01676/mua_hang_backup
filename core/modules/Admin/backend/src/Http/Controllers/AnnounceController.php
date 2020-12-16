<?php

namespace Admin\Http\Controllers;
use Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Admin\Http\Models\AnnounceModel;
class AnnounceController extends \Zoe\Http\ControllerBackend{
    public function getCrumb()
    {
        $this->breadcrumb(z_language("Announce"), ('backend:announce:list'));
        return $this;
    }
    public function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
        $this->data['roles'] = DB::table('role')->get()->all();
        $this->data['admins'] = DB::table('admin')->get()->all();
    }

    public function list(Request $request)
    {
        $this->getcrumb();
        $search = $request->query('search', "");
        $status = $request->query('status', "");
        $date = $request->query('date', "");

        $config = config_get('option', "core:announce");
        $item = isset($config['pagination']['item']) ? $config['pagination']['item'] : 20;

        $models = DB::table('announce');
        if (!empty($search)) {
            $models->where('title', 'like', '%' . $search);
        }
        if (!empty($status) || $status != "") {
            $models->where('status', $status);
        }
        $models->orderBy('id', 'desc');
        return $this->render('announce.lists', [
            'models' => $models->paginate($item),
            'callback' => [
                "get_name" => function ($model){
                    if($model->type == 1){
                        return "Tất cả";
                    }
                    if($model->type == 2){
                        $rs = DB::table('admin')->where('id',$model->action_id)->get()->all();
                        if(isset($rs[0])){
                            return $rs[0]->username;
                        }
                    }
                    if($model->type == 3){
                        $rs = DB::table('role')->where('id',$model->action_id)->get()->all();
                        if(isset($rs[0])){
                            return $rs[0]->name;
                        }
                    }
                    return "Không xác định";
                }
            ]
        ]);
    }
    public function create(Request $request)
    {
        $this->getcrumb()->breadcrumb(z_language('Tạo thông báo'), false);
        return $this->render('announce.create', []);
    }
    public function edit($id)
    {
        $this->getcrumb()->breadcrumb(z_language('Sửa thông báo'), false);
        $model = AnnounceModel::find($id);
        return $this->render('announce.edit', ["model" => $model]);
    }

    public function delete(Request $request)
    {
        $id = $request->id;
        $ref = $request->ref;
        $model = AnnounceModel::find($id);
        if($model){
             $model->delete();
        }
        if($ref){
            return redirect($ref);
        }else{
            return redirect(route('backend:announce:list', []));
        }
    }

    public function status()
    {

    }

    public function store(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => 'required',
            'message' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ], [
            'title.required' => z_language('Tên không được phép bỏ trống.'),
        ]);
        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }
        $type = 'create';
        if (isset($data['id']) && !empty($data['id'])) {
            $model = AnnounceModel::find($data['id']);
            $type = 'edit';
        } else {
            $model = new AnnounceModel();
        }
        try {
            $model->title = $data['title'];
            $model->action_id = $data['action_id'];
            $model->type = $data['type'];
            $model->message = $data['message'];
            $model->date_start = date('Y-m-d',strtotime($data['date_start']));
            $model->date_end = date('Y-m-d',strtotime($data['date_end']));
            $model->status = $data['status'];
            $model->save();
            $this->log('announce:edit',$type,['id'=>$model->id]);
            $request->session()->flash('success',z_language('Cập nhật thông tin thành công'));
            return redirect(route('backend:announce:edit', ['id' => $model->id]));
        }catch (\Exception $ex){
            $validator->getMessageBag()->add('id', $ex->getMessage());
        }

        return back()
            ->withErrors($validator)
            ->withInput();
    }
}
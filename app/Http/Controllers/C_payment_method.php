<?php

namespace App\Http\Controllers;

use App\Models\M_payment_method;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use RSAService;
use Image;
use File;

class C_payment_method extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'id_type'     => 'required',
            'name'     => 'required',
            'stock'     => 'required',
            'price'     => 'required'
        ]);
    }

    public function getData(Request $request){
      
        $response = array();
        $result = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "name";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaTicket = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "payment_method";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "payment_method";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_payment_method::select("*")
            ->orWhere('payment_method', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_payment_method::select("*")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }

        $count = count(M_payment_method::get());       
        $response['data'] = array();
        $response['recordsFiltered'] = $count;
        $response['recordsTotal']    = $count;
        $response['count'] = $count;
        if ($query->count() == 0){
          $response['code'] = 401;
        }else{
          $response['data']= $query;
        }
    //    dd($response);
        echo json_encode($response);
    }

    public function pageRoom($id = null){
        $data = [];
        if($id !== null){
            $query = M_payment_method::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.payment_method.index')->with($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_payment_method::where("id_payment_method", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.payment_method.form')->with($response);
    }

    public function getStore($id = null){
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        if($id == null){
            $query = M_payment_method::orderBy("created_at", "desc")->get();
        }else{
            $query = M_payment_method::where("id", "=", $id)->orderBy("created_at", "desc")->get();
        }
        $response['data'] = $query;

        $response['count']= count($response['data']);
		return response()->json($response);
    }

    public function create(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Save successful",
            'role' => []
        );

        $params = RSAService::decrypte();
        $params['id_payment_method'] = Uuid::uuid4()->toString();
        $params['payment_method'] = $params['method'];
        $params['created_at'] = date('Y-m-d');
        if($params['method'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "method is required",
            ));
        }

        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        //dd($params);
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_payment_method::create($params);
            if(!$query){
                $response['code'] = 401;
            }else{
                $response['code'] = 200;
            }
                
        }
        catch(Exception $e) {
            //  Block of code to handle errors
            $response['message'] = $e;
            $response['code'] = 401;
        }

        if ($response['code']==200) {
            DB::commit();
        }else{
            DB::rollBack();
        }
		return response()->json($response);
    }

    public function update(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Update successful",
            'role' => []
        );

        $params = RSAService::decrypte();
        if($params['type'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Event Name is required",
            ));
        }
        
        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        //dd($params); 
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_payment_method::where("id", "=", $params['id']);
            $query = $query->update($params);
            if(!$query){
                $response['code'] = 401;
            }else{
                $response['code'] = 200;
            }
        }
        catch(Exception $e) {
            //  Block of code to handle errors
            $response['message'] = $e;
            $response['code'] = 401;
        }

        if ($response['code']==200) {
            DB::commit();
        }else{
            DB::rollBack();
        }
		return response()->json($response);
    }

    public function posting(Request $reques){
        $params = RSAService::decrypte();
        dd($params);
    }
    
    public function delete(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Delete successful",
            'role' => []
        );

        $params = RSAService::decrypte();

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_payment_method::where("id", "=", $params['id']);
            $query = $query->delete();
            if(!$query){
                $response['code'] = 401;
                $response['message'] = "Delete failure";
            }  
        }
        catch(Exception $e) {
            //  Block of code to handle errors
            $response['message'] = $e;
            $response['code'] = 401;
        }

        if ($response['code']==200) {
            DB::commit();
        }else{
            DB::rollBack();
        }
		return response()->json($response);
    }

    // public function upload_image(Request $request){
    //     $response = array(
    //         'code' => 200,
    //         'message' => "Upload successful",
    //         'role' => []
    //     );
        
    //     $file = $request->file('image');
    //     $fileCrop = $request->file('image_crop');
    //     if($file !== null && $file !== 'null'){
    //         $block = str_replace(" ", "_", $request->input('id'));
    //         $destinationPath = './assets/uploads/event/'.$block."/";
    //         $path = public_path()."/assets/uploads/event/".$block;
    //         File::deleteDirectory($path);

    //         if(!File::exists($path."/".$file->getClientOriginalName().".".$file->getClientOriginalExtension())){
    //             $name = time()."-cover";
    //             // Mendapatkan Extension File
    //             $ext  = $file->getClientOriginalExtension();
        
    //             // Mendapatkan Ukuran File
    //             $size = $file->getSize();
        
    //             // Proses Upload File
    //             if(!File::exists($path)) {
    //                 if(!File::makeDirectory($path, $mode = 0777, true, true)){
    //                     $response['code']     = 401;
    //                     $response['message']  = "Upload image failed";
    //                     return $response;
    //                 }
    //             }
    
    //             if($fileCrop->move($destinationPath, $name."-crop".".".$ext)){
    //                 if($file->move($destinationPath, $name."-ori".".".$ext)){
    //                     $params['image'] = $name."-ori";
    //                     $params['path'] = $destinationPath;
    //                     $params['ext'] = $ext;
    //                     $response['image'] = $destinationPath.$name."-crop".".".$ext;
    //                     return response()->json($response);
    //                 }
    //             }
    //         }else{
    //             $params['image'] = $file->getClientOriginalName();
    //             $params['path'] = $destinationPath;
    //             $params['ext'] = $file->getClientOriginalExtension();
    //             $response['image'] = $destinationPath.$name."-crop".".".$ext;
    //             return response()->json($response);
    //         }
    //     }
    // }
    
}

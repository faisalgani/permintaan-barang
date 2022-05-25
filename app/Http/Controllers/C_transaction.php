<?php

namespace App\Http\Controllers;

use App\Models\M_transaction;
use App\Models\M_room;
use App\Models\M_detail_transaction;
use App\Models\M_customer;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use RSAService;
use Image;
use File;

class C_transaction extends Controller
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
            $orderBy = "date_transaction";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "date_transaction";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_transaction::select("*")
            ->orWhere('transaction_to_customer.name', 'like', "%".$request->input("search.value")."%")
            ->with("transaction_to_detail")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_transaction::select("*")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->with("transaction_to_detail")
            ->orderBy($orderBy, $orderDir)
            ->get();
        }

        $count = count(M_transaction::get());       
        $response['data'] = array();
        $response['recordsFiltered'] = $count;
        $response['recordsTotal']    = $count;
        $response['count'] = $count;
        if ($query->count() == 0){
          $response['code'] = 401;
        }else{
          $response['data']= $query;
          $response['sold']= $query;
        }
    //    dd($response);
        echo json_encode($response);
    }

    public function pageRoom($id = null){
        $data = [];
        if($id !== null){
            $query = M_room::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.transaction.index')->with($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_room::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.transaction.form')->with($response);
    }

    public function getStore($id = null){
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        if($id == null){
            $query = M_room::orderBy("created_at", "desc")->get();
        }else{
            $query = M_room::where("id", "=", $id)->orderBy("created_at", "desc")->get();
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
    //  dd($params);
        
        
        if($params['customer_name'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Name is required",
            ));
        }

        if($params['customer_nik'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "NIK is required",
            ));
        }

        if($params['customer_phone_number'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Phone Number is required",
            ));
        }

        if($params['id_room'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Room is required",
            ));
        }


        if($params['qty'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Quantity is required",
            ));
        }

        if($params['day_stay'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "Day Stay is required",
            ));
        }

        

        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        $params['date_transaction'] = date("Y-m-d");
        $get_price_room = M_room::select("*")->where("id_room", "=", $params['id_room'])->get();
        foreach ($get_price_room as $value) {
            $price = $value['price'];
        }
        
        $tmp_id =  Uuid::uuid4()->toString();
        $params['total_price'] = $price * $params['day_stay'] * $params['qty'] ;
        $params_transaction['id_transaction'] =$tmp_id;
        $params_transaction['date_transaction'] = date("Y-m-d"); 
        $params_transaction['customer_name'] = $params['customer_name']; 
        $params_transaction['customer_nik'] = $params['customer_nik']; 
        $params_transaction['customer_phone_number'] = $params['customer_phone_number']; 
        $params_transaction['id_payment_method'] = $params['id_payment_method'];  


        $params_customer['id_customer'] = Uuid::uuid4()->toString();   
        $params_customer['name'] = $params['customer_name'];
        $params_customer['nik'] = $params['customer_nik'];
        $params_customer['phone_number'] = $params['customer_phone_number'];

        $params_detail['id_detail_transaction'] =Uuid::uuid4()->toString();
        $params_detail['id_transaction'] =   $tmp_id;
        $params_detail['date_detail_transaction'] =  date('Y-m-d');
        $params_detail['id_room'] =  $params['id_room'];
        $params_detail['day_stay'] =  $params['day_stay'];
        $params_detail['total_price'] =  $params['total_price'];
        $params_detail['qty'] =   $params['qty'];
        
        $params_update['stock'] = 


        //  dd($params_detail);
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_transaction::create($params_transaction);
            $query2 = M_detail_transaction::create($params_detail);
            $queryCus = M_customer::create($params_customer);

            $update = DB::statement("UPDATE room set stock = stock - '".$params['qty']."' WHERE id_room = '".$params['id_room']."' ");
            
            if(!$query && !$query2 && $queryCus){
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
        if($params['event_name'] == ""){
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
            $query = M_room::where("id", "=", $params['id']);
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
            $query = M_room::where("id", "=", $params['id']);
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

<?php

namespace App\Http\Controllers;

use App\Models\M_ticket_sell;
use App\Models\M_ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use RSAService;
use Image;
use File;

class C_ticket_sell extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'id_ticket'     => 'required',
        ]);
    }

    public function create(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Save successful",
            'role' => []
        );

        $params = $request->all();
        $data = array();
    	$params['id'] = Uuid::uuid4()->toString();
        $params['created_at'] = date('Y-m-d');
        //dd($params);
        $data['terjual'] = $params['sold'];
        $data['updated_at'] = date("Y-m-d");
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_ticket_sell::create($params);
            if(!$query){
                $response['code'] = 401;
            }else{
                $response['code'] = 200;
                $query = M_ticket::where("id", "=", $params['id_ticket']);
                $query = $query->update($data);
                // DB::statement("UPDATE tickets SET terjual = terjual+'".$params['sold']."' 
                // where id = '".$params['id_ticket']."' ");
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
    
}

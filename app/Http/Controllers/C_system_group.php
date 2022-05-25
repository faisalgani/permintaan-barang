<?php

namespace App\Http\Controllers;

use App\Models\M_system_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RSAService;

class C_system_group extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'first_name'     => 'required',
            'email'     => 'required',
        ]);
    }

    //
    public function getData(Request $request){
        $response = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "group";
        $orderDir = $request->input("order")[0]['dir'];

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_system_group::select("*")
            ->orWhere('group', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_system_group::select("*")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
        
        $count = count(M_system_group::get());
        $response['data'] = array();
        $response['recordsFiltered'] = $count;
        $response['recordsTotal']    = $count;
        $response['count'] = $count;
        if ($query->count() == 0){
          $response['code'] = 401;
        }else{
          $response['data']            = $query;
        }
        echo json_encode($response);
    }

    public function getStore($id = null){
        $response = array();
        $response['code']  = 200;
        
        if($id == null){
            $query = M_system_group::select("*")->get();
        }else{
            $query = M_system_group::select("*")
            ->where("id", "=", $id)
            ->get();
        }

        if (count($query) == 0){
          $response['code'] = 401;
        }else{
          $response['data'] = $query;
        }
        echo json_encode($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_system_group::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.users.form')->with($response);
    }

    public function create(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Save successful",
            'role' => []
        );


        $params = RSAService::decrypte();
        if($params['group'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "group",
                'message' => "Group is required",
            ));
        }

        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_group::where("group", "=", $params['group'])->get();
            if(count($query)){
                $response['code'] = 401;
                array_push($response['role'], array(
                    'key' => "group",
                    'message' => "Group is already",
                ));
                $response['message'] = "Please check and fill the fields";
                return response()->json($response);
            }

            $query = M_system_group::create($params);
            if(!$query){
                $response['code'] = 401;
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
        if($params['group'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "group",
                'message' => "Group name is required",
            ));
        }
        
        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_group::where("group", "=", $params['group'])->get();
            if(count($query)){
                if($query[0]->id !== $params['id']){
                    $response['code'] = 401;
                    array_push($response['role'], array(
                        'key' => "group",
                        'message' => "Group is already",
                    ));
                    $response['message'] = "Please check and fill the fields";
                    return response()->json($response);
                }
            }
            $query = M_system_group::where("id", "=", $params['id']);
            $query = $query->update($params);
            if(!$query){
                $response['code'] = 401;
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
            $query = M_system_group::where("id", "=", $params['id']);
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
}

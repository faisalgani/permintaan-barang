<?php

namespace App\Http\Controllers;

use App\Models\M_users;
use App\Models\M_auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;
use RSAService;

class C_users extends Controller
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
        $orderBy = "first_name";
        $orderDir = "asc";

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "first_name";
        }else if($request->input("order")[0]['column'] == 1){
            $orderBy = "address";
        }else if($request->input("order")[0]['column'] == 2){
            $orderBy = "phone";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "email";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_users::select("*")
            ->orWhere('first_name', 'like', "%".$request->input("search.value")."%")
            ->orWhere('last_name', 'like', "%".$request->input("search.value")."%")
            ->orWhere('address', 'like', "%".$request->input("search.value")."%")
            ->orWhere('phone', 'like', "%".$request->input("search.value")."%")
            ->orWhere('email', 'like', "%".$request->input("search.value")."%")
            ->whereRaw(" deleted_at is null ")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_users::select("*")
            ->whereRaw(" deleted_at is null ")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
  
        $count = count(M_users::get());
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
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        $query = DB::table('users')
        ->select(DB::raw("users.*"))
        ->get();
        $response['data'] = $query;

        $response['count']= count($response['data']);
		return response()->json($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_users::where("id", "=", $id)->with('user_to_auth')->get();
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
        $params['birthdate'] = date_format(date_create($params['birthdate']),"Y-m-d");
        if($params['first_name'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "first_name",
                'message' => "First name is required",
            ));
        }
        
        if($params['email'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "email",
                'message' => "Email is required",
            ));
        }
        
        if($params['password'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "password",
                'message' => "Password is required",
            ));
        }else{
            if($params['password'] !== $params['re_password']){
                $response['code'] = 401;
                array_push($response['role'], array(
                    'key' => "re_password",
                    'message' => "Retype password not same with pasword",
                ));
            }
        }

        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }

        $parameter = array();
        $parameter['password'] = Hash::make($params['password']);
        if($params['username'] !== "" && $params['username'] !== null){
            $parameter['username'] = $params['username'];
        }
        unset($params['username']);
        unset($params['password']);
        unset($params['re_password']);

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_users::where("email", "=", $params['email'])->get();
            if(count($query)){
                $response['code'] = 401;
                array_push($response['role'], array(
                    'key' => "email",
                    'message' => "Email is already",
                ));
                $response['message'] = "Please check and fill the fields";
                return response()->json($response);
            }

            $query = M_users::create($params);
            if(!$query){
                $response['code'] = 401;
            }else{
                $query = M_auth::where("id", "=", $params['id']);
                $query = $query->update($parameter);
                
                if(!$query){
                    $response['code'] = 401;
                }else{
                    if($query){
                        $tmpParams = array(
                            'id' => Uuid::uuid4()->toString(),
                            'id_user' => $params['id'],
                            'id_group' => '6a106a98-f83d-40d8-ac0b-f0e20ee7166f',
                        );
                        app(\App\Http\Controllers\C_system_member::class)->createProcess($tmpParams);
                    }
                }
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
        $params['birthdate'] = date_format(date_create($params['birthdate']),"Y-m-d");
        if($params['first_name'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "first_name",
                'message' => "First name is required",
            ));
        }
        
        if($params['email'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "email",
                'message' => "Email is required",
            ));
        }
        if($params['password'] !== $params['re_password']){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "re_password",
                'message' => "Retype password not same with pasword",
            ));
        }
        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        
        $parameter = array();
        if($params['username'] !== "" && $params['username'] !== null){
            $parameter['username'] = $params['username'];
        }
        if($params['password'] !== "" && $params['password'] !== null){
            $parameter['password'] = Hash::make($params['password']);
        }
        unset($params['username']);
        unset($params['password']);
        unset($params['re_password']);

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_users::where("email", "=", $params['email'])->get();
            if(count($query)){
                if($query[0]->id !== $params['id']){
                    $response['code'] = 401;
                    array_push($response['role'], array(
                        'key' => "email",
                        'message' => "Email is already",
                    ));
                    $response['message'] = "Please check and fill the fields";
                    return response()->json($response);
                }
            }
            $query = M_users::where("id", "=", $params['id']);
            $query = $query->update($params);
            if(!$query){
                $response['code'] = 401;
            }else{
                if(count($parameter) > 0){
                    $query = M_auth::where("id", "=", $params['id']);
                    $query = $query->update($parameter);
                    if(!$query){
                        $response['code'] = 401;
                    }
                }
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
            $query = M_users::where("id", "=", $params['id']);
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

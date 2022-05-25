<?php

namespace App\Http\Controllers;

use Session;
use RSAService;
use App\Models\M_auth;
use App\Models\M_users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class C_auth extends Controller
{
    //
    public function login(Request $request){
        $response = array(
            'message'   => "Result OK",
            'code'      => 200,
            'role'      => [],
        );
        $params = RSAService::decrypte();
        DB::beginTransaction();

        if($params['username'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "username",
                'message' => "Username is required",
            ));
        }

        if($params['password'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "password",
                'message' => "Password is required",
            ));
        }

        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }
        
        $query = M_auth::where('username', '=', $params['username'])
        ->first();
        
        if(!$query){
            $query = M_users::where('email', '=', $params['username'])
            ->first();
            
            if($query){
                $query = M_auth::where('id', '=', $query->id)
                ->first();
            }
        }
        
        if($query){
            if(!Hash::check($params['password'], $query->password)){
                $response = array(
                    'message'   => "Username and password is wrong",
                    'code'      => 401
                );
                return response()->json($response);
            }

            // if($query->active == 0){
            //     $response = array(
            //         'message'   => "Need confirmation, please check your email",
            //         'code'      => 401
            //     );
            //     return response()->json($response);
            // }
        }else{
            $response = array(
                'message'   => "Username and password is wrong",
                'code'      => 401
            );
            return response()->json($response);
        }
        $query = M_users::where('id',"=", $query->id)->first();
        if($query){
            Session::put('id_user', $query->id);
            Session::put('first_name', $query->first_name);
            Session::put('last_name', $query->last_name);
            Session::put('email', $query->email);
        }
        if ($response['code']==200) {
            DB::commit();
        }else{
            DB::rollBack();
        }
		return response()->json($response);
    }
    
    public function getTrustee($parameter = null){
        $response = array();
        $response['code'] = 200;
        if($parameter == null){
            $response['message'] = "Please check the parameter";
            $response['code'] = 401;
            return response()->json($response);
        }
        $query = M_users::where('id',"=", $parameter);
        if ($query->count() > 0) {
            $menu = DB::table('users')
            ->join('system_member', 'system_member.id_user', '=', 'users.id')
            ->join('system_group', 'system_group.id', '=', 'system_member.id_group')
            ->join('system_role', 'system_role.id_group', '=', 'system_group.id')
            ->join('system_menu', 'system_menu.id', '=', 'system_role.id_menu')
            ->select(
                'system_menu.id', 
                'system_menu.menu', 
                'system_menu.link', 
                'system_menu.icon', 
                'system_menu.active', 
                'system_menu.parent', 
                'system_menu.class', 
                'system_menu.order'
            )
            ->where('users.id', $parameter)
            ->where('system_member.active', true)
            ->where('system_group.active', true)
            ->where('system_role.active', true)
            ->where('system_menu.active', true)
            ->groupBy(
                'system_menu.id', 
                'system_menu.menu', 
                'system_menu.link', 
                'system_menu.icon', 
                'system_menu.active', 
                'system_menu.parent', 
                'system_menu.class', 
                'system_menu.order')
            ->orderBy('order', 'asc')
            ->get();
            $response['menu'] 		= $menu;
            $response['id'] 		= $parameter;
        }else{
            $response['message'] = "User not found";
            $response['code'] = 401;
        }
        
		return response()->json($response);
    }

    public function logoutPage($url = null){
        Session::flush();
		return redirect()->route('/');
    }
}

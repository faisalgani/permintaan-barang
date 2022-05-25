<?php

namespace App\Http\Controllers;

use App\Models\M_system_menu;
use App\Models\M_user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RSAService;

class C_system_menu extends Controller
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
            $query              = M_system_menu::select("*")
            ->orWhere('group', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
            $response['count'] = count($query);
        }else{
            $query              = M_system_menu::select("*")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
            $response['count'] = count($query);
        }
  
        $response['data'] = array();
        $response['recordsFiltered'] = $response['count'];
        $response['recordsTotal']    = $response['count'];
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

        if($id == null){
            $query = M_system_menu::orderBy("order", "asc")->get();
        }else{
            $query = M_system_menu::where("id", "=", $id)->orderBy("order", "asc")->get();
        }
        $response['data'] = $query;

        $response['count']= count($response['data']);
		return response()->json($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_system_menu::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.system_menu.form')->with($response);
    }

    public function create(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Save successful",
            'role' => []
        );


        $params = RSAService::decrypte();
        if($params['menu'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "menu",
                'message' => "Menu label is required",
            ));
        }
        
        if($params['link'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "link",
                'message' => "Link is required",
            ));
        }
        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_menu::create($params);
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
        if($params['menu'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "menu",
                'message' => "Menu label is required",
            ));
        }
        
        if($params['link'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "link",
                'message' => "Link is required",
            ));
        }
        if($response['code'] == 401){
            $response['message'] = "Please check and fill the fields";
            return response()->json($response);
        }

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_menu::where("id", "=", $params['id']);
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
            $query = M_system_menu::where("id", "=", $params['id']);
            $query = $query->delete();
            if(!$query){
                $response['code'] = 401;
                $response['message'] = "Delete failure";
            }else{
                $query = M_system_menu::where("parent", "=", $params['id']);
                $query = $query->update(array(
                    'parent' => null,
                ));
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
    
    public function deleteByGroup(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Delete successful",
            'role' => []
        );

        $params = RSAService::decrypte();

        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_menu::where("id_group", "=", $params['id_group'])->get();
            if(count($query) > 0){
                $query = M_system_menu::where("id_group", "=", $params['id_group']);
                $query = $query->delete();
                if(!$query){
                    $response['code'] = 401;
                    $response['message'] = "Delete failure";
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
    
    public function reorder(Request $request){
        $response = array(
            'parameter' => $request->all(),
            'message'   => "Saving success",
            'code'      => 200
        );

        $params = RSAService::decrypte();
        DB::beginTransaction();
        try {
            //  Block of code to try
            $query = M_system_menu::find($params['id']);
            if(!$query){
                $response['message'] = "Update failure";
                $response['code'] = 401;
            }else{
                $query->update(array(
                    'order' => $params['order'],
                    'parent' => $params['parent'],
                ));
            }
            unset($response['parameter']);
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

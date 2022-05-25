<?php

namespace App\Http\Controllers;

use App\Models\departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RSAService;

class DepartemenController extends Controller
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
        $orderBy = "nama_departemen";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaTicket = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "nama_departemen";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "nama_departemen";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = departemen::select("*")
            ->orWhere('nama_departemen', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = departemen::select("*")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }

        $count = count(departemen::get());       
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

    public function page($id = null){
        $data = [];
        if($id !== null){
            $query = departemen::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.departemen.index')->with($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = departemen::where("id_room", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.departemen.form')->with($response);
    }

    public function getStore($id = null){
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        if($id == null){
            $query = departemen::orderBy("created_at", "ASC")->get();
        }else{
            $query = departemen::where("id", "=", $id)->orderBy("created_at", "ASC")->get();
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
        $key = departemen::latest()->value('id');
        if($key == null){
            $id= 1;
        }else{
            $id= $key+1;
        }
        $params = RSAService::decrypte();
        $params['id'] = $id;
        if($params['nama_departemen'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "nama departemen is required",
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
            $query = departemen::create($params);
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
            $query = departemen::where("id", "=", $params['id']);
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
            $query = departemen::where("id", "=", $params['id']);
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

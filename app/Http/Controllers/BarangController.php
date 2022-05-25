<?php

namespace App\Http\Controllers;

use App\Models\barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RSAService;

class BarangController extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'id'     => 'required',
            'nama_barang'     => 'required',
            'stok'     => 'required',
            'id_satuan'     => 'required',
            'id_lokasi'     => 'required'
        ]);
    }

    public function getData(Request $request){
        $response = array();
        $result = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "nama";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaTicket = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "nama_barang";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "nama_barang";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = barang::select("*")
            ->with('barang_to_satuan')
            ->with('barang_to_lokasi')
            ->orWhere('nama_barang', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = barang::select("*")
            ->with('barang_to_satuan')
            ->with('barang_to_lokasi')
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }

        $count = count(barang::get());       
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
            $query = barang::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.barang.index')->with($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = barang::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.barang.form')->with($response);
    }

    public function getStore($id = null){
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        if($id == null){
            $query = barang::orderBy("nama_barang", "desc")->get();
        }else{
            $query = barang::where("id", "=", $id)->orderBy("nama_barang", "desc")->get();
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

        $key = barang::latest()->value('id');
        if($key == null){
            $id= 1;
        }else{
            $id= $key+1;
        }
        $params = RSAService::decrypte();
        $params['id'] = $id;
        if($params['nama_barang'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "nama",
                'message' => "nama is required",
            ));
        }
        if($params['stok'] == ""){
            $response['stok'] = 401;
            array_push($response['role'], array(
                'key' => "stok",
                'message' => "stok is required",
            ));
        }
        if($params['id_lokasi'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "lokasi",
                'message' => "lokasi is required",
            ));
        }

        if($params['id_satuan'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "satuan",
                'message' => "satuan is required",
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
            $query = barang::create($params);
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
            $query = customer::where("id", "=", $params['id']);
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
            $query = barang::where("id", "=", $params['id']);
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

    
    public function getDataAuto(Request $request){
        $request->all();
        $param = $request->term;
        if($param != null){
            $query = barang::with('barang_to_satuan')->with('barang_to_lokasi')->where("stok", "!=", 0)->orderBy("nama_barang", "asc")->get();
        }else{
            $query = barang::with('barang_to_satuan')->with('barang_to_lokasi')->where("stok", "!=", 0)->where('nama_barang', 'like', "%".$param."%")->orderBy("nama_barang", "asc")->get();
        }
    //    dd($query);
        foreach ($query as $row){
            $response[] = array(
                 'label'      => $row->nama_barang,
                 'id_barang'=> $row->id,
                 'lokasi'=> $row->barang_to_lokasi->lokasi,
                 'satuan'=> $row->barang_to_satuan->satuan,
                 'stok'=> $row->stok
             ); 
         }
		return response()->json($response);
    }
}

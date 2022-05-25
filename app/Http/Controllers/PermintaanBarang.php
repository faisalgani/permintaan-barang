<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Models\barang;
use App\Models\detailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RSAService;

class PermintaanBarang extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'id_customer'     => 'required',
            'tgl_transaksi'     => 'required'
        ]);
    }

    public function getData(Request $request){
        $response = array();
        $result = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "satuan";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaTicket = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "tgl_transaksi";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "tgl_transaksi";
        }
     
        if (strlen($request->input("search.value")) > 0) {
            $query              = transaksi::select("*")
            ->with('transaksi_to_customer')
            ->orWhere('no_transaksi', 'like', "%".$request->input("search.value")."%")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = transaksi::select("*")
            ->with('transaksi_to_customer')
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
      
        $count = count(transaksi::get());       
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
            $query = transaksi::where("id", "=", $id)->get();
            $data = $query;
            
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.permintaan_barang.index')->with($response);
    }

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = transaksi::where("id_room", "=", $id)->get();
            $data = $query;
        }
        $data['produk'] = barang::orderBy("nama_barang", "ASC")->get();
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Formulir", $data);
        return view('cpanel.pages.permintaan_barang.form')->with($response);
    }

   

    public function getStore($id = null){
        $response = array(
            'count'     => 0,
            'data'      => [],
            'parameter' => $id,
            'code'      => 200
        );

        if($id == null){
            $query = transaksi::orderBy("created_at", "ASC")->get();
        }else{
            $query = transaksi::where("id", "=", $id)->orderBy("created_at", "ASC")->get();
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

        $key = transaksi::latest()->value('id');
        if($key == null){
            $id= 1;
        }else{
            $id= $key+1;
        }
        $params = $request->all();
        //dd($params['id_customer']);
        $params['id'] = $id;
        if($params['id_customer'] == ""){
            $response['code'] = 401;
            array_push($response['role'], array(
                'key' => "name",
                'message' => "pemesan is required",
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
            $paramTransaksi['id'] = $id;
            $paramTransaksi['no_transaksi'] = $this->get_no_trans();
            $paramTransaksi['tgl_transaksi'] = $params['tgl_transaksi'];
            $paramTransaksi['id_customer'] = $params['id_customer'];

           
            $query = transaksi::create($paramTransaksi);
            if(!$query){
                $response['code'] = 401;
            }else{
                $arr1 = explode('##[[]]##',$params['data_array']);
                for($i=0;$i<=count($arr1)-1;$i++) {
                   
                    $arr2 = explode("@@##$$@@",$arr1[$i]);
                    for($k=0;$k<=count($arr2)-1;$k++){
                        $paramsDetail['id_barang'] = $arr2[0];
                        $paramsDetail['qty'] = $arr2[1];
                        $paramsDetail['keterangan'] = $arr2[2];
                    }
                    $key_detail = DB::select("SELECT MAX(id_detail) as id_detail FROM detail_transaksi");
                    foreach($key_detail as $key){
                        $key_detail = $key->id_detail;
                    }
                   
                    if($key_detail == null){
                        $id_detail= 1;
                    }else{
                        $id_detail= (int)$key_detail+1;
                    }
                  
                    $paramsDetail['id_detail'] = $id_detail;
                    $paramsDetail['no_transaksi'] = $paramTransaksi['no_transaksi'];
                    $paramsDetail['tgl_transaksi'] = $params['tgl_transaksi'];
                  
                    $query_detail = detailTransaksi::create($paramsDetail);
                    $barang = barang::where(['id' => $arr2[0]])->first();
                        if($barang){
                            $stock = $barang->stok - (int) $arr2[1];
                            $barang->update(['stok' => $stock]);
                        }
                    if($query_detail || $barang){
                        $response['code'] = 200;
                    }else{
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

    public function update(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Update successful",
            'role' => []
        );

        $params = RSAService::decrypte();
        if($params['satuan'] == ""){
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
            $query = satuanBarang::where("id", "=", $params['id']);
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
            $query = satuanBarang::where("id", "=", $params['id']);
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

    public function get_no_trans(){
        $query = transaksi::latest()->value('id');
        if($query == null){
            $retVal= 1;
        }else{
            $retVal= $query+1;
        }
        if (strlen($retVal) == 1) {
			$retValreal = "000000".$retVal;
		}else if (strlen($retVal) == 2){
			$retValreal = "00000".$retVal;
		}else if (strlen($retVal) == 3){
			$retValreal = "0000".$retVal;
		}else if (strlen($retVal) == 4){
			$retValreal = "000".$retVal;
		}else if (strlen($retVal) == 5){
			$retValreal = "00".$retVal;
		}else if (strlen($retVal) == 6){
			$retValreal = "0".$retVal;
		}else{
			$retValreal = $retVal;
		}
        return $retValreal;
    }
}

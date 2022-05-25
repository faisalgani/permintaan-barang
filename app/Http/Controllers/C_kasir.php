<?php

namespace App\Http\Controllers;

use App\Models\M_pasien;
use App\Models\M_kunjungan;
use App\Models\M_transaksi;
use App\Models\M_detail_transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use RSAService;
use Image;
use File;

class C_kasir extends Controller
{
    private function checkValidation($request){
        $this->validate($request, [
            'kd_pasien'     => 'required',
            'kd_unit'     => 'required',
            'tgl_masuk'     => 'required',
            'urut_masuk'     => 'required',
        ]);
    }

    public function getData(Request $request){
        $response = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "tgl_masuk";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaPasienTB = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "tgl_transaksi";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "tgl_transaksi";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_transaksi::select("*")
            ->orWhere('pasien.nama', 'like', "%".$request->input("search.value")."%")
            ->orWhere('kd_pasien', 'like', "%".$request->input("search.value")."%")
            ->join('pasien', 'pasien.kd_pasien', '=', 'kunjungan.kd_pasien')
            ->join('unit', 'unit.kd_unit', '=', 'kunjungan.kd_unit') 
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_transaksi::select("*")
            ->with("transaction_to_pasien")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
  
        $count = count(M_transaksi::get());
        $response['data'] = array();
        $response['recordsFiltered'] = $count;
        $response['recordsTotal']    = $count;
        $response['count'] = $count;
        if ($query->count() == 0){
          $response['code'] = 401;
        }else{
          $response['data']= $query;
        }
        // dd($response);
        echo json_encode($response);
    }

    public function getProduk($no_peserta){
        $url= "http://192.168.100.8:85/asuransi/asuransi-api/api/claim/get_produk/"; 
		$opts = array('http'=>array('method'=>'GET'));
		$context = stream_context_create($opts);
		$res = json_decode(file_get_contents($url.$no_peserta,false,$context));
		return $res;
    }


    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_transaksi::with('transaction_to_pasien')->where("no_transaksi", "=", $id)->get();
            $no_kartu = M_pasien::where("kd_pasien", "=", $query[0]->kd_pasien)->get();
            $data = $query;
            $data['produk'] = $this->getProduk($no_kartu[0]->no_asuransi);
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Kasir", $data);
        return view('cpanel.pages.kasir.form')->with($response);
    }

    public function pageKasir($id = null){
        $data = [];
        if($id !== null){
            $query = M_transaksi::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Kasir", $data);
        return view('cpanel.pages.kasir.index')->with($response);
    }

    public function getDetailTransaksi(){
        $response = array();
        $response['code']  = 200;
        $response['draw']  = $request->input("draw");
        $orderBy = "tgl_masuk";
        $orderDir = $request->input("order")[0]['dir'];
        $criteriaPasienTB = [];

        if($request->input("order")[0]['column'] == 0){
            $orderBy = "urut";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "urut";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_detail_transaksi::select("*")
            ->orWhere('produk.nama_produk', 'like', "%".$request->input("search.value")."%")
            ->join('produk', 'produk.kd_produk', '=', 'detail_transaksi.kd_produk')
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_detail_transaksi::select("*")
            ->with("detail_transaksi_to_produk")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
  
        $count = count(M_detail_transaksi::get());
        $response['data'] = array();
        $response['recordsFiltered'] = $count;
        $response['recordsTotal']    = $count;
        $response['count'] = $count;
        if ($query->count() == 0){
          $response['code'] = 401;
        }else{
          $response['data']= $query;
        }
        // dd($response);
        echo json_encode($response);
    }

    
    
}

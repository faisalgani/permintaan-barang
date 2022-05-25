<?php

namespace App\Http\Controllers;

use App\Models\M_pasien;
use App\Models\M_kunjungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use RSAService;
use Image;
use File;

class C_pendaftaran extends Controller
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
            $orderBy = "tgl_masuk";
        }else if($request->input("order")[0]['column'] == 3){
            $orderBy = "tgl_masuk";
        }

        if (strlen($request->input("search.value")) > 0) {
            $query              = M_kunjungan::select("*")
            ->orWhere('pasien.nama', 'like', "%".$request->input("search.value")."%")
            ->orWhere('kd_pasien', 'like', "%".$request->input("search.value")."%")
            ->join('pasien', 'pasien.kd_pasien', '=', 'kunjungan.kd_pasien')
            ->join('unit', 'unit.kd_unit', '=', 'kunjungan.kd_unit') 
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }else{
            $query              = M_kunjungan::select("*")
            ->with("pasien_to_kunjungan")
            ->with("unit_to_kunjungan")
            ->skip($request->input('start'))
            ->take($request->input('length'))
            ->orderBy($orderBy, $orderDir)
            ->get();
        }
  
        $count = count(M_kunjungan::get());
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

    public function form($id = null){
        $data = [];
        if($id !== null){
            $query = M_kunjungan::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Pendaftaran Pasien", $data);
        return view('cpanel.pages.pendaftaran.form')->with($response);
    }

    public function pagePendaftaran($id = null){
        $data = [];
        if($id !== null){
            $query = M_kunjungan::where("id", "=", $id)->get();
            $data = $query;
        }
        $response = app(\App\Http\Controllers\C_pages::class)->returnTemplate("Pendaftaran Pasien", $data);
        return view('cpanel.pages.pendaftaran.index')->with($response);
    }

    public function getDataPeserta($id = null){
        $url= "http://192.168.100.8:85/asuransi/asuransi-api/api/claim/get_peserta/"; 
		$opts = array('http'=>array('method'=>'GET'));
		$context = stream_context_create($opts);
		$res = json_decode(file_get_contents($url.$id,false,$context));
		return response()->json($res);
    }

    public function create(Request $request){
        $response = array(
            'code' => 200,
            'message' => "Save successful",
            'role' => []
        );

        $params = RSAService::decrypte();
        DB::beginTransaction();
        $find_kunjungan =  M_kunjungan::where("kd_pasien", "=", $params['kd_pasien'])->get();
        if(count($find_kunjungan) == 0){
            $max_urut = 0;
        }else{
            $max_urut = $find_kunjungan[0]->urut_masuk;
        }
       // dd($max_urut);
       
        try {

            $pasien_save = M_pasien::create([
                'kd_pasien' => $params['kd_pasien'],
                'nama' => $params['nama_pasien'],
                'tgl_lahir' => $params['tgl_lahir'],
                'jenis_kelamin' =>$params['jenis_kelamin'],
                'no_asuransi' =>$params['no_asuransi'],
            ]);
    
            $kunjungan_save = M_kunjungan::create([
                'kd_pasien' => $params['kd_pasien'],
                'tgl_masuk' => $params['tgl_masuk'],
                'urut_masuk' => $max_urut+1
            ]);
            if($pasien_save || $kunjungan_save){
                DB::commit();
                $response['code'] = 200;
            }

        }catch(Exception $e) {
            DB::rollBack();
            //  Block of code to handle errors
            $message = $e;
            $response['code'] = 401;
            $response['metadata']['message'] = $message;
            return response()->json($response);
        }    
    
		return response()->json($response);
    }
    
    
}

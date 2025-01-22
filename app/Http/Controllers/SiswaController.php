<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CRUD;
use App\Models\Menu;
use App\Models\SiswaModel;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class SiswaController extends Controller
{
    public function get(){
        $get = SiswaModel::get();
        return response()->json($get);
    }
    public function getstatuspesan(){
        $get = Transaksi::get();
        return response()->json($get);
    }
    public function getMenu()
    {
        $menu = Menu::all();
        return response()->json([
            'status' => true,
            'data' => $menu
        ], 200);
    }
    public function getTransaksiByMonth($id_siswa, $month){
        $validator = Validator::make(['month' => $month],[
            'month' => 'required|integer|min:1|max:12',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $transaksi = Transaksi::where('id_siswa', $id_siswa)
                              ->whereMonth('tanggal', $month)
                              ->get();

        return response()->json([
            'status' => true,
            'data' => $transaksi
        ], 200);
    }
    public function create(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->error()->first()
            ], 400);
        }

        $siswa = new SiswaModel();
        $siswa->nama_siswa = $req->nama_siswa; 
        $siswa->alamat = $req->alamat; 
        $siswa->telp = $req->telp; 
        $siswa->foto = $req->foto->store('public/fotos'); 
        $siswa->id_users = $req->id_users;
        $siswa->save();
        $user = User::find($siswa->id_users);
        $token = JWTAuth::fromUser($user);

        return response()->json([
            'status'=>true,
            'data' => $siswa,
            'message'=>'create sukses'
        ]);
    }

    public function update(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $siswa = SiswaModel::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $siswa->nama_siswa = $req->nama_siswa;
        $siswa->alamat = $req->alamat;
        $siswa->telp = $req->telp;
        if ($req->has('foto')) {
            $siswa->foto = $req->foto->store('public/fotos');
        }
        $siswa->id_users = $req->id_users; 
        $siswa->save();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully updated',
            'data' => $siswa
        ], 200);
    }
           

    public function delete($id){
        $delete = SiswaModel::find($id);

        if(!$delete){
            return response()->json([
                'message'=>'error'
            ]);
        }

        $delete->delete();
        return response()->json([
            'status'=>true,
            'data'=>$delete, 
            'message'=>'Siswa has deleted'
        ]);
    }
    public function cetakNotas($id_transaksi){
        $transaksi = Transaksi::with('details.menu')->find($id_transaksi);
    
        if (!$transaksi) {
            return response()->json([
                'status' => false,
                'message' => 'Transaksi not found'
            ], 404);
        }
    
        $nota = [
            'transaksi' => $transaksi,
            'details' => $transaksi->details
        ];
    
        return response()->json([
            'status' => true,
            'data' => $nota
        ], 200);
    }
    
}

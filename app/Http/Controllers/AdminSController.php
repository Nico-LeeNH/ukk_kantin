<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminS;
use App\Models\CRUD;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSController extends Controller
{
    public function getadmin(){
        $get = AdminS::get();
        return response()->json($get);
    }
    public function createadmin(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_stan' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->error()->first()
            ], 400);
        }

        $siswa = new AdminS();
        $siswa->nama_stan = $req->nama_stan; 
        $siswa->nama_pemilik = $req->nama_pemilik; 
        $siswa->telp = $req->telp; 
        $siswa->id_users = $req->id_users;
        $siswa->save();

        return response()->json([
            'status'=>true,
            'data' => $siswa,
            'message'=>'create sukses'
        ]);
    }

    public function updateadmin(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_stan' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
            'id_users' => 'required|integer', // Tambahkan validasi untuk id_users
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $siswa = AdminS::find($id);

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $siswa->nama_stan = $req->nama_stan;
        $siswa->nama_pemilik = $req->nama_pemilik;
        $siswa->telp = $req->telp;
        $siswa->id_users = $req->id_users; // Tambahkan id_users
        $siswa->save();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully updated',
            'data' => $siswa
        ], 200);
    }
           

    public function deleteadmin($id){
        $delete = AdminS::find($id);

        if(!$delete){
            return response()->json([
                'message'=>'error'
            ]);
        }

        $delete->delete();
        return response()->json([
            'status'=>true,
            'data'=>$delete, // Mengembalikan data yang dihapus
            'message'=>'Siswa has deleted'
        ]);
    }
}

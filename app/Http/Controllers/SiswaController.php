<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CRUD;
use App\Models\Menu;
use App\Models\SiswaModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function get(){
        $get = SiswaModel::get();
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
    public function create(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_siswa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telp' => 'required|string|max:20',
            'foto' => 'required|string|max:255',
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
        $siswa->foto = $req->foto; 
        $siswa->id_users = $req->id_users;
        $siswa->save();

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
            'foto' => 'required|string|max:255',
            'id_users' => 'required|integer', // Tambahkan validasi untuk id_users
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
        $siswa->foto = $req->foto;
        $siswa->id_users = $req->id_users; // Tambahkan id_users
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
            'data'=>$delete, // Mengembalikan data yang dihapus
            'message'=>'Siswa has deleted'
        ]);
    }
}

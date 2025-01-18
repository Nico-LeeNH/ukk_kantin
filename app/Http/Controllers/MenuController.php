<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MenuController extends Controller
{
    public function getmenu(){
        $get = Menu::get();
        return response()->json($get);
    }
    public function createmenu(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_makanan' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jenis' => 'required|string|in:makanan,minuman',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->error()->first()
            ], 400);
        }
        $path = $req->file('foto')->store('public/fotos');
        $menu = new Menu();
        $menu->nama_makanan = $req->nama_makanan; 
        $menu->harga = $req->harga; 
        $menu->jenis = $req->jenis; 
        $menu->foto = $path; 
        $menu->deskripsi = $req->deskripsi; 
        $menu->id_stan = $req->id_stan;
        $menu->save();

        return response()->json([
            'status'=>true,
            'data' => $menu,
            'message'=>'create sukses'
        ]);
    }

    public function updatemenu(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_makanan' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jenis' => 'required|string|in:makanan,minuman',
            'foto' => 'required|file|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string|max:255',
            'id_stan' => 'required|integer', // Tambahkan validasi untuk id_users
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $menu->nama_makanan = $req->nama_makanan;
        $menu->harga = $req->harga;
        $menu->jenis = $req->jenis;
        if ($req->hasFile('foto')) {
            // Hapus file foto lama jika ada
            if ($menu->foto) {
                Storage::delete($menu->foto);
            }
            // Simpan file foto baru
            $path = $req->file('foto')->store('public/fotos');
            $menu->foto = $path;
        }
        $menu->deskripsi = $req->deskripsi;
        $menu->id_stan = $req->id_stan;
        $menu->save();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully updated',
            'data' => $menu
        ], 200);
    }
           

    public function deletemenu($id){
        $delete = menu::find($id);

        if(!$delete){
            return response()->json([
                'message'=>'error'
            ]);
        }

        $delete->delete();
        return response()->json([
            'status'=>true,
            'data'=>$delete, // Mengembalikan data yang dihapus
            'message'=>'menu has deleted'
        ]);
    }
}

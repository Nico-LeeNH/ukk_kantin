<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
                'message' => $validator->errors()->first()
            ], 400);
        }

        $path = $req->file('foto')->store('fotos','public');
        $menu = new Menu();
        $menu->nama_makanan = $req->nama_makanan;
        $menu->harga = $req->harga;
        $menu->jenis = $req->jenis;
        $menu->foto = 'storage/' . $path;
        $menu->deskripsi = $req->deskripsi;
        $menu->id_stan = $req->id_stan;
        $menu->save();

        return response()->json([
            'status' => true,
            'data' => $menu,
            'message' => 'create sukses'
        ]);
    }

    public function updatemenu(Request $req, $id){
        $validator = Validator::make($req->all(), [
            'nama_makanan' => 'required|string|max:255',
            'harga' => 'required|numeric',
            'jenis' => 'required|string|in:makanan,minuman',
            'foto' => 'nullable|file|mimes:jpeg,png,jpg|max:2048',
            'deskripsi' => 'required|string|max:255',
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
            if ($menu->foto) {
                Storage::disk('public')->delete(str_replace('storage/', '', $menu->foto));
            }
            $path = $req->file('foto')->store('fotos', 'public');
            $menu->foto = 'storage/' . $path;
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
        $menu = Menu::find($id);

        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Menu not found'
            ], 404);
        }

        if ($menu->foto) {
            Storage::disk('public')->delete(str_replace('storage/', '', $menu->foto));
        }
        $menu->delete();

        return response()->json([
            'status' => true, 
            'data' => $menu,
            'message' => 'Menu has been deleted'
        ], 200);
    }
}

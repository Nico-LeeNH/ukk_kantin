<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiskonController extends Controller
{
    public function get(){
        $get = Diskon::with('menus')->get();
        return response()->json($get);
    }

    public function creatediskon(Request $req){
        $validator = Validator::make($req->all(),[
            'nama_diskon' => 'required|string|max:255',
            'persentase_diskon' => 'required|numeric',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'id_stan' => 'required|integer',
            'menu_ids' => 'required|array', 
            'menu_ids.*' => 'exists:id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first() // Ganti error dengan errors
            ], 400);
        }

        $diskon = new Diskon();
        $diskon->nama_diskon = $req->nama_diskon; 
        $diskon->persentase_diskon = $req->persentase_diskon; 
        $diskon->tanggal_awal = $req->tanggal_awal; 
        $diskon->tanggal_akhir = $req->tanggal_akhir; 
        $diskon->id_stan = $req->id_stan;
        $diskon->save();
        $diskon->menus()->sync($req->menu_ids);

        return response()->json([
            'status' => true,
            'data' => $diskon,
            'message' => 'create sukses'
        ], 201);
    }

    public function updatediskon(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_diskon' => 'required|string|max:255',
            'persentase_diskon' => 'required|numeric',
            'tanggal_awal' => 'required|date',
            'tanggal_akhir' => 'required|date',
            'id_stan' => 'required|integer',
            'menu_ids' => 'required|array', // Tambahkan validasi untuk menu_ids
            'menu_ids.*' => 'exists:id',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first() // Ganti error dengan errors
            ], 400);
        }

        $diskon = Diskon::find($id);

        if (!$diskon) {
            return response()->json([
                'status' => false,
                'message' => 'Diskon not found'
            ], 404);
        }

        $diskon->nama_diskon = $req->nama_diskon;
        $diskon->persentase_diskon = $req->persentase_diskon;
        $diskon->tanggal_awal = $req->tanggal_awal;
        $diskon->tanggal_akhir = $req->tanggal_akhir;
        $diskon->id_stan = $req->id_stan;
        $diskon->save();

        $diskon->menus()->sync($req->menu_ids);
        
        return response()->json([
            'status' => true,
            'data' => $diskon,
            'message' => 'update sukses'
        ], 200);
    }
    public function deletediskon($id){
        $diskon = Diskon::find($id);

        if (!$diskon) {
            return response()->json([
                'status' => false,
                'message' => 'Diskon not found'
            ], 404);
        }

        // Hapus relasi dengan menu
        $diskon->menus()->detach();
        $diskon->delete();

        return response()->json([
            'status' => true,
            'message' => 'delete sukses'
        ], 200);
    }
}

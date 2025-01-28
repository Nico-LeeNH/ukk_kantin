<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\MenuDiskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DetailTransaksiController extends Controller
{
    public function getdetailtransaksi(){
        $get = DetailTransaksi::get();
        return response()->json($get);
    }
    public function detailtransaksi(Request $req){
        $validator = Validator::make($req->all(),[
            'id_transaksi' => 'required|integer',
            'id_menu' => 'required|integer',
            'qty' => 'required|integer',
            'harga_beli' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
        $menu = Menu::find($req->id_menu);
        if (!$menu) {
            return response()->json([
                'status' => false,
                'message' => 'Menu not found'
            ], 404);
        }

        $menuDiskon = MenuDiskon::where('id_menu', $req->id_menu)->with('diskon')->first();
        $diskonPersentase = $menuDiskon ? $menuDiskon->diskon->persentase_diskon : 0;

        $total_harga = $menu->harga * $req->qty;
        $total_diskon = ($diskonPersentase / 100) * $total_harga;
        $harga_setelah_diskon = $total_harga - $total_diskon;

        $transaksi = new DetailTransaksi();
        $transaksi->id_transaksi = $req->id_transaksi;
        $transaksi->id_menu = $req->id_menu;
        $transaksi->qty = $req->qty;
        $transaksi->harga_beli = $harga_setelah_diskon;
        $transaksi->save();

        return response()->json([
            'status' => true,
            'data' => $transaksi,
            'total_harga' => $total_harga,
            'total_diskon' => $total_diskon,
            'harga_setelah_diskon' => $harga_setelah_diskon,
            'message' => 'create sukses'
        ], 201);
}
}

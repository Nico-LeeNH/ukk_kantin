<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
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

        $transaksi = new DetailTransaksi();
        $transaksi->id_transaksi = $req->id_transaksi;
        $transaksi->id_menu = $req->id_menu;
        $transaksi->qty = $req->qty;
        $transaksi->harga_beli = $req->harga_beli;
        $transaksi->save();

        return response()->json([
            'status' => true,
            'data' => $transaksi,
            'message' => 'create sukses'
        ], 201);
}
}

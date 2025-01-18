<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransaksiController extends Controller
{
    public function gettransaksi(){
        $get = Transaksi::get();
        return response()->json($get);
    }
    public function transaksi(Request $req){
        $validator = Validator::make($req->all(),[
            'tanggal' => 'required|date',
            'id_stan' => 'required|integer',
            'id_siswa' => 'required|integer',
            'status' => 'required|string|in:belum dikonfirm,diantar,dimasak,sampai',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $transaksi = new Transaksi();
        $transaksi->tanggal = $req->tanggal;
        $transaksi->id_stan = $req->id_stan;
        $transaksi->id_siswa = $req->id_siswa;
        $transaksi->status = $req->status;
        $transaksi->save();

        return response()->json([
            'status' => true,
            'data' => $transaksi,
            'message' => 'create sukses'
        ], 201);
}
public function updatetransaksi(Request $req, $id)
{
    // Validasi input
    $validator = Validator::make($req->all(), [
        'tanggal' => 'required|date',
        'id_stan' => 'required|integer',
        'id_siswa' => 'required|integer',
        'status' => 'required|string|in:belum dikonfirm,diantar,dimasak,sampai',
    ]);

    // Jika validasi gagal
    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => $validator->errors()->first(),
        ], 400);
    }

    // Mencari data transaksi berdasarkan ID
    $transaksi = Transaksi::find($id);

    // Jika data tidak ditemukan
    if (!$transaksi) {
        return response()->json([
            'status' => false,
            'message' => 'Data not found',
        ], 404);
    }

    // Memperbarui data transaksi
    $transaksi->tanggal = $req->tanggal;
    $transaksi->id_stan = $req->id_stan;
    $transaksi->id_siswa = $req->id_siswa;
    $transaksi->status = $req->status;
    $transaksi->save();

    // Mengembalikan respons sukses
    return response()->json([
        'status' => true,
        'data' => $transaksi,
        'message' => 'Data successfully updated',
    ], 200);
}

}

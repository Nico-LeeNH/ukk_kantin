<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdminS;
use App\Models\CRUD;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminSController extends Controller
{
    public function getadmin(){
        $get = AdminS::get();
        return response()->json($get);
    }
    public function getRekapPemasukanByMonth($month, $year){
        $validator = Validator::make(['month' => $month, 'year' => $year],[
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2000|max:'.date('Y'),
        ]);
    
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }
    
        $totalPemasukan = DetailTransaksi::whereMonth('created_at', $month)
                                         ->whereYear('created_at', $year)
                                         ->sum('harga_beli');
    
        return response()->json([
            'status' => true,
            'total_pemasukan' => $totalPemasukan
        ], 200);
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

        $stan = new AdminS();
        $stan->nama_stan = $req->nama_stan; 
        $stan->nama_pemilik = $req->nama_pemilik; 
        $stan->telp = $req->telp; 
        $stan->id_users = $req->id_users;
        $stan->save();

        return response()->json([
            'status'=>true,
            'data' => $stan,
            'message'=>'create sukses'
        ]);
    }

    public function updateadmin(Request $req, $id){
        $validator = Validator::make($req->all(),[
            'nama_stan' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'telp' => 'required|string|max:20',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $stan = AdminS::find($id);

        if (!$stan) {
            return response()->json([
                'status' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $stan->nama_stan = $req->nama_stan;
        $stan->nama_pemilik = $req->nama_pemilik;
        $stan->telp = $req->telp;
        $stan->id_users = $req->id_users; // Tambahkan id_users
        $stan->save();

        return response()->json([
            'status' => true,
            'message' => 'Data successfully updated',
            'data' => $stan
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
            'message'=>'stan has deleted'
        ]);
    }
}

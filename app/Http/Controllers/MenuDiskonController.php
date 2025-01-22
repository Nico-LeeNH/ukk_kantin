<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\MenuDiskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MenuDiskonController extends Controller
{
    public function getmenudiskon(){
        $get = MenuDiskon::get();
        return response()->json($get);
    }
    public function creatediskonmenu(Request $req){
        $validator = Validator::make($req->all(),[
            'id_menu' => 'required|integer',
            'id_diskon' => 'required|integer',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first()
            ], 400);
        }

        $diskonmenu = new MenuDiskon();
        $diskonmenu->id_menu = $req->id_menu;
        $diskonmenu->id_diskon = $req->id_diskon;
        $diskonmenu->save();

        return response()->json([
            'status' => true,
            'data' => $diskonmenu,
            'message' => 'create sukses'
        ], 201);
}
}
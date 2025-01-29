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

        $existingMenu = MenuDiskon::where('id_menu', $req->id_menu)->first();
        if ($existingMenu) {
            return response()->json([
                'status' => false,
                'message' => 'Menu sudah memiliki diskon lain'
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
    public function updatediskonmenu(Request $req, $id){
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
        $diskon = MenuDiskon::find($id);
        if (!$diskon) {
            return response()->json([
                'status' => false,
                'message' => 'Diskon not found'
            ], 404);
        }
    
        $diskon->id_menu = $req->id_menu;
        $diskon->id_diskon = $req->id_diskon;
        $diskon->save();

        return response()->json([
            'status' => true,
            'data' => $diskon,
            'message' => 'update sukses'
        ], 201);
}
public function deletemenudiskon($id){
    $diskon = MenuDiskon::find($id);

    if (!$diskon) {
        return response()->json([
            'status' => false,
            'message' => 'MenuDiskon not found'
        ], 404);
    }
    $diskon->delete();
    return response()->json([
        'status' => true,
        'message' => 'delete sukses'
    ], 200);
}


}
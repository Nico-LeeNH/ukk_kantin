<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AddSiswaId
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if ($user && $user->role === 'siswa') { // Pastikan pengguna memiliki peran siswa
            // Tambahkan id_siswa ke dalam request
            $siswa = \App\Models\SiswaModel::where('id_users', $user->id)->first();
            if ($siswa) {
                $request->merge(['id_siswa' => $siswa->id]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Siswa not found'
                ], 404);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized'
            ], 403);
        }
        return $next($request);
    }
}

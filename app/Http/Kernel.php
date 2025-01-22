<?php
// filepath: /c:/xampp/htdocs/ukk_kantin/app/Http/Kernel.php
namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array
     */
    protected $middleware = [
        // ...
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [
            // ...
        ],

        'api' => [
            // ...
            \App\Http\Middleware\AddUserIdFromRole::class, // Tambahkan middleware di sini
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'jwt.auth' => \App\Http\Middleware\JwtMiddleware::class,
        'role.siswa' => \App\Http\Middleware\AddSiswaId::class,
    ];
}
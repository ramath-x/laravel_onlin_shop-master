<?php

use App\Http\Controllers\admin\adminHomeController as AdminAdminHomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminLogincontroller;
use App\Http\Controllers\admin\adminHomeController;
use App\Http\Controllers\admin\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// admin/....
Route::group(['prefix' => 'admin'], function () {
    Route::group(['middleware' => 'admin.guest'], function () {
        Route::get('/login', [AdminLogincontroller::class, 'index'])->name('admin.login');
        Route::post('/authenticate', [AdminLogincontroller::class, 'authenticate'])->name('admin.authenticate');
    });

    Route::group(['middleware' => 'admin.auth'], function () {
        Route::get('/dashboard', [adminHomeController::class, 'index'])->name('admin.dashboard');
        Route::get('/logout', [adminHomeController::class, 'logout'])->name('admin.logout');

        // Categores Route
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');

        Route::get(
            '/getSlug',
            function (Request $request) {

                $slug = '';
                if (!empty($request->name)) {
                    $slug = Str::slug($request->name);
                }

                return response()->json([
                    'status' => true,
                    'slug' => $slug
                ]);
            }

        )->name('categories.getSlug');
    });
});
